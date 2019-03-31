<?php

namespace app\internalApi\procedures;

use app\internalApi\services\{HttpService, TokenService};
use app\internalApi\procedures\task\{StartTask, ResultTask, ProcessingTask};
use Exception;

class TaskProcedure implements IResponseProcedures
{

    private $methodsMap = [
        'POST' => StartTask::class,
        'GET' => ResultTask::class,
        'PUT' => ProcessingTask::class
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


    public function get()
    {
        (new $this->handler($this->params))->get($this->id);
    }

    /**
     * @throws Exception
     */
    private function map()
    {
        $method = (new HttpService)->getHttpMethod();

        if (array_key_exists($method, $this->methodsMap) === false) {
            throw new Exception('This transfer method is not encrypted');
        }

        $this->handler = $this->methodsMap[$method];
    }
}