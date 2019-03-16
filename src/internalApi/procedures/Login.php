<?php

namespace app\internalApi\procedures;

class Login implements IResponseProcedures
{
    /**
     * @return string
     */
    public function get(): string
    {
        return 'yes';
    }
}