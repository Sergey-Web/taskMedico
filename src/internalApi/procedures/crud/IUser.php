<?php

namespace app\internalApi\procedures\crud;

interface IUser
{
    function __construct(array $params);

    function get(int $userId);
}