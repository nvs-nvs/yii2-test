<?php
namespace app\models\database;
use app\models\database\ActiveRecords\BillingRecord;
use Yii;

/**
 * Created by PhpStorm.
 * User: 1
 * Date: 23.10.2015
 * Time: 11:17
 */
class BillingSave extends CommonSave{

    private $model ='';

    public function __construct()
    {
        $this->setFile('billing.txt');
        $this->begin();
    }
    public function save($string)
    {
        set_time_limit(1800);
        $this->model = new BillingRecord();
        if ($this->model->validate($string)) {
            $this->model->agency_id = $string[0];
            $this->model->user_id = $string[1];
            $this->model->date = $string[2];
            $this->model->amount = $string[3];
            $this->model->save();
        } else return print_r($errors = $this->model->errors, true);
    }
}
