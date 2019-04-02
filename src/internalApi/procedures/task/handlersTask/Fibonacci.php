<?php

namespace app\internalApi\procedures\task\handlersTask;

class Fibonacci implements ITask
{
    /**
     * @var int
     */
    private $param;

    /**
     * Fibonacci constructor.
     * @param array $param
     */
    public function __construct(int $param)
    {
        $this->param = $param;
    }

    /**
     * @return int
     */
    public function result(): int
    {
        return $this->calculations();
    }

    /**
     * @return int
     */
    private function calculations(): int
    {
        $res = 0;
        if (is_int($this->param)) {
            $res = $this->fib($this->param);
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