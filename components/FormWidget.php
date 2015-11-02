<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 08.10.2015
 * Time: 9:11
 */
namespace app\components;
use yii\base\Widget;
class FormWidget extends Widget
{
    public function init ()
    {
        parent::init();
    }

    public function run ()
    {
        return $this->render('form');
    }
}