<?php

namespace app\internalApi\models;

use app\internalApi\exceptions\{TokenCreateErrorExceptions, TokenUpdateErrorExceptions};
use \RedBeanPHP\R as R;

class Token
{

    const TABLE_NAME = 'tokens';

    /**
     * @param string $userToken
     * @return string
     */
    public function getUserIdByToken(string $userToken): string
    {
        return R::getCell("
              SELECT user_id 
              FROM " . static::TABLE_NAME . "
              WHERE token = :token",
            [':token' => $userToken]
        );
    }

    public function getDateToken(string $token): string
    {
        return R::getCell("
              SELECT date
              FROM " . static::TABLE_NAME . "
              WHERE token = :token",
            [':token' => $token]
        );
    }

    /**
     * @param int $userId
     * @return array
     */
    public function get(int $userId)
    {
        return R::getAll("
            SELECT token
            FROM " . self::TABLE_NAME . "
            WHERE user_id = :user_id",
            [':user_id' => $userId]
        );
    }

    /**
     * @param int $userId
     * @param string $tokenGenerate
     * @return string
     * @throws TokenCreateErrorExceptions
     */
    public function createToken(int $userId, string $tokenGenerate): string
    {
        $token = R::dispense(static::TABLE_NAME);
        $token->user_id = $userId;
        $token->token = $tokenGenerate;

        if (!R::store($token)) {
            throw new TokenCreateErrorExceptions();
        }

        return $tokenGenerate;
    }

    /**
     * @param int $userId
     * @param string $token
     * @return string
     * @throws TokenUpdateErrorExceptions
     */
    public function updateToken(int $userId, string $token): string
    {
        $tokenUpdate = R::exec("
          INSERT INTO " . static::TABLE_NAME . "(user_id, token, date) 
          VALUES ({$userId}, '{$token}', NOW())
          ON DUPLICATE KEY UPDATE token = '{$token}'
       ");

        if (!$tokenUpdate) {
            throw new TokenUpdateErrorExceptions();
        }

        return $token;
    }

    /**
     * @param int $userId
     * @throws TokenUpdateErrorExceptions
     */
    public function updateDate(int $userId)
    {
        $tokenUpdate = R::exec("
          UPDATE " . static::TABLE_NAME . "  
          SET date = NOW() WHERE user_id = :user_id",
            [
                'user_id' => $userId
            ]
        );
    }
}