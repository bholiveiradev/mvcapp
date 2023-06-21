<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Response;

abstract class Controller
{
    protected function render(string $view, array $data = [])
    {
        $path = VIEW_PATH . '/' . $view . '.php';

        if (!file_exists($path)) {
            throw new \Exception("View not implemented: {$path}");
        }

        extract($data);

        ob_start();
        
        include $path;
        
        $content = ob_get_clean();

        return $content;
    }

    protected function view(string $view, array $data = [])
    {
        $renderView = $this->render($view, $data);
        
        (new Response())->send($renderView);
    }
}