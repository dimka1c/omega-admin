<?php
/**
 * Created by PhpStorm.
 * User: dimka1c
 * Date: 18.09.2018
 * Time: 17:23
 */

namespace app\models;


use vendor\core\AppModel;

class ExcelModel
{

    private $pathFiles = [];

    public $csvFiles = [];


    public function __construct()
    {
        $this->pathFiles = require APP . '/app/config/email.config.php';
    }

    public function xlsToCsv(array $xlsFiles): bool
    {
        $objReader = \PHPExcel_IOFactory::createReader("Excel5");
        foreach ($xlsFiles as $file) {
            $objPHPExcel = $objReader->load(APP . $this->pathFiles['files']['ATTACH'] . '/' . $file);
            $csvWirter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
            $csvWirter->save(APP . $this->pathFiles['files']['CSV'] . '/' . $file);
            $this->csvFiles[] = $file;
            unset($objPHPExcel);
            unset($csvWirter);
        }
        unset($objReader);
        return true;
    }

}