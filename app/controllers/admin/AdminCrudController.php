<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Repository;
use App\Core\Request;
use App\Core\Session;
use App\Validators\Validator;

/**
 * Generic, reusable CRUD controller that admin entity controllers extend.
 * Subclasses declare a repository + a field schema; index/form rendering,
 * validation, search, pagination and file upload are handled here once.
 */
abstract class AdminCrudController extends Controller
{
    protected string $layout = 'layouts/admin';
    protected Repository $repo;

    /** @var array<int,array{key:string,label:string,type:string,options?:array,required?:bool}> */
    protected array $fields = [];
    protected array $listColumns = [];
    protected array $searchColumns = [];
    protected string $title = '';
    protected string $routeBase = '';
    protected string $orderBy = 'id DESC';
    protected int $perPage = 15;
    protected ?string $imageField = null;
    protected string $uploadSubdir = 'misc';

    public function index(Request $request): void
    {
        $page = max(1, (int) $request->query('page', 1));
        $q = trim((string) $request->query('q', ''));

        $result = $this->repo->searchPaginate($this->searchColumns, $q, $page, $this->perPage, [], $this->orderBy);

        $this->view('admin/crud/index', [
            'items' => $result['data'],
            'pagination' => $result,
            'fields' => $this->fields,
            'listColumns' => $this->listColumns ?: array_slice(array_column($this->fields, 'key'), 0, 4),
            'title' => $this->title,
            'routeBase' => $this->routeBase,
            'q' => $q,
        ]);
    }

    public function create(): void
    {
        $this->view('admin/crud/form', [
            'item' => [],
            'fields' => $this->resolvedFields(),
            'title' => $this->title,
            'routeBase' => $this->routeBase,
            'isEdit' => false,
            'errors' => Session::flash('errors') ?? [],
        ]);
    }

    public function store(Request $request): void
    {
        $data = $this->collectData($request);
        $validator = Validator::make($data, $this->rules(false));

        if ($validator->fails()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $data);
            $this->redirect("/{$this->routeBase}/create");
            return;
        }

        if ($this->imageField) {
            $uploaded = $this->handleUpload($request, $this->imageField);
            if ($uploaded !== null) {
                $data[$this->imageField] = $uploaded;
            }
        }

        $this->repo->insert($data);
        Session::flash('success', $this->title . ' সফলভাবে যোগ করা হয়েছে।');
        $this->redirect("/{$this->routeBase}");
    }

    public function edit(Request $request, $id): void
    {
        $item = $this->repo->find($id);
        if (!$item) {
            $this->abort(404);
            return;
        }

        $this->view('admin/crud/form', [
            'item' => $item,
            'fields' => $this->resolvedFields(),
            'title' => $this->title,
            'routeBase' => $this->routeBase,
            'isEdit' => true,
            'errors' => Session::flash('errors') ?? [],
        ]);
    }

    public function update(Request $request, $id): void
    {
        $item = $this->repo->find($id);
        if (!$item) {
            $this->abort(404);
            return;
        }

        $data = $this->collectData($request);
        $validator = Validator::make($data, $this->rules(true, $id));

        if ($validator->fails()) {
            Session::flash('errors', $validator->errors());
            $this->redirect("/{$this->routeBase}/{$id}/edit");
            return;
        }

        if ($this->imageField) {
            $uploaded = $this->handleUpload($request, $this->imageField);
            if ($uploaded !== null) {
                $data[$this->imageField] = $uploaded;
            } else {
                unset($data[$this->imageField]);
            }
        }

        $this->repo->update($id, $data);
        Session::flash('success', $this->title . ' সফলভাবে আপডেট করা হয়েছে।');
        $this->redirect("/{$this->routeBase}");
    }

    public function destroy(Request $request, $id): void
    {
        $this->repo->delete($id);
        Session::flash('success', $this->title . ' মুছে ফেলা হয়েছে।');
        $this->redirect("/{$this->routeBase}");
    }

    /**
     * Collects submitted values for every declared field (except computed
     * ones like image, which is handled separately via file upload).
     */
    protected function collectData(Request $request): array
    {
        $data = [];
        foreach ($this->fields as $field) {
            if ($field['key'] === $this->imageField) {
                continue;
            }
            if (($field['type'] ?? 'text') === 'checkbox') {
                $data[$field['key']] = $request->input($field['key']) ? 1 : 0;
                continue;
            }
            $data[$field['key']] = $request->input($field['key']);
        }
        return $data;
    }

    protected function rules(bool $isUpdate, $id = null): array
    {
        $rules = [];
        foreach ($this->fields as $field) {
            $r = [];
            if (!empty($field['required'])) {
                $r[] = 'required';
            }
            if (($field['type'] ?? '') === 'email') {
                $r[] = 'email';
            }
            if (!empty($r)) {
                $rules[$field['key']] = implode('|', $r);
            }
        }
        return $rules;
    }

    protected function resolvedFields(): array
    {
        $resolved = [];
        foreach ($this->fields as $field) {
            if (isset($field['optionsResolver']) && is_callable($field['optionsResolver'])) {
                $field['options'] = call_user_func($field['optionsResolver']);
            }
            $resolved[] = $field;
        }
        return $resolved;
    }

    protected function handleUpload(Request $request, string $key): ?string
    {
        $file = $request->file($key);

        if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif'];
        $mime = mime_content_type($file['tmp_name']);

        if (!isset($allowed[$mime])) {
            return null;
        }

        if ($file['size'] > 3 * 1024 * 1024) {
            return null;
        }

        $ext = $allowed[$mime];
        $filename = bin2hex(random_bytes(12)) . '.' . $ext;
        $dir = APP_ROOT . '/public/uploads/' . $this->uploadSubdir;

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        move_uploaded_file($file['tmp_name'], $dir . '/' . $filename);

        return 'uploads/' . $this->uploadSubdir . '/' . $filename;
    }
}
