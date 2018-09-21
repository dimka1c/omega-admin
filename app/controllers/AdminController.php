<?php
/**
 * Created by PhpStorm.
 * User: dimka1c
 * Date: 12.09.2018
 * Time: 17:05
 */

namespace app\controllers;


use app\models\driverModel;
use app\models\ExcelModel;
use app\models\MailModel;
use app\models\UserModel;
use vendor\core\AppController;
use vendor\core\Router;

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

    public function actionLogout()
    {
        $model = new UserModel();
        if ($model->logout()) {
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
                    $_SESSION['progress_email_create'] = 'Преобразование файлов';
                    //$res = require APP . '/vendor/PHPExcel/PHPExcel.php';
                    $excel = new ExcelModel();
                    $excel->xlsToCsv($model->getUploadFiles());

                };
            }
        }


        // 2. Преобразовать файлы в csv
        // 3. Распарсить csv и занести в mysql данные
        // 4. сформировать файл xlsx
        // 5. отправить файл адресату
        // 6. Удалить файл с почты
    }

    /*
     *  Работа с водителями
     *  - добавление
     *  - удаление
     *  - редактирование
     */
    public function actionDrivers()
    {
        if ($this->user->isGuest()) {
            $model = new driverModel();
            $drivers = $model->getDrivers();
            $this->setDataView(['user' => $this->user->getNameUser(), 'drivers' => $drivers]);
        }
    }

    public function actionEditDriver()
    {
        if ($this->user->isGuest()) {
            $id = $this->route['param'];
            $model = new driverModel();
            $cardData = $model->getCardDriver($id);
            $this->setDataView(['user' => $this->user->getNameUser(), 'carDataDriver' => $cardData[0]]);
        }
    }

    public function actionEditAutoDriver()
    {
        if ($this->user->isGuest()) {
            $model = new driverModel();
            if (!empty($_POST['select-auto']) &&
                !empty($_POST['massa-auto']) &&
                !empty($_POST['number-auto']) &&
                !empty($_POST['id_driver'])) {
                $saveAvto = $model->setDriverAuto($_POST);
                header("Location: /admin/edit-driver/{$_POST['id_driver']}"); die;
            }
            $marka = $model->getMarkaAuto();
            $this->setDataView(['user' => $this->user->getNameUser(), 'marka' => $marka]);
        }
    }
}