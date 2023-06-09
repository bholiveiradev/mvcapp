<?php

declare(strict_types=1);

namespace App\Controllers\Web;

use App\Controllers\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home/index');
    }
}