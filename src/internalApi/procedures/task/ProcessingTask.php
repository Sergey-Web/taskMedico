<?php

namespace app\internalApi\procedures\task;

use app\internalApi\models\Task;
use Exception;

class ProcessingTask implements IHandlerTask
{

    /**
     * @var Task
     */
    private $task;

    /**
     * @var array
     */
    private $params;

    /**
     * @var string
     */
    private $taskName;

    /**
     * @var int
     */
    private $taskId;

    /**
     * @var array
     */
    private $mapTask = [
//        'convertMoneyString' => ConverterMoneyString::class,
        'fibonacci' => Fibonacci::class,
        'sleep' => Sleep::class
    ];

    /**
     * StartTask constructor.
     * @param string $params
     * @throws Exception
     */
    public function __construct(string $params)
    {
        $params = json_decode($params, true);
        $this->checkParams($params);
        $this->task = new Task;
        $this->taskId = $params['taskId'];
        $getDataTask = $this->task->getTask($params['taskId'])[0];
        $this->taskName = $getDataTask['task_name'];
        $this->params = json_decode($getDataTask['task']);
    }

    /**
     * @param int $taskId
     * @throws Exception
     */
    public function get(int $taskId)
    {
        $this->task->saveResult(
            $this->taskId,
            json_encode($this->processingTask())
        );
    }

    /**
     * @return array
     */
    public function processingTask(): array
    {
        return (new $this->mapTask[$this->taskName])->result($this->params);
    }

    /**
     * @param array $params
     * @throws Exception
     */
    private function checkParams(array $params)
    {
        if (empty($params['taskId'])) {
            throw new Exception('Wrong data', 404);
        }
    }
}