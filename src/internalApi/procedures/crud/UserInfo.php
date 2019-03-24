<?php

namespace app\internalApi\procedures\crud;

use app\internalApi\models\{Token,User};
use app\internalApi\services\HttpService;

class UserInfo implements IUser
{
    const HTTP_METHOD = 'GET';

    /**
     * @var string
     */
    private $params;

    /**
     * UserInfo constructor.
     * @throws \Exception
     */
    public function __construct(string $params)
    {
        (new HttpService())->checkMethodHttp(static::HTTP_METHOD);
        $this->params = $params;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function get(int $userId): array
    {
        return (new User)->get($userId)[0];
    }
}