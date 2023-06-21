<?php

use App\Controllers\Admin\{
    DashboardController,
    ProductController,
    TestController,
    UserController
};
use App\Middlewares\{
    AuthMiddleware,
    ExampleMiddleware
};

// PUBLIC ROUTES
$router->get('/', function ($request) {
    echo 'HOME WEBSITE';
});

// ADMIN GROUP ROUTES
$router->middlewares([AuthMiddleware::class])->group('/admin', function ($router) {
    $router->get('/test', TestController::class);
    $router->get('/dashboard', [DashboardController::class, 'index'], [ExampleMiddleware::class]);
    $router->get('/users', [UserController::class, 'index'], [ExampleMiddleware::class]);
    
    // PRODUCTS ROUTES
    $router->get('/products', [ProductController::class, 'index']);
    $router->get('/products/create', [ProductController::class, 'create']);
    $router->post('/products', [ProductController::class, 'store']);
    $router->get('/products/{id}', [ProductController::class, 'show']);
    $router->get('/products/{id}/edit', [ProductController::class, 'edit']);
    $router->put('/products/{id}', [ProductController::class, 'update']);
    $router->delete('/products/{id}', [ProductController::class, 'delete']);
});
