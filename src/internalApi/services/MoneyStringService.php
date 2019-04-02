<?php

namespace app\internalApi\services;

class MoneyStringService
{
    /**
     * @param array $arr
     * @param int $key
     * @return array
     */
    public function changeNumericIndexArray(array $arr, int $key = 1): array
    {
        $res = [];
        for($i = 0, $c = $key; $i < count($arr); $i++, $c++) {
            $res[$c] = $arr[$i];
        }

        return $res;
    }
}