<?php

namespace app\internalApi\procedures\user;

interface IUser
{
    function __construct(string $params);

    function get(int $userId): array;
}