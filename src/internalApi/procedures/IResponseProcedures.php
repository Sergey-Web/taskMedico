<?php

namespace app\internalApi\procedures;


interface IResponseProcedures
{
    /**
     * @param array $dataUser
     * @return string
     */
    function get(): string;
}