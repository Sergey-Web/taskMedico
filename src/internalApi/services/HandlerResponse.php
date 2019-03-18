<?php

namespace app\internalApi\services;

use app\internalApi\procedures\IResponseProcedures;

class HandlerResponse implements IHandlerResponse
{
    private $result;

    /**
     * HandlerResponse constructor.
     * @param IResponseProcedures $handler
     */
    public function __construct(IResponseProcedures $handler)
    {
        $this->result = $handler->get();
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return json_encode(['result' => $this->result]);
    }
}