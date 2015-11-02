<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 09.10.2015
 * Time: 8:05
 */
namespace app\models;
use Yii;

class FileConvertion
{
    public static function convert($fileName)
    {
        $fileFullName='uploads/'.$fileName;
        $file_content=file_get_contents($fileFullName);
        unlink($fileFullName);
        $file_content=preg_replace('/\s/','',$file_content);
        $result = array();
        foreach(preg_split('/;/',$file_content) as $string) {
            list($key,$value) = preg_split('/=/',$string);
            $firstTime = true;
            foreach(preg_split('/\./',$key) as $string_part)
            {
                if($firstTime)
                {
                    $select = &$result[$string_part];
                    $firstTime = !$firstTime;
                }
                     else $select = &$select[$string_part];

            }
            $select = $value;
            unset($select);
        }
        array_pop($result);
        $file=print_r($result, $return = true);
        file_put_contents('uploads/result.txt',$file);
        Yii::$app->response->SendFile('uploads/result.txt','result.txt');
    }
}