<?php

namespace app\internalApi\models;

use Exception;
use \RedBeanPHP\R as R;

class Task {

    const TABLE_NAME = 'tasks';

    /**
     * @param int $userId
     * @param string $data
     * @return mixed
     * @throws Exception
     */
    public function saveTask(int $userId, string $data)
    {
        $task = R::dispense(static::TABLE_NAME);
        $task->user_id = $userId;
        $task->task = $data;

        if (!R::store($task)) {
            throw new Exception('Error creating task');
        }

        return R::getInsertID();
    }

    /**
     * @param int $taskId
     * @param string $data
     * @throws Exception
     */
    public function saveResult(int $taskId, string $data)
    {
        $task = R::exec("
            INSERT INTO task_results (task_id, result)
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
    public function getTaskResults(int $taskId): string
    {
        return R::getCell("
              SELECT r.result 
              FROM " . static::TABLE_NAME . " AS t
              JOIN task_results AS r ON t.id = r.task_id
              WHERE t.id = :id",
            [':id' => $taskId]
        );
    }
}