<?php

namespace app\db;

require_once __DIR__ . '/../config.php';

use app\internalApi\exceptions\BadDBConnectionException;
use \RedBeanPHP\R as R;


class DataBaseConnect {

    public function getConnect(array $db)
    {
        R::setup("mysql:host={$db['host']};dbname={$db['dbname']}", $db['user'], $db['pass']);

        if (!R::testConnection()) {
            throw new BadDBConnectionException();
        }
    }
}