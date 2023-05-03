<?php

session_start();

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use App\Http\Router;

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config/app.php');

$whoops = new Run();
$whoops->pushHandler(new PrettyPageHandler());
$whoops->register();

$router = new Router();

require_once(ROOT_PATH . '/routes/routes.php');

$router->run();