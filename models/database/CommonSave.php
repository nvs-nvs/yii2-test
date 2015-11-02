<?php namespace app\models\database;
use Yii;
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 23.10.2015
 * Time: 10:27
 */
abstract class CommonSave
{
    private $filePath='';
    private $dir = 'uploads/databaseFiles/';
    public $msg = "";
    private $file;

    public function setFile( $fileName ) {
        $this->file = $fileName;
        $this->filePath = $this->dir . "$fileName";
    }

    public function begin ()
    {
        $file_content = trim(file_get_contents($this->filePath));
        unlink($this->filePath);
        $file_content = explode("\r\n", $file_content);
        array_shift($file_content);
        if (end($file_content) == '') array_pop($file_content);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($file_content as $string) {
                trim($string);
                $string = preg_split("/\s|\t{2,}/", $string);
                $this->save($string);
            }
            $transaction->commit();
            $this->msg = "$this->file succesfully saved into database <br>";
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    abstract public function save($string);
}