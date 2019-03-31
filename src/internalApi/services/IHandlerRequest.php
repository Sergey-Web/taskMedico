<?php

namespace app\internalApi\services;

use app\internalApi\procedures\IResponseProcedures;

interface IHandlerRequest
{
    /**
     * IHandlerRequest constructor.
     * @param string $page
     * @param string $params
     */
    function __construct(string $page, string $params);
}