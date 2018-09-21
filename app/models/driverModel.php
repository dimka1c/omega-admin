<?php
/**
 * Created by PhpStorm.
 * User: dimka1c
 * Date: 20.09.2018
 * Time: 16:07
 */

namespace app\models;


use vendor\core\AppModel;

class driverModel extends AppModel
{

    protected $drivers = [];

    public function getDrivers()
    {
        $sql = "SELECT 
	              driver.id, driver.driver_name, driver.driver_phone, driver.driver_ml_name, driver.driver_worked,
	              avto_number, auto.avto_massa 
                FROM driver 
                LEFT JOIN driver_auto as auto on auto.driver_id = driver.id
                ORDER BY driver.driver_name ASC";
        $this->drivers = $this->findAll($sql);
        return $this->drivers;
    }

    public function getCardDriver(int $id): array
    {
        return $this->findAll("select * from driver left join driver_auto as auto on auto.driver_id = driver.id left join marka_auto as model on model.id = auto.model_id where driver.id = $id");
    }

    public function getMarkaAuto(): array
    {
        return $this->findAll("SELECT * FROM marka_auto");
    }

    public function setDriverAuto(array $avto): bool
    {
        $id = $avto['id_driver'];
        $findDriver = $this->findAll("select * from driver_auto where driver_id = {$id} LIMIT 1");
        $number_avto = $avto['number-auto'];
        $massa_avto = $avto['massa-auto'];
        if (!$findDriver) {
            $res = $this->query("INSERT INTO driver_auto (model_id, driver_id, avto_number, avto_massa) VALUES ({$avto['select-auto']}, '{$avto['id_driver']}', '{$number_avto}', '$massa_avto')");
            return $res;
        } else {
            //$sql = "UPDATE driver_auto SET model_id={$avto['select-auto']}, avto_number='{$number_avto}', avto_massa={$massa_avto} WHERE  id = {$id};";
            $res = $this->query("UPDATE driver_auto SET model_id={$avto['select-auto']}, avto_number='{$number_avto}', avto_massa={$massa_avto} WHERE  driver_id = {$id};");
            return $res;
        }
        return false;
    }


}