<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/config.php';

use app\db\DataBaseConnect;
use app\internalApi\services\HandlerRequest;
use app\internalApi\services\HandlerResponse;

if (empty($_GET['route'])) {
    echo 'Welcome to API!';
    return;
}

$request = new HandlerRequest($_GET['route']);

(new DataBaseConnect)->getConnect(DB);

$response = new HandlerResponse($request->getHandler());

echo $response->get();

