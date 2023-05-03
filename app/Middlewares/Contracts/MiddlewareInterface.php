<?php

namespace App\Middlewares\Contracts;

use App\Http\Request;
use App\Http\Response;
use Closure;

interface MiddlewareInterface
{
    public function handle(Request $request, Response $response, Closure $next): void;
}