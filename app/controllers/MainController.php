<?php

namespace app\controllers;

use app\models\MainModel;
use app\models\RegModel;
use app\models\UserModel;
use vendor\core\AppController;

class MainController extends AppController
{

    private $fields = [];
    private $formError = false;

    public function actionIndex()
    {
        /*
        $this->layout = false;
        $this->layout = 'main1';
        $this->view = 'index1';
        */

        //var_dump($_COOKIE);
        /*
        $model = new MainModel();
        $drivers = $model->getAllDrivers();
        */
        $drivers = ['one', 'two'];
        $this->setDataView(compact('drivers'));

    }

    public function actionLogin()
    {
        $user = new UserModel();
        if ($user->login()) {
            header("Location: /admin/index");
        } else {
            $this->setFlash('error-login', 'Неверный логин или пароль');
            header("Location: /main");
        }
    }

    private function validateRegisterForm(array $data): bool
    {
        foreach ($data as $field => $val) {
            if (empty($val)) {
                $this->fields[] = $field;
            }
        }
        if (!empty($this->fields)) {
            $this->fields['error'] = 'Не все поля заполнены';
            return false;
        }
        if ($data['psw'] <> $data['confirm-psw']) {
            $this->fields = ['psw', 'confirm-psw'];
            $this->fields['error'] = 'Пароли не совпадают';
            return false;
        }
        if (strlen($data['psw']) < 5) {
            $this->fields = ['psw', 'confirm-psw'];
            $this->fields['error'] = 'Паполь не может быть меньше 5 символов';
            return false;
        }
        return true;
    }

    public function actionRegister()
    {
        if ($this->isAjax()) {
            $this->layout = false;
            if ($this->validateRegisterForm($_POST)) {
                $model = new RegModel($_POST);
                $res = $model->addUser();
                if ($res['state'] == 'ok') {
                    $this->setFlash('registration', 'Вы успешно зарегистрирваны. Учетная запись будет активирована в ближайшее время');
                    echo json_encode('ok');
                } elseif($res['state'] == 'error') {
                    echo json_encode($res['state'] . ' : ' .$res['error']);
                }
            } else {
                echo json_encode($this->fields);
            }
            die;
        }
    }

}
