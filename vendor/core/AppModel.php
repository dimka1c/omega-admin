<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 006 06.09.18
 * Time: 15:27
 */

namespace vendor\core;

abstract class AppModel
{

    protected $table;

    protected $pdo;

    public function __construct()
    {
        $this->pdo = AppDB::instance();
    }

    public function query($sql)
    {
        return $this->pdo->execute($sql);
    }

    public function findAll(string $sql)
    {
        return $this->pdo->query($sql);
    }

    public function generatePasswordHash(string $psw): string
    {
        return password_hash($psw, PASSWORD_DEFAULT);
    }

}