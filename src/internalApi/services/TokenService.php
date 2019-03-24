<?php

namespace app\internalApi\services;

use app\internalApi\models\Token;
use const app\config\TIME_TOKEN;
use DateTime;
use Exception;

class TokenService
{
    /**
     * @throws Exception
     */
    public function checkToken()
    {
        $authToken = (new HttpService())->getHeaderAuthToken();
        $tokenDateCreate = (new Token())->getDateToken($authToken);
        $tokenData = (new DateTime($tokenDateCreate));
        $curDate = (new DateTime());
        $dateDiff = $curDate->getTimestamp() - $tokenData->getTimestamp();

//        if ($dateDiff > TIME_TOKEN) {
//            throw new Exception('Your token is out of date');
//        }

    }


    /**
     * @throws \app\internalApi\exceptions\TokenUpdateErrorExceptions
     */
    public function updateDateTimeToken()
    {
        $token = (new HttpService())->getHeaderAuthToken();
        $userId = (new Token())->getUserIdByToken($token);

        (new Token())->updateDate($userId, $token);
    }

    /**
     * @return string
     */
    function generation(): string
    {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,
            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getUserIdByAuthToken(): string
    {
        $authToken = (new HttpService())->getHeaderAuthToken();
        $userId = (new Token())->getUserIdByToken($authToken);

        if (!$userId) {
            throw new Exception('Authentication Key Error');
        }

        return $userId;
    }
}