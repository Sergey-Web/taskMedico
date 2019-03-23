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

    /**
     * @var array
     */
    private $params;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * @param string $params
     * @return int
     * @throws Exception
     */
    public function checkUser(string $params): int
    {
        $params = json_decode($params, true);
        $this->checkParamsUser($params);
        $this->checkPass($params);

        return $this->user->getUserId($params['email']);
    }

    /**
     * @param array $params
     * @throws Exception
     */
    private function checkParamsUser(array $params)
    {
        if (empty($params)) {
            throw new Exception('Authentication data is not transferred or transferred incorrectly');
        }

        if (empty($params['email']) && empty($params['password'])) {
            throw new Exception('Error, mail or password is not entered');
        }
    }

    /**
     * @param array $params
     * @throws Exception
     */
    private function checkPass(array $params)
    {
        $passHash = $this->user->getPass($params['email']);

        if (password_verify($this->params['password'], $passHash)) {
            throw new Exception('Error, mail or password is not entered');
        }
    }
}