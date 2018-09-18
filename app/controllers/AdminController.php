<?php
/**
 * Created by PhpStorm.
 * User: dimka1c
 * Date: 12.09.2018
 * Time: 17:05
 */

namespace app\controllers;


use app\models\MailModel;
use app\models\UserModel;
use vendor\core\AppController;

class AdminController extends AppController
{

    protected $user;

    public $layout = 'admin';

    public function __construct($route)
    {
        parent::__construct($route);
        $this->user = new UserModel();
    }

    public function actionIndex()
    {
        if ($this->user->isGuest()) {
            $this->setDataView(['user' => $this->user->getNameUser()]);
        } else {
            header("Location: /main/index");
        }

    }

    public function actionMail()
    {
        if ($this->user->isGuest()) {
            $email = new MailModel();
            $allEmail = $email->getListEmail();
            $this->setDataView(['user' => $this->user->getNameUser(), 'allEmail' => $allEmail]);
        } else {
            header("Location: /main/index");
        }
    }


    public function actionCreateFromMail()
    {

        // 1. Получить файлы из письма для обработки AJAX
        if ($this->user->isGuest() && $this->isAjax()) {
            $uid = $_POST['id'];
            $pattern = "#(\\d).*#si";
            preg_match($pattern, $uid, $matches);
            if ($matches) {
                $uid = $matches[0];
                $model = new MailModel();
                $_SESSION['progress_email_create'] = 'Загрузка файлов';
                if ($res = $model->loadAttach($uid)) { // return true - файлы сохранены or false - ошибка сохранения файлов
                    // файлы успешно сохранены
                    // var_dump($res);
                    $_SESSION['progress_email_create'] = 'Преобразование файлов';

                };
            }
        }


        // 2. Преобразовать файлы в csv
        // 3. Распарсить csv и занести в mysql данные
        // 4. сформировать файл xlsx
        // 5. отправить файл адресату
        // 6. Удалить файл с почты
    }
}