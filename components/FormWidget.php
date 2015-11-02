<?php
/**
 *Виджет для actionIndex с формами ввода чисел
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