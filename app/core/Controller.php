<?php

namespace App\Core;

class Controller
{
    protected string $layout = 'layouts/app';

    protected function view(string $view, array $data = [], ?string $layout = null): void
    {
        $layout = $layout ?? $this->layout;
        $viewFile = dirname(__DIR__) . '/views/' . $view . '.php';

        if (!is_file($viewFile)) {
            throw new \RuntimeException("View not found: {$view}");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        if ($layout === null) {
            echo $content;
            return;
        }

        $layoutFile = dirname(__DIR__) . '/views/' . $layout . '.php';
        require $layoutFile;
    }

    protected function json($data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    protected function redirect(string $path): void
    {
        $base = Env::get('APP_BASE_PATH', '');
        header('Location: ' . $base . $path);
        exit;
    }

    protected function abort(int $status, string $view = null): void
    {
        http_response_code($status);
        $view = $view ?? "errors/{$status}";
        $file = dirname(__DIR__) . "/views/{$view}.php";
        if (is_file($file)) {
            require $file;
        }
        exit;
    }
}
