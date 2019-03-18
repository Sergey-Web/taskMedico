<?php

namespace app\internalApi\procedures\crud;

use app\internalApi\models\{Token,User};
use app\internalApi\services\{HttpService,UserService};

class UserUpdate implements IUser
{
    const HTTP_METHOD = 'PATCH';

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
     * @param array $params
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
     * @return string
     * @throws \Exception
     */
    public function get(int $userId): string
    {
        return (new UserService())->updateUserTransaction($userId, $this->params);
    }
}