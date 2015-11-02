<?php
namespace app\models\database;

use app\models\database\ActiveRecords\AgencyRecord;
use yii\base\ErrorException;

/**
 * Class AgencySave
 * @package app\models\database
 * Класс отвечает за сохранение в базе содержимого файла agency.txt
 * Вызывается из actionData() контроллера SiteController.
 * @var string $model хранит имя модели.
 * @return void
 */
class AgencySave extends CommonSave
{

    private $model = '';

    /*первичная инициализация*/
    public function __construct()
    {
        $this->setFile('agency.txt');
        $this->begin();
    }

    /**переопределяем метод для сохранения файла со структурой agency.txt
     * валлидируем, присваеваем полям, сохраняем.
     */
    public function save($string)
    {
        $this->model = new AgencyRecord();
        if (!$this->model->validate($string)) {
            throw new ErrorException ("Не корректные данные");
        }
        $this->model->agency_id = $string[0];
        $this->model->agency_network_id = $string[1];
        $this->model->agency_name = $string[2];
        $this->model->save();
        unset ($this->model);
    }
}
