<?php

namespace app\internalApi\procedures\task\handlersTask;


class Sleep implements ITask
{
    /**
     * @var array
     */
    private $param;

    /**
     * Fibonacci constructor.
     * @param int $param
     */
    public function __construct(int $param)
    {
        $this->param = $param;
    }

    /**
     * @return string
     */
    public function result()
    {
        if (is_int($this->param)) {
            for ($i = 0; $i < 100; $i++) {
                sleep($this->param);
            }
        }

        return 'finished';
    }
}