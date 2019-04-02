<?php

namespace app\internalApi\models;

use Exception;
use \RedBeanPHP\R as R;

class Task {

    const TABLE_NAME = 'tasks';

    /**
     * @param int $userId
     * @param array $data
     * @return int
     * @throws Exception
     */
    public function saveTask(int $userId, array $data): int
    {
        $task = R::dispense(static::TABLE_NAME);
        $task->user_id = $userId;
        $task->task_name = $data['task'];
        $task->task = json_encode($data['params']);

        if (!R::store($task)) {
            throw new Exception('Error creating task');
        }

        return (int) R::getInsertID();
    }

    /**
     * @param int $taskId
     * @return string
     */
    public function getTask(int $taskId)
    {
        return R::getAll("
              SELECT task_name, task
              FROM " . static::TABLE_NAME . "
              WHERE id = :id",
            [':id' => $taskId]
        );
    }
}