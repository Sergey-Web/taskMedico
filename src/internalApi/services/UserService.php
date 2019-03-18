<?php

namespace app\internalApi\services;

use app\internalApi\models\{Token,User};
use DateTime;
use Exception;
use \RedBeanPHP\R as R;

class UserService
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Token
     */
    private $token;

    /**
     * @var string
     */
    private $authToken;

    /**
     * @var HttpService
     */
    private $httpService;
    /**
     * UserService constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->httpService = new HttpService();
        $this->user = new User();
        $this->token = new Token();
    }

    /**
     * @param string $params
     * @return array
     */
    public function validParams(string $params): array
    {
        return (json_decode($params, true) !== null) ? json_decode($params, true) : [];
    }

    /**
     * @param int $userId
     * @return mixed
     * @throws Exception
     */
    public function checkAuthToken(int $userId)
    {
        $this->authToken = $this->httpService->getHeaderAuthToken();
        $userToken = $this->token->get($userId)[0]['token'];

        if ($userToken !== $this->authToken) {
            throw new Exception('Authentication Key Error');
        }

        return $this->token->get($userId)[0];
    }


    public function createUserTransaction(int $userId, string $params): string
    {
        $params = $this->validParams($params);
        if (empty($params['email']) && empty($params['password'])) {
            throw new Exception('Error, mail or password is not entered');
        }

        R::begin();
        try {
            $date = (new DateTime())->format('Y-m-d h:i:s');
            $user = R::dispense('users');
            $user->email = $params['email'];
            $user->password = password_hash($params['password'], PASSWORD_BCRYPT);
            $user->created_at = $date;
            R::store($user);

            $userId = R::getInsertID();

            if (!empty($params['access'])) {
                $access = R::dispense('accesses');
                $access->user_id = $userId;
                $access->access = empty($params['access']) ? $params['access'] : null;
                R::store($access);
            }

            if (!empty($params['name'])) {
                $name = R::dispense('names');
                $name->user_id = $userId;
                $name->name = empty($params['name']) ? $params['name'] : null;
                R::store($name);
            }

            if (!empty($params['phone'])) {
                $phone = R::dispense('names');
                $phone->user_id = $userId;
                $phone->name = $params['phone'];
                R::store($phone);
            }

            $this->token->createToken($userId);

            R::commit();
        } catch (\Exception $e) {
            R::rollback();
        }

        return 'create user';
    }

    public function updateUserTransaction(int $userId, string $params)
    {
        $params = $this->validParams($params);
        $this->checkDateForUpdate($params);

        R::begin();
        try {
            if (!empty($params['email']) && !empty($params['password'])) {
                $date = (new DateTime())->format('Y-m-d h:i:s');
                $user = R::dispense('users');
                $user->userId = $userId;
                $user->email = $params['email'];
                $user->password = password_hash($params['password'], PASSWORD_BCRYPT);
                $user->update_at = $date;
                R::store($user);
            }

            if (!empty($params['access'])) {
                $access = R::dispense('accesses');
                $access->user_id = $userId;
                $access->access = empty($params['access']) ? $params['access'] : null;
                R::store($access);
            }

            if (!empty($params['name'])) {
                $name = R::dispense('names');
                $name->user_id = $userId;
                $name->name = empty($params['name']) ? $params['name'] : null;
                R::store($name);
            }

            if (!empty($params['phone'])) {
                $phone = R::dispense('names');
                $phone->user_id = $userId;
                $phone->name = $params['phone'];
                R::store($phone);
            }

            $this->token->updateToken($userId);

            R::commit();
        } catch (\Exception $e) {
            R::rollback();
        }

        return 'update date';
    }

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