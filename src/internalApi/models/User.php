<?php

namespace app\internalApi\models;

use \RedBeanPHP\R as R;

class User
{
    const TABLE_NAME = 'users';

    public function getDataUsers(array $data)
    {

    }

    /**
     * @param int $userId
     * @return array
     */
    public function get(int $userId)
    {
        return R::getAll("
              SELECT u.email, u.created_at, n.name, p.phone 
              FROM " . static::TABLE_NAME . " AS u 
              LEFT JOIN names AS n ON u.id = n.user_id 
              LEFT JOIN phones AS p ON u.id = n.user_id 
              WHERE u.id = :id",
            [
                ':id' => $userId
            ]
        );
    }

    /**
     * @param array $data
     * @return bool
     */
    public function check(array $data): bool
    {
        return (bool) R::getCell("
              SELECT id 
              FROM " . static::TABLE_NAME . "
              WHERE email = :email AND password = :pass",
            [':email' => $data['email'], ':pass' => $data['password']]
        );
    }

    public function getPass(string $email)
    {
        return R::getAll("
              SELECT password 
              FROM " . static::TABLE_NAME . "
              WHERE email = :email",
            [
                ':email' => $email
            ]
        );
    }
}