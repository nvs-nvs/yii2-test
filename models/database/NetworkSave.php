<?php
namespace app\models\database;

use app\models\database\ActiveRecords\NetworkRecord;
use yii\base\ErrorException;

/**
 * Class NetworkSave
 * @package app\models\database
 * Класс отвечает за сохранение в базе содержимого файла agency_network.txt
 * Вызывается из actionData() контроллера SiteController.
 * @var string $model хранит имя модели.
 * @return void
 */
class NetworkSave extends CommonSave
{

    private $model = '';
    /*первичная инициализация*/
    public function __construct()
    {
        $this->setFile('agency_network.txt');
        $this->begin();
    }

    /**переопределяем метод для сохранения файла со структурой agency_network.txt
     * валлидируем, присваеваем полям, сохраняем.
     */
    public function save($string)
    {
        $this->model = new NetworkRecord();
        if (!$this->model->validate($string)) {
            throw new ErrorException ("Не корректные данные");
        }
        $this->model->agency_network_id = $string[0];
        $this->model->agency_network_name = $string[1];
        $this->model->save();
        unset ($this->model);
    }
}
