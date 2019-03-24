<?php

namespace app\internalApi\procedures\user;

use app\internalApi\models\{Token,User};
use app\internalApi\services\{HttpService,UserService};

class UserAdd implements IUser
{
    const HTTP_METHOD = 'POST';

    /**
     * @var string
     */
    private $params;

    /**
     * @var UserService
     */
    private $userService;


    /**
     * UserInfo constructor.
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
     * @return array
     * @throws \Exception
     */
    public function get(int $userId): array
    {
        $userCreateId = (new UserService())->createUserTransaction($this->params);

        return (new User)->get($userCreateId)[0];
    }
}