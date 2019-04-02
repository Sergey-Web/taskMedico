<?php

namespace app\internalApi\procedures\handlersMoneyString;

class HandlerUa extends AHandler implements IHandlerLang
{
    const LANG = 'ua';

    const START_TENS_EXCEPTION = 11;

    /**
     * HandlerRu constructor.
     * @param $money
     */
    public function __construct($money)
    {
        parent::__construct($money);
    }

    public function convert(): string
    {
        return $this->handler();
    }

}