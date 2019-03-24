<?php

namespace app\internalApi\procedures;

use app\internalApi\models\Token;
use app\internalApi\services\{HttpService, LoginService, TokenService};

class LoginProcedure implements IResponseProcedures
{
    const METHOD_HTTP = 'POST';

    /**
     * @var string
     */
    private $params;

    /**
     * LoginProcedure constructor.
     * @param int $id
     * @param string $params
     * @throws \Exception
     */
    public function __construct(int $id, string $params)
    {
        (new HttpService)->checkMethodHttp(static::METHOD_HTTP);
        $this->params = $params;
    }

    /**
     * @return string
     * @throws \app\internalApi\exceptions\TokenUpdateErrorExceptions
     */
    public function get(): string
    {
        $userId = (new LoginService())->checkUser($this->params);

        return (new Token())->updateToken($userId, (new TokenService)->generation());
    }
}