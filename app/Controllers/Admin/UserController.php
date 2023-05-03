<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Http\Request;
use App\Http\Response;

class UserController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $response->send('ADMIN USER CONTROLLER');
    }
}