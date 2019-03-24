<?php

namespace app\internalApi\procedures\task;


class Sleep implements ITask
{
    /**
     * @param array $params
     * @return string
     */
    public function result(array $params)
    {
        foreach ($params as $param) {
            if (is_int($param)) {
                for ($i = 0; $i < 100; $i++) {
                    sleep($param);
                }
            }
        }


        return 'finished';
    }
}