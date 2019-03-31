<?php

namespace app\internalApi\procedures\task;

use app\internalApi\models\Task;
use app\internalApi\models\Token;
use app\internalApi\services\TokenService;
use Exception;

class StartTask implements IHandlerTask
{
    /**
     * @var array
     */
    private $params;

    /**
     * @var Task
     */
    private $task;

    /**
     * @var int
     */
    private $userId;

    /**
     * StartTask constructor.
     * @param string $params
     * @throws Exception
     */
    public function __construct(string $params)
    {
        $this->task = new Task;
        $this->params = json_decode($params, true);
        $this->checkParams($this->params);
        $this->userId = (new TokenService())->getUserIdByAuthToken();
    }

    /**
     * @param int $userId
     * @throws Exception
     */
    public function get(int $userId)
    {
        echo json_encode(['id' => $this->handler($this->userId)]);
    }

    /**
     * @param array $params
     * @throws Exception
     */
    private function checkParams(array $params)
    {
        if (empty($params['task']) && empty($params['params'])) {
            throw new Exception('Incorrect data are given to start the task');
        }
    }

    /**
     * @param int $userId
     * @return int
     * @throws Exception
     */
    private function handler(int $userId): int
    {
        $taskId = $this->task->saveTask($userId, $this->params);
        $this->processingData($taskId);

        return $taskId;
    }

    private function processingData(int $taskId)
    {
        $data = json_encode(['taskId' => $taskId]);
        $header = ['X-HTTP-Method-Override: PUT', 'Content-Type: application/json', 'Authorization: 48530017-15b3-406f-8fd4-f64788b4c56e'];
        $ch = curl_init($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/api/task/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_exec($ch);
        curl_close($ch);
    }
}