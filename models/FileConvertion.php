<?php

namespace app\models;

use Yii;
use yii\web\Response;

/**
 * Class FileConvertion
 * @package app\models
 * Класс отвечает за конвертацию данных data.txt в result.txt
 * @var string $fileName хранит имя файла.
 * @var string $fileFullName хранит полный путь к файлу.
 * @var boolean $firstTime хранит флаг первой или нет операции.
 * @return Response result.txt
 */
class FileConvertion
{
    public static function convert($fileName)
    {
        $fileFullName = 'uploads/' . $fileName;
        $file_content = file_get_contents($fileFullName);
        unlink($fileFullName);
        $file_content = preg_replace('/\s/', '', $file_content);
        $result = array();
        foreach (preg_split('/;/', $file_content) as $string) {
            /* создаем массив ключ=>значение из строки формата ключ=значение */
            list($key, $value) = preg_split('/=/', $string);
            $firstTime = true;
            foreach (preg_split('/\./', $key) as $string_part) {
                if ($firstTime) {
                    $select = &$result[$string_part];
                    $firstTime = !$firstTime;
                } else $select = &$select[$string_part];

            }
            $select = $value;
            unset($select);
        }
        array_pop($result);
        $file = print_r($result, $return = true);
        file_put_contents('uploads/result.txt', $file);
        Yii::$app->response->SendFile('uploads/result.txt', 'result.txt');
    }
}