<?php

namespace app\internalApi\procedures\user;

use app\internalApi\models\{Access, Token, User};
use app\internalApi\services\{HttpService, TokenService, UserService};

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
     * @return array
     * @throws \Exception
     */
    public function get(int $userId): array
    {
        (new TokenService())->getUserIdByAuthToken();
        $this->userService->updateUserTransaction($userId, $this->params);

        return (new User)->get($userId)[0];
    }
}