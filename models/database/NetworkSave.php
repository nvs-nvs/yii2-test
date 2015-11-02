<?php
namespace app\models\database;
use app\models\database\ActiveRecords\NetworkRecord;

/**
 * Created by PhpStorm.
 * User: 1
 * Date: 23.10.2015
 * Time: 11:17
 */
class NetworkSave extends CommonSave{

    private $model ='';

    public function __construct()
    {
        $this->setFile('agency_network.txt');
        $this->begin();
    }
    public function save($string)
    {
        $this->model = new NetworkRecord();
        if ($this->model->validate($string)) {
            $this->model->agency_network_id = $string[0];
            $this->model->agency_network_name = $string[1];
            $this->model->save();
            } else return print_r($errors = $this->model->errors, true);
        }
}
