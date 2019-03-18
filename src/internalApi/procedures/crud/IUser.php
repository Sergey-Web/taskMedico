<?php

namespace app\internalApi\procedures\crud;

interface IUser
{
    function __construct(string $params);

    function get(int $userId);
}