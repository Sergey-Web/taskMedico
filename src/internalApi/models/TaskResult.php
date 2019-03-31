<?php

namespace app\internalApi\models;

use Exception;
use \RedBeanPHP\R as R;

class TaskResult {

    const TABLE_NAME = 'task_results';

    /**
     * @param int $taskId
     * @param string $data
     * @throws Exception
     */
    public function saveResult(int $taskId, string $data)
    {
        $task = R::exec("
            INSERT INTO " . static::TABLE_NAME . " (task_id, result)
            VALUES ({$taskId}, '" . $data . "')
        ");

        if (!$task) {
            throw new Exception('Error creating task results');
        }
    }

    /**
     * @param int $taskId
     * @return string
     */
    public function getTaskResults(int $taskId)
    {
        return R::getCell("
              SELECT result 
              FROM " . static::TABLE_NAME . "
              WHERE task_id = :id",
            [':id' => $taskId]
        );
    }
}