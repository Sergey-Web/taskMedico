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

        $userId = $this->checkPass();

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
        $params = json_decode($params, true);

        if (empty($params)) {
            throw new Exception('Authentication data is not transferred or transferred incorrectly');
        }

        if (empty($params['email']) && empty($params['pass'])) {
            throw new Exception('Error, mail or password is not entered');
        }
    }

    private function checkPass(array $params): bool
    {
        $passHash = $this->user->getPass($params['email']);

        return password_verify($params['pass'], $passHash);
    }
}