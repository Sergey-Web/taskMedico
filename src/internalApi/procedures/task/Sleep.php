<?php

namespace app\internalApi\procedures\task;


class Sleep implements ITask
{
    /**
     * @param array $params
     * @return array
     */
    public function result(array $params)
    {
        $res = [];
        foreach ($params as $param) {
            if (is_int($param)) {
                for ($i = 0; $i < 1; $i++) {
                    sleep($param);
                }
                array_push($res, 'finished');
            }
        }

        return $res;
    }
}