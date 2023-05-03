<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Http\Request;
use App\Http\Response;

class DashboardController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $response->send('DASHBOARD');
    }
}