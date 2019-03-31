<?php

namespace app\internalApi\services;

use Exception;

class HttpService
{
    /**
     * @return string
     * @throws Exception
     */
    public function getHeaderAuthToken(): string
    {
        if (empty(getallheaders()['Authorization'])) {
            throw new Exception('No authentication key');
        }

        return getallheaders()['Authorization'];
    }

    /**
     * @param string $method
     * @throws Exception
     */
    public function checkMethodHttp(string $method)
    {
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            throw new Exception('Data Transfer Method Error', 401);
        }
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}