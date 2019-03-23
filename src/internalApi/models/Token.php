<?php

namespace app\internalApi\models;

use app\internalApi\exceptions\TokenUpdateErrorExceptions;
use app\internalApi\services\TokenService;
use \RedBeanPHP\R as R;

class Token {

    const TABLE_NAME = 'tokens';

    public function getUserIdByToken(string $userToken): string
    {
        return R::getCell("
              SELECT user_id 
              FROM " . static::TABLE_NAME . "
              WHERE token = :token",
            [':token' => $userToken]
        );
    }

    /**
     * @param int $userId
     * @return string
     */
    public function get(int $userId)
    {
        return R::getAll("
            SELECT token
            FROM ".self::TABLE_NAME."
            WHERE user_id = :user_id",
            [':user_id' => $userId]
        );
    }

    /**
     * @param int $userId
     * @param string $tokenGenerate
     * @return string
     * @throws TokenUpdateErrorExceptions
     */
    public function createToken(int $userId, string $tokenGenerate): string
    {
        $token = R::dispense(static::TABLE_NAME);
        $token->user_id = $userId;
        $token->token = $tokenGenerate;

        if (!R::store($token)) {
            throw new TokenUpdateErrorExceptions();
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
        $tokenUpdate = R::exec( "
                          UPDATE ".static::TABLE_NAME."  
                          SET user_id = :user_id, token = '{$token}'",
                            [
                                ':user_id' => $userId
                            ]
                        );

        if (!$tokenUpdate) {
            throw new TokenUpdateErrorExceptions();
        }

        return $token;
    }

    /**
     * @param int $userId
     * @return bool
     * @throws TokenUpdateErrorExceptions
     */
    public function updateDate(int $userId): bool
    {
        $tokenUpdate = R::exec( "
                          UPDATE ".static::TABLE_NAME."  
                          SET user_id = :user_id'",
                            [
                                'user_id' => $userId
                            ]
                        );

        if (!$tokenUpdate) {
            throw new TokenUpdateErrorExceptions();
        }

        return $tokenUpdate;
    }
}