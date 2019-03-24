<?php

namespace app\internalApi\procedures\user;

use app\internalApi\models\User;
use app\internalApi\services\HttpService;
use Exception;

class UserInfo implements IUser
{
    const HTTP_METHOD = 'GET';

    /**
     * @var string
     */
    private $params;

    /**
     * UserInfo constructor.
     * @param string $params
     * @throws Exception
     */
    public function __construct(string $params)
    {
        (new HttpService())->checkMethodHttp(static::HTTP_METHOD);
        $this->params = $params;
    }

    /**
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function get(int $userId): array
    {
        $dataUser = (new User)->get($userId);

        if (empty($dataUser[0])) {
            throw new Exception('User with this ID was not found in the database', 403);
        }

        return $dataUser[0];
    }
}