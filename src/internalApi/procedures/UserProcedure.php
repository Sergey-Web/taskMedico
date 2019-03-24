<?php

namespace app\internalApi\procedures;

use app\internalApi\procedures\user\{UserAdd, UserInfo, UserUpdate};
use app\internalApi\services\{HttpService, TokenService};
use Exception;

class UserProcedure implements IResponseProcedures
{
    const MAP_METHOD = [
        'GET' => UserInfo::class,
        'PATCH' => UserUpdate::class,
        'POST' => UserAdd::class
    ];

    /**
     * @var string
     */
    private $params;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $handler;

    /**
     * UserProcedure constructor.
     * @param int $id
     * @param string $params
     * @throws Exception
     */
    public function __construct(int $id, string $params)
    {
        (new TokenService)->checkToken();
        (new TokenService)->updateDateTimeToken();
        $this->id = $id;
        $this->map($id);
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return (new $this->handler($this->params))->get($this->id);
    }

    /**
     * @throws Exception
     */
    public function map()
    {
        $method = (new HttpService)->getHttpMethod();

        if (array_key_exists($method,static::MAP_METHOD) === false) {
            throw new Exception('This transfer method is not encrypted');
        }

        $this->handler = static::MAP_METHOD[$method];
    }
}