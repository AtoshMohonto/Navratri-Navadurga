<?php

namespace App\Controllers\Admin;

use App\Core\Request;
use App\Repositories\UserRepository;
use App\Validators\Validator;

class UserController extends AdminCrudController
{
    public function __construct()
    {
        $this->repo = new UserRepository();
        $this->title = 'ব্যবহারকারী';
        $this->routeBase = 'admin/users';
        $this->orderBy = 'created_at DESC';
        $this->searchColumns = ['name', 'email'];
        $this->listColumns = ['name', 'email', 'role_id', 'status'];

        $this->fields = [
            ['key' => 'name', 'label' => 'নাম', 'type' => 'text', 'required' => true],
            ['key' => 'email', 'label' => 'ইমেইল', 'type' => 'text', 'required' => true],
            ['key' => 'password', 'label' => 'পাসওয়ার্ড', 'type' => 'text', 'hint' => 'নতুন ব্যবহারকারীর জন্য আবশ্যক; সম্পাদনার সময় ফাঁকা রাখলে পুরনো পাসওয়ার্ড বহাল থাকবে'],
            ['key' => 'role_id', 'label' => 'ভূমিকা', 'type' => 'select', 'options' => [1 => 'ব্যবহারকারী', 2 => 'অ্যাডমিন'], 'required' => true],
            ['key' => 'status', 'label' => 'অবস্থা', 'type' => 'select', 'options' => ['active' => 'সক্রিয়', 'banned' => 'নিষিদ্ধ'], 'required' => true],
        ];
    }

    protected function rules(bool $isUpdate, $id = null): array
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email' . ($id ? ",{$id}" : ''),
            'role_id' => 'required',
            'status' => 'required',
        ];
        if (!$isUpdate) {
            $rules['password'] = 'required|min:8';
        }
        return $rules;
    }

    protected function collectData(Request $request): array
    {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role_id' => (int) $request->input('role_id'),
            'status' => $request->input('status'),
        ];

        $password = $request->input('password');
        if (!empty($password)) {
            $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        return $data;
    }
}
