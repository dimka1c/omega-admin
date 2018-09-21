<?php
/**
 * Created by PhpStorm.
 * User: dimka1c
 * Date: 11.09.2018
 * Time: 12:51
 */

namespace app\models;

use app\interfaces\UserInterface;
use vendor\core\AppModel;

class UserModel extends AppModel implements UserInterface
{

    public $table = "users";

    public function accessAction(): bool
    {
        // TODO: Implement accessAction() method.
    }

    public function accessPage(): bool
    {
        // TODO: Implement accessPage() method.
    }

    public function isAdmin(): bool
    {
        // TODO: Implement isAdmin() method.
    }

    public function isGuest(): bool
    {
        if (isset($_SESSION['user'])) {
            return true;
        }
        return false;
    }

    public function login(): bool
    {
        if (!empty($_POST['login-name']) && !empty($_POST['login-password'])) {
            $login = $_POST['login-name'];
            $sql = "SELECT * FROM {$this->table} WHERE user_login = '{$login}'";
            $res = $this->findAll($sql);
            if (is_array($res)) {
                if ($res[0]['user_access'] == 0) return false;
                $paswOk = password_verify($_POST['login-password'], $res[0]['user_psw']);
                if ($paswOk) {
                    foreach ($res[0] as $key => $data) {
                        if ($key != 'password') {
                            $_SESSION['user'][$key] = $data;
                        }
                    }
                    if (isset($_POST['login-remember'])) {
                        $coockie = str_replace(['/', '+', '='], '', base64_encode(random_bytes(32)));
                        // ставиим куку на 7 дней
                        $setCoockie = setcookie('omega_access', $coockie, time()+3600*24*7, '/', 'omega.loc');
                        if ($setCoockie) {
                            $sql_cook = "UPDATE users SET user_coockie = '{$coockie}'  WHERE id = {$res[0]['id']}";
                            $this->query("UPDATE users SET user_coockie = '{$coockie}'  WHERE id = {$res[0]['id']}");
                        }
                    }
                    return true;
                }
            }
        }
        return false;
    }

    public function logout(): bool
    {
        setcookie('omega_access', '', time()-100, '/', 'omega.loc' );
        unset($_SESSION['user']);
        return true;
    }

    public function UserAccessAPI(): bool
    {
        // TODO: Implement UserAccessAPI() method.
    }

    public function UserAccessCoockie(): bool
    {
        if (isset($_COOKIE['omega_access'])) {
            $res = $this->findAll("SELECT * FROM users WHERE user_coockie = '{$_COOKIE['omega_access']}'");
            if (is_array($res)) {
                foreach ($res[0] as $key => $data) {
                    if ($key != 'password') {
                        $_SESSION['user'][$key] = $data;
                    }
                }
                return true;
            }
        }
        return false;
    }

    public function getNameUser(): string
    {
        return $_SESSION['user']['user_name'];
    }

}