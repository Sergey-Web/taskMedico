<?php

namespace app\internalApi\services;

use app\internalApi\models\User;
use Exception;

class LoginService
{
    /**
     * @var User
     */
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * @param string $params
     * @return bool
     * @throws Exception
     */
    public function checkUser(string $params): bool
    {
        $this->checkParamsUser($params);
        $userId = (int) $this->user->check(json_decode($params, true));

        if (!$userId) {
            throw new Exception('Authentication data is not transferred or transferred incorrectly');
        }

        return $userId;
    }

    /**
     * @param string $params
     * @throws Exception
     */
    private function checkParamsUser(string $params)
    {
        if (empty(json_decode($params, true))) {
            throw new Exception('Authentication data is not transferred or transferred incorrectly');
        }
    }
}