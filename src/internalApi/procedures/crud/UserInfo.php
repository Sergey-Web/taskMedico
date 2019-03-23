<?php

namespace app\internalApi\procedures\crud;

use app\internalApi\models\{Token,User};
use app\internalApi\services\HttpService;

class UserInfo implements IUser
{
    const HTTP_METHOD = 'GET';

    /**
     * @var User
     */
    private $user;

    /**
     * @var Token
     */
    private $token;

    /**
     * @var string
     */
    private $params;

    /**
     * @var HttpService
     */
    private $httpService;

    /**
     * UserInfo constructor.
     * @param string $params
     * @throws \Exception
     */
    public function __construct(string $params)
    {
        $this->httpService = new HttpService();
        $this->httpService->checkMethodHttp(static::HTTP_METHOD);
        $this->user = new User();
        $this->token = new Token();
        $this->params = $params;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function get(int $userId)
    {

        return $this->user->get($userId, $this->params)[0];
    }
}