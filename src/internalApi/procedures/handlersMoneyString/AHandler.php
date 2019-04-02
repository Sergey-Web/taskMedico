<?php

namespace app\internalApi\procedures\handlersMoneyString;

use app\internalApi\models\MoneyString;
use app\internalApi\services\MoneyStringService;

abstract class AHandler
{

    /**
     * @var int
     */
    protected $money;

    /**
     * @var MoneyString
     */
    protected $moneyString;

    /**
     * @var MoneyStringService
     */
    protected $moneyStringService;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $penny;

    /**
     * @var array
     */
    protected $num;

    /**
     * @var array
     */
    protected $tensExceptions;

    /**
     * @var array
     */
    protected $types;

    /**
     * HandlerRu constructor.
     * @param $money
     */
    public function __construct($money)
    {
        $this->money = $money;
        $this->moneyString = new MoneyString;
        $this->moneyStringService = new MoneyStringService;
        $data = $this->moneyString->getDataMoneyString(static::LANG)[0];
        $this->currency = $data['currency'];
        $this->penny = $data['penny'];
        $this->id = (int) $data['id'];
        $this->setNums();
        $this->setTensExceptions();
        $this->setTypes();
    }

    /**
     * @return string
     */
    protected function handler(): string
    {
        $num = $this->money;
        preg_match('/(\d+)\.(\d+)/', $num, $matches);
        $num = (int) $matches[1];
        $penny = $this->handlerPenny((int) $matches[2]);

        $numberSplitDigits = preg_replace('/(?<=\d)(?=(\d{3})+$)/', '.', $num);

        return trim($this->handlerNum($numberSplitDigits) . ' ' . $penny);
    }

    /**
     * @param string $num
     * @return string
     */
    protected function handlerNum(string $num): string
    {
        $pathNum = explode('.', $num);
        $res = '';
        $countPathNum = count($pathNum);
        $countTypeNum = count($pathNum) - 1;

        for($counter = 0; $counter < $countPathNum; $counter++) {
            $res .= $this->namingNum($pathNum[$counter]) . $this->getType($countTypeNum--);
        }

        return $res . $this->currency;
    }

    protected function setTypes()
    {
        $types = $this->moneyString->getTypesMoneyString($this->id);
        $this->types = $this->moneyStringService->changeNumericIndexArray($types);
    }

    /**
     * @param int $counter
     * @return string
     */
    protected function getType(int $counter): string
    {
        $type = '';

        if ($counter > 0) {
            $type = $this->types[$counter] . ' ';
        }

        return $type;
    }

    /**
     * @param int $num
     * @return string
     */
    protected function handlerPenny(int $num): string
    {
        return $this->namingNum($num) . $this->penny;
    }

    /**
     * @param int $num
     * @return string
     */
    protected function namingNum(int $num): string
    {
        $res = '';
        for($len = strlen($num); $len > 0; $len--) {
            if ($len === 3) {
                $res .= $this->num[$len][substr($num, 0, 1)] . ' ';
                $num = substr($num, 1);
            } elseif ($len === 2) {
                if (substr($num, 0, 1) == 0) continue;
                if (array_key_exists($num, $this->tensExceptions)) {
                    $res .= $this->tensExceptions[$num] . ' ';
                    break;
                }
                $res .= $this->num[$len][substr($num, 0, 1)] . ' ';
                $num = substr($num, 1);
            } else {
                if (substr($num, 0, 1) == 0) continue;
                $res .= $this->num[$len][substr($num, 0, 1)] . ' ';
            }
        }

        return !empty($res) ? $res : end($this->num[1]) . ' ';
    }

    protected function setNums()
    {
        $numbers = $this->moneyString->getNumsMoneyString($this->id);
        $this->num[1] = $this->moneyStringService->changeNumericIndexArray($numbers);
        $tens = $this->moneyString->getTensMoneyString($this->id);
        $this->num[2] = $this->moneyStringService->changeNumericIndexArray($tens);
        $hundreds = $this->moneyString->getHundredsMoneyString($this->id);
        $this->num[3] = $this->moneyStringService->changeNumericIndexArray($hundreds);
    }

    protected function setTensExceptions()
    {
        $TensExceptions = $this->moneyString->getExceptionsTensMoneyString($this->id);

        $this->tensExceptions = $this->moneyStringService->changeNumericIndexArray(
            $TensExceptions,
            static::START_TENS_EXCEPTION
        );
    }
}