<?php

namespace app\internalApi\services;

use app\internalApi\models\{Access, Token};
use DateTime;
use Exception;
use \RedBeanPHP\R as R;

class UserService
{
    private $accesses = [
        'inactive',
        'user',
        'admin'
    ];

    /**
     * @param string $params
     * @return array
     */
    public function validParams(string $params): array
    {
        return (json_decode($params, true) !== null) ? json_decode($params, true) : [];
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function checkAuthToken()
    {
        $authToken = (new HttpService())->getHeaderAuthToken();
        $userToken = (new Token())->getUserIdByToken($authToken);

        if (!$userToken) {
            throw new Exception('Authentication Key Error');
        }
    }

    /**
     * @param string $params
     * @return string
     * @throws Exception
     */
    public function createUserTransaction(string $params): string
    {
        $params = $this->validParams($params);
        if (empty($params['email']) && empty($params['password'])) {
            throw new Exception('Error, mail or password is not entered');
        }

        R::begin();
        try {
            $user = R::dispense('users');
            $user->email = $params['email'];
            $user->password = password_hash($params['password'], PASSWORD_BCRYPT);
            $user->created_at = (new DateTime())->format('Y-m-d h:i:s');
            R::store($user);
            $userId = R::getInsertID();

            if (!empty($params['access'])) {
                $access = R::dispense('accesses');
                $access->user_id = $userId;
                $access->access = $params['access'];
                R::store($access);
            }

            if (!empty($params['name'])) {
                $name = R::dispense('names');
                $name->user_id = $userId;
                $name->name = $params['name'];
                R::store($name);
            }

            if (!empty($params['phone'])) {
                $phone = R::dispense('phones');
                $phone->user_id = $userId;
                $phone->phone = $params['phone'];
                R::store($phone);
            }

            R::commit();
        } catch (\Exception $e) {
            R::rollback();
            throw new Exception('User data not created');
        }

        return $userId;
    }

    /**
     * @param int $userId
     * @param string $params
     * @throws Exception
     */
    public function updateUserTransaction(int $userId, string $params)
    {
        $params = $this->validParams($params);
        $this->checkDateForUpdate($params);

        R::begin();
        try {
            $user = R::load('users', $userId);
            $user->id = $userId;

            if (!empty($params['email'])) {
                $user->email = $params['email'];
            }

            if (!empty($params['password'])) {
                $user->password = password_hash($params['password'], PASSWORD_BCRYPT);
            }

            if (!empty($params['access'])) {
                $access = R::load('accesses', $userId);
                $access->access = empty($params['access']) ? $params['access'] : null;
                R::store($access);
            }

            if (!empty($params['name'])) {
                $name = R::load('names', $userId);
                $name->user_id = $userId;
                $name->name = $params['name'];
                R::store($name);
            }

            if (!empty($params['phone'])) {
                $phone = R::load('phones', $userId);
                $phone->user_id = $userId;
                $phone->phone = $params['phone'];
                R::store($phone);
            }

            $user->updated_at = (new DateTime())->format('Y-m-d h:i:s');
            R::store($user);
            R::commit();
        } catch (\Exception $e) {
            R::rollback();
            throw new Exception('User data not updated');
        }
    }

    /**
     * @throws Exception
     */
    public function checkAccessAdmin()
    {
        $token = (new HttpService)->getHeaderAuthToken();
        $userAccess = (new Access)->getAccessUserByToken($token);

        if ($this->accesses[$userAccess] !== 'admin') {
            throw new Exception('You do not have access');
        }
    }

    /**
     * @param array $params
     * @throws Exception
     */
    private function checkDateForUpdate(array $params)
    {
        if (!empty($params['email'])
            || !empty($params['password'])
            || !empty($params['name'])
            || !empty($params['access'])
            || !empty($params['phone']))
        {
            return;
        }

        throw new Exception('Data not updated for update');
    }

}