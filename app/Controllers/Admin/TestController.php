<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;

class TestController extends Controller
{
    public function __invoke()
    {
        echo 'INVOKING TEST HERE...';
    }
}