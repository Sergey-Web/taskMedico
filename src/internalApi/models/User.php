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
              LEFT JOIN phones AS p ON u.id = p.user_id 
              WHERE u.id = :id",
            [
                ':id' => $userId
            ]
        );
    }

    /**
     * @param string $email
     * @return int
     */
    public function getUserId(string $email): int
    {
        return (int) R::getCell("
              SELECT id 
              FROM " . static::TABLE_NAME . "
              WHERE email = :email",
            [':email' => $email]
        );
    }

    /**
     * @param string $email
     * @return string
     */
    public function getPass(string $email): string
    {
        return R::getCell("
              SELECT password 
              FROM " . static::TABLE_NAME . "
              WHERE email = :email",
            [
                ':email' => $email
            ]
        );
    }
}