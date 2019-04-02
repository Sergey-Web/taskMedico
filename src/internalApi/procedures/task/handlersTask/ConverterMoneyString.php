<?php

namespace app\internalApi\procedures\task\handlersTask;

use app\internalApi\procedures\handlersMoneyString\HandlerRu;
use app\internalApi\procedures\handlersMoneyString\HandlerUa;
use Exception;

class ConverterMoneyString implements ITask
{
    private $handlers = [
        'ru' => HandlerRu::class,
        'ua' => HandlerUa::class
    ];

    /**
     * @var string
     */
    private $lang;

    /**
     * @var array
     */
    private $params;

    /**
     * ConverterMoneyString constructor.
     * @param array $params
     * @throws Exception
     */
    public function __construct(array $params)
    {
        $this->lang = mb_strtolower($params['lang']);
        $this->checkHandler($this->lang);
        $this->params = $params['money'];
    }

    /**
     * @return array
     */
    public function result(): array
    {
        return ['money' => $this->handler()];
    }

    /**
     * @return string
     */
    private function handler(): string
    {
        $res = '';

        if (is_float($this->params)) {
            $res = (new $this->handlers[$this->lang]($this->params))->convert();
        }

        return $res;
    }

    /**
     * @param string $lang
     * @throws Exception
     */
    private function checkHandler(string $lang)
    {
        if (!array_key_exists($lang, $this->handlers)) {
            throw new Exception('Such a language does not support', 422);
        }
    }
}