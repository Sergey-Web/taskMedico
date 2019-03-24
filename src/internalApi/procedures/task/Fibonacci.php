<?php

namespace app\internalApi\procedures\task;

class Fibonacci implements ITask
{
    /**
     * @param array $params
     * @return array
     */
    public function result(array $params): array
    {
        return $this->calculations($params);
    }

    /**
     * @param array $params
     * @return array
     */
    private function calculations(array $params): array
    {
        $res = [];
        foreach($params as $param) {
            if (is_int($param)) {
                array_push($res, $this->fib($param));
                continue;
            }
            array_push($res, 0);
        }

        return $res;
    }

    /**
     * @param $num
     * @return int
     */
    private function fib($num) {
        $a = 1;
        $b = 1;

        for ($x = 3; $x <= $num; $x++) {
            $c = $a + $b;
            $a = $b;
            $b = $c;
        }

        return $b;
    }
}