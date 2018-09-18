<?php

namespace app\models;

use app\components\InputFormFilter;
use vendor\core\AppModel;


class RegModel extends AppModel
{
    public $table = 'users';

    public $dataUser = [];

    protected $status = [
        'state' => 'ok',
        'error' => '',
    ];

    public function __construct($data)
    {
        parent::__construct();
        $this->dataUser = $data;
    }

    /*
     * Проверка на существование пользователя в таблице
     *
     * @param string $login логин пользователя
     * @return boolean
     */
    public function checkUserName(string $login): int
    {
        $sql = "SELECT COUNT(user_login) as count_user FROM {$this->table} WHERE user_login = '{$login}';";
        $res = $this->findAll($sql);
        return $res[0]['count_user'];
    }

    public function addUser(): array
    {
        $this->dataUser = InputFormFilter::filterDataForm($this->dataUser);
        if($this->checkUserName($this->dataUser['login']) > 0) {
            $this->status['state'] = 'error';
            $this->status['error'] = 'Пользователь с таким логином уже существует';
            return $this->status;
        }
        $sql = "INSERT INTO {$this->table} (user_name, user_login, user_psw, user_coockie, user_access) VALUES ('{$this->dataUser['name']}','{$this->dataUser['login']}', '{$this->generatePasswordHash($this->dataUser['psw'])}', '', 0);";
        $res = $this->query($sql);
        return $this->status;
    }
}