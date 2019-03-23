<?php

namespace app\internalApi\models;

use \RedBeanPHP\R as R;

class Access
{
    const TABLE_NAME = 'accesses';

    public function getAccessUserByToken(string $userToken)
    {
        return R::getCell("
              SELECT a.access 
              FROM " . static::TABLE_NAME . " AS a
              JOIN users AS u ON a.user_id = u.id
              JOIN tokens AS t ON u.id = t.user_id
              WHERE t.token = :token",
            [':token' => $userToken]
        );
    }
}