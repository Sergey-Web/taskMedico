<?php

namespace app\internalApi\services;

use app\internalApi\procedures\IResponseProcedures;

interface IHandlerRequest
{
    function getHandler(): IResponseProcedures;
}