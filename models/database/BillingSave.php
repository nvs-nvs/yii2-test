<?php
namespace app\models\database;

use app\models\database\ActiveRecords\BillingRecord;
use Yii;
use yii\base\ErrorException;

/**
 * Class BillingSave
 * @package app\models\database
 * Класс отвечает за сохранение в базе содержимого файла billing.txt
 * Вызывается из actionData() контроллера SiteController.
 * @var string $model хранит имя модели.
 * @return void
 */
class BillingSave extends CommonSave
{

    private $model = '';

    /*первичная инициализация*/
    public function __construct()
    {
        $this->setFile('billing.txt');
        $this->begin();
    }

    /**переопределяем метод для сохранения файла со структурой billing.txt
     * лимит операции увеличиваем, так как все занимает около 10 минут,
     * валлидируем, присваеваем полям, сохраняем.
    */
    public function save($string)
    {
        set_time_limit(1800);
        $this->model = new BillingRecord();
        if (!$this->model->validate($string)) {
            throw new ErrorException ("Не корректные данные");
        }
        $this->model->agency_id = $string[0];
        $this->model->user_id = $string[1];
        $this->model->date = $string[2];
        $this->model->amount = $string[3];
        $this->model->save();
        unset ($this->model);
    }
}
