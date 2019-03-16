<?php

namespace app\internalApi\services;

use app\internalApi\procedures\IResponseProcedures;

interface IHandlerResponse
{
    /**
     * IHandlerResponse constructor.
     * @param IResponseProcedures $handler
     */
    function __construct(IResponseProcedures $handler);

    /**
     * @return string
     */
    function get(): string;
}