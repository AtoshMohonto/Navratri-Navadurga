<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Repositories\SevaLogRepository;

class SevaLogController extends Controller
{
    public function mine(Request $request): void
    {
        $this->view('pages/my-seva', [
            'title' => 'আমার সেবা',
            'breadcrumbs' => [['label' => 'আমার সেবা']],
            'logs' => (new SevaLogRepository())->forUser(Auth::id()),
        ]);
    }
}
