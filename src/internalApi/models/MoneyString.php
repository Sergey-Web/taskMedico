<?php

namespace app\internalApi\models;

use RedBeanPHP\R as R;

class MoneyString
{
    const TABLE_NAME = 'money_string';

    /**
     * @param string $lang
     * @return array
     */
    public function getDataMoneyString(string $lang): array
    {
        return R::getAll("
                SELECT id, currency, penny
                FROM " . self::TABLE_NAME . "
                WHERE lang = :lang
            ",
            [':lang' => $lang]
        );
    }

    /**
     * @param int $id
     * @return array
     */
    public function getNumsMoneyString(int $id): array
    {
        return R::getCol("
                SELECT `name`
                FROM money_string_numbers
                WHERE money_string_id = :id
            ",
            [':id' => $id]
        );
    }

    /**
     * @param int $id
     * @return array
     */
    public function getTensMoneyString(int $id): array
    {
        return R::getCol("
                SELECT `name`
                FROM money_string_tens
                WHERE money_string_id = :id
            ",
            [':id' => $id]
        );
    }

    /**
     * @param int $id
     * @return array
     */
    public function getHundredsMoneyString(int $id): array
    {
        return R::getCol("
                SELECT `name`
                FROM money_string_hundreds
                WHERE money_string_id = :id
            ",
            [':id' => $id]
        );
    }

    /**
     * @param int $id
     * @return array
     */
    public function getExceptionsTensMoneyString(int $id): array
    {
        return R::getCol("
                SELECT `name`
                FROM money_string_tens_exceptions
                WHERE money_string_id = :id
            ",
            [':id' => $id]
        );
    }

    /**
     * @param int $id
     * @return array
     */
    public function getTypesMoneyString(int $id): array
    {
        return R::getCol("
                SELECT `name`
                FROM money_string_types
                WHERE money_string_id = :id
            ",
            [':id' => $id]
        );
    }
}