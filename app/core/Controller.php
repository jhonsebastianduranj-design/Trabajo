<?php

namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        $config = require __DIR__ . '/../config/config.php';
        $basePath = __DIR__ . '/../views/';

        include $basePath . 'partials/header.php';
        include $basePath . $view . '.php';
        include $basePath . 'partials/footer.php';
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }
}
