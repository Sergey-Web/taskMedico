<?php

namespace app\internalApi\procedures\task;

use app\internalApi\models\Task;

class ResultTask implements IHandlerTask
{
    public function get(int $taskId): string
    {
        $result = (new Task)->getTaskResults($taskId);

        return !empty($result) ? $result : '';
    }
}