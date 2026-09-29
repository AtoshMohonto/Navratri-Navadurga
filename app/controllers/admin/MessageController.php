<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Repositories\ContactRepository;

class MessageController extends Controller
{
    protected string $layout = 'layouts/admin';

    public function index(Request $request): void
    {
        $repo = new ContactRepository();
        $page = max(1, (int) $request->query('page', 1));
        $result = $repo->paginate($page, 15, [], 'created_at DESC');

        $this->view('admin/messages', [
            'title' => 'বার্তা',
            'messages' => $result['data'],
            'pagination' => $result,
        ]);
    }

    public function markRead(Request $request, $id): void
    {
        (new ContactRepository())->update($id, ['status' => 'read']);
        $this->redirect('/admin/messages');
    }

    public function destroy(Request $request, $id): void
    {
        (new ContactRepository())->delete($id);
        Session::flash('success', 'বার্তা মুছে ফেলা হয়েছে।');
        $this->redirect('/admin/messages');
    }
}
