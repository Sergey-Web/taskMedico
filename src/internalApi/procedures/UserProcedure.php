<?php

namespace app\internalApi\procedures;


use app\internalApi\procedures\crud\UserAdd;
use app\internalApi\procedures\crud\UserInfo;
use app\internalApi\procedures\crud\UserUpdate;
use app\internalApi\services\HttpService;
use app\internalApi\services\UserService;
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
     * @var UserService
     */
    private $userService;

    /**
     * UserProcedure constructor.
     * @param int $id
     * @param string $params
     * @throws \Exception
     */
    public function __construct(int $id, string $params)
    {
        $this->userService = new UserService();
        $this->userService->checkAuthToken($id);
        $this->id = $id;
        $this->map($id);
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function get(): string
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