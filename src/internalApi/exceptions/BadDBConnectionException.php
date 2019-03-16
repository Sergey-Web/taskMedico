<?php

namespace app\internalApi\exceptions;


class BadDBConnectionException extends \Exception
{
    protected $message = 'Error connecting to the database';
}