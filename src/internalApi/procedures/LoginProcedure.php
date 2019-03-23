<?php

namespace app\internalApi\procedures;

use app\internalApi\models\Token;
use app\internalApi\services\LoginService;
use app\internalApi\services\TokenService;

class LoginProcedure implements IResponseProcedures
{
    /**
     * @var Token
     */
    private $token;

    /**
     * @var string
     */
    private $params;

    /**
     * @var LoginService
     */
    private $loginService;

    /**
     * @var int
     */
    private $id;

    /**
     * Login constructor.
     * @param int $id
     * @param string $params
     */
    public function __construct(int $id, string $params)
    {
        $this->token = new Token();
        $this->loginService = new LoginService();
        $this->params = $params;
    }

    /**
     * @return string
     * @throws \app\internalApi\exceptions\TokenUpdateErrorExceptions
     */
    public function get(): string
    {
        $userId = $this->loginService->checkUser($this->params);

        return $this->token->updateToken($userId, (new TokenService)->generation());
    }
}