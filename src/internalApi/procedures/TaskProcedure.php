<?php

namespace app\internalApi\procedures;

use app\internalApi\services\{HttpService, TokenService};
use app\internalApi\procedures\task\{StartTask, ResultTask};
use Exception;

class TaskProcedure implements IResponseProcedures
{
    const MAP_METHOD = [
        'POST' => StartTask::class,
        'GET' => ResultTask::class
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
     * TaskProcedure constructor.
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
     * @return string
     */
    public function get(): string
    {
        return (new $this->handler($this->params))->get($this->id);
    }


    public function map()
    {
        $method = (new HttpService)->getHttpMethod();

        if (array_key_exists($method,static::MAP_METHOD) === false) {
            throw new Exception('This transfer method is not encrypted');
        }

        $this->handler = static::MAP_METHOD[$method];
    }
}