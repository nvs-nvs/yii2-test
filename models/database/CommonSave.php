<?php namespace app\models\database;

use Yii;

/**
 * Класс представяляет общую логику обработки содержимого предназначенных
 * для записи в базу файлов. Наследуется классами NetworkSave,AgencySave и BillingSave.
 * Содержит абстрактный метод save(), перегружаемый в каждом из вышеуказанных классов.
 *
 *  @var string $filePath хранит полный путь к файлу.
 *  @var string $dir хранит путь к папке сохранения файлов.
 *  @var string $msg хранит строку об успешной загрузке в базу.
 *  @var string $file хранит имя файла.
 */
abstract class CommonSave
{
    private $filePath = '';
    private $dir = 'uploads/databaseFiles/';
    public $msg = "";
    private $file = "";

    /**
     * Инициализация имени файла и пути к нему
    */
    public function setFile($fileName)
    {
        $this->file = $fileName;
        $this->filePath = $this->dir . "$fileName";
    }

    /**
     * Подготоваливаем содержимое файла к загрузке
     */
    public function begin()
    {
        $file_content = trim(file_get_contents($this->filePath));
        unlink($this->filePath);
        $file_content = explode("\r\n", $file_content);
        /*Удаляем строку с названием полей*/
        array_shift($file_content);
        /*если последний элемент оказался пустым избавляемся от него*/
        if (end($file_content) == '') array_pop($file_content);
        /*оформляем всю загрузку через транзакцию*/
        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($file_content as $string) {
                trim($string);
                $string = preg_split("/\s|\t{2,}/", $string);
                /*метод для сохранения в базу для каждого типа файла будет переопределен*/
                $this->save($string);
            }
            $transaction->commit();
            $this->msg = "$this->file succesfully saved into database <br>";
        }
        /*откат действий в случае неудачи*/
        catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    abstract public function save($string);
}