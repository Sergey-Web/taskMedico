<?php

namespace app\internalApi\services;

use app\internalApi\exceptions\ProcedureIncorrectException;
use app\internalApi\procedures\IResponseProcedures;
use app\internalApi\procedures\Login;

class HandlerRequest implements IHandlerRequest
{
    const PAGES_ACCESS = [
        'api/login' => Login::class,
        'api/user',
        'api/task',
    ];

    private $page;

    private $handler;

    /**
     * HandlerRequest constructor.
     * @param $page
     * @throws ProcedureIncorrectException
     */
    public function __construct($page)
    {
        $this->rawPageFormatting($page);
        if (array_key_exists($this->page, static::PAGES_ACCESS) === false) {
            throw new ProcedureIncorrectException();
        }

        $this->handler = static::PAGES_ACCESS[$this->page];
    }

    /**
     * @return IResponseProcedures
     */
    public function getHandler(): IResponseProcedures
    {
        return new $this->handler;
    }

    /**
     * @param $page
     */
    private function rawPageFormatting($page)
    {
        $this->page = mb_strtolower(trim($page, '/'));
    }
}