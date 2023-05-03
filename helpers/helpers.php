<?php

if (! function_exists('dd')) {
    function dd(mixed $var, ...$moreVars)
    {
        dump($var, ...$moreVars);
        exit();
    }
}

if (! function_exists('redirect')) {
    function redirect(string $path = '/')
    {
        header('Location: ' . APP_URL . $path);
        exit();
    }
}

if (! function_exists('back')) {
    function back()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}