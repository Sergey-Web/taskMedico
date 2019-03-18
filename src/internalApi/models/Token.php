<?php

namespace app\internalApi\models;

use app\internalApi\exceptions\TokenUpdateErrorExceptions;
use app\internalApi\services\TokenService;
use DateTime;
use \RedBeanPHP\R as R;

class Token {

    const TABLE_NAME = 'tokens';

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
     * @return string
     * @throws TokenUpdateErrorExceptions
     */
    public function createToken(int $userId): string
    {
        $tokenGenerate = (new TokenService)->generation();
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
     * @return string
     * @throws TokenUpdateErrorExceptions
     */
    public function updateToken(int $userId): string
    {
        $tokenGenerate = (new TokenService)->generation();

        $tokenUpdate = R::exec( "
                          UPDATE ".static::TABLE_NAME."  
                          SET user_id = {$userId}, token ='{$tokenGenerate}'
                        ");

        if (!$tokenUpdate) {
            throw new TokenUpdateErrorExceptions();
        }

        return $tokenGenerate;
    }

    /**
     * @param int $userId
     * @return bool
     * @throws TokenUpdateErrorExceptions
     */
    public function updateDate(int $userId): bool
    {
        $date = (new DateTime())->format('Y-m-d h:i:s');
        $tokenUpdate = R::exec( "
                          UPDATE ".static::TABLE_NAME."  
                          SET user_id = {$userId}, date = '{$date}'
                        ");

        if (!$tokenUpdate) {
            throw new TokenUpdateErrorExceptions();
        }

        return $tokenUpdate;
    }
}