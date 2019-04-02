<?php

namespace app\internalApi\procedures\task;

use app\internalApi\models\TaskResult;

class ResultTask implements IHandlerTask
{
    const DEFAULT_RESULT = ['status' => 'pending'];

    /**
     * @var int
     */
    private $taskId;

    /**
     * @param int $taskId
     */
    public function get(int $taskId)
    {
        $this->taskId = $taskId;
        echo json_encode($this->handler(), JSON_UNESCAPED_UNICODE);
    }

    /**
     * @return array
     */
    private function handler(): array
    {
        $result = static::DEFAULT_RESULT;
        $resultTask = $this->getResultTask();

        if (!empty($resultTask)) {
            $result = ['status' => 'done', 'result' => json_decode($resultTask)];
        }

        return $result;
    }

    private function getResultTask()
    {
        return (new TaskResult)->getTaskResults($this->taskId);
    }
}