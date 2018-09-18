<?php

namespace app\models;

use vendor\core\AppModel;

class MainModel extends AppModel
{
    public $table = 'driver';

    public function getAllDrivers()
    {
        $sql = "SELECT * FROM users";
        return $this->pdo->query($sql);
    }
}