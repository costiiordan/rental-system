<?php

$maintenance = __DIR__.'/../laravel/storage/framework/maintenance.php';
$autoload = __DIR__.'/../laravel/vendor/autoload.php';
$bootstrap = __DIR__.'/../laravel/bootstrap/app.php';
$appHost = 'shared';

if ($_SERVER['APP_URL'] === 'http://localhost') {
    $maintenance = __DIR__.'/../storage/framework/maintenance.php';
    $autoload = __DIR__.'/../vendor/autoload.php';
    $bootstrap = __DIR__.'/../bootstrap/app.php';
    $appHost = 'localhost';
}

define('APP_HOST', $appHost);

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance)) {
    require $maintenance;
}

// Register the Composer autoloader...
require $autoload;

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once $bootstrap;

$app->handleRequest(Request::capture());
