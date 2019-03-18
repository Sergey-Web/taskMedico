<?php

namespace app\internalApi\services;

use app\internalApi\exceptions\ProcedureIncorrectException;
use app\internalApi\procedures\IResponseProcedures;
use app\internalApi\procedures\LoginProcedure;
use app\internalApi\procedures\UserProcedure;

class HandlerRequest implements IHandlerRequest
{
    const PAGES_ACCESS = [
        'login' => LoginProcedure::class,
        'user' => UserProcedure::class,
//        'task' => Task::class,
    ];

    /**
     * @var IResponseProcedures
     */
    private $procedure;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $params;

    /**
     * HandlerRequest constructor.
     * @param string $page
     * @param string $params
     * @throws ProcedureIncorrectException
     */
    public function __construct(string $page, string $params)
    {
        $this->processingRequest($page);
        $this->params = $params;
    }

    /**
     * @return IResponseProcedures
     */
    public function getHandler(): IResponseProcedures
    {
        return new $this->procedure($this->id, $this->params);
    }

    /**
     * @param $page
     * @throws ProcedureIncorrectException
     */
    private function processingRequest($page)
    {
        $procedure = $this->getProcedure($page);
        $this->procedure = static::PAGES_ACCESS[$procedure[1]];
        $this->id = !empty($procedure[2]) ? (int) $procedure[2] : 0;
    }

    /**
     * @param $page
     * @return mixed
     * @throws ProcedureIncorrectException
     */
    private function getProcedure($page)
    {
        $page = mb_strtolower(trim($page, '/'));
        preg_match('/^api\/(\w+)\/?(\d+)?/', $page, $matches);

        if (empty($matches[1])
            || array_key_exists($matches[1], static::PAGES_ACCESS) === false) {
            throw new ProcedureIncorrectException();
        }

        return $matches;
    }
}