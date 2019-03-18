<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/config.php';

use app\db\DataBaseConnect;
use app\internalApi\services\HandlerRequest;
use app\internalApi\services\HandlerResponse;

(new DataBaseConnect)->getConnect(DB);

if (empty($_GET['route'])) {
    echo 'Welcome to API!';
    return;
}

try {
    $values = file_get_contents('php://input');
    $request = new HandlerRequest($_GET['route'], $values);
    $response = new HandlerResponse($request->getHandler());
    echo $response->get();
} catch (Exception $e) {
    echo $e->getMessage();
}




