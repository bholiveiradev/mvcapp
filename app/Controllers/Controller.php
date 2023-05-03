<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Response;

abstract class Controller
{
    protected function render(string $view, array $data = [])
    {
        $templatePath = VIEW_PATH . '/' . $view . '.php';

        if (!file_exists($templatePath)) {
            throw new \Exception("Template not found: $templatePath");
        }

        extract($data);

        ob_start();
        
        include $templatePath;
        
        $content = ob_get_clean();

        return $content;
    }

    protected function view(string $view, array $data = [])
    {
        $response = new Response;
        $renderedView = $this->render($view, $data);
        
        $response->send($renderedView);
    }
}