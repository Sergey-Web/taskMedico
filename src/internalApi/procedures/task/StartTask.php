<?php

namespace app\internalApi\procedures\task;

use app\internalApi\models\Task;
use app\internalApi\services\TokenService;
use Exception;

class StartTask implements IHandlerTask
{
    private $mapTask = [
//        'convertMoneyString' => ConverterMoneyString::class,
        'fibonacci' => Fibonacci::class,
        'sleep' => Sleep::class
    ];

    /**
     * @var array
     */
    private $params;

    /**
     * StartTask constructor.
     * @param string $params
     * @throws Exception
     */
    public function __construct(string $params)
    {
        $this->params = json_decode($params, true);
        $this->checkParams($this->params);
    }

    public function get(int $userId): string
    {
        $userId = (new TokenService())->getUserIdByAuthToken();
        $task = new Task;
        $result = (new $this->mapTask[$this->params['task']])->result($this->params['params']);
        $taskId = $task->saveTask($userId, $this->params['task']);
        $task->saveResult($taskId, json_encode($result));

        return $taskId;
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

        if (array_key_exists($params['task'], $this->mapTask) === false) {
            throw new Exception('Incorrect data are given to start the task');
        }
    }
}