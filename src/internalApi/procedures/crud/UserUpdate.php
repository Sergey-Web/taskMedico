<?php

namespace app\internalApi\procedures\crud;

use app\internalApi\models\{Access, Token, User};
use app\internalApi\services\{HttpService, UserService};

class UserUpdate implements IUser
{
    const HTTP_METHOD = 'PATCH';

    /**
     * @var string
     */
    private $params;


    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserUpdate constructor.
     * @param string $params
     * @throws \Exception
     */
    public function __construct(string $params)
    {
        $this->userService = new UserService();
        (new HttpService())->checkMethodHttp(static::HTTP_METHOD);
        $this->userService->checkAccessAdmin();
        $this->params = $params;
    }

    /**
     * @param int $userId
     * @return string
     * @throws \Exception
     */
    public function get(int $userId): array
    {
        $this->userService->updateUserTransaction($userId, $this->params);
var_dump((new User)->get($userId));die;
        //return;
    }
}