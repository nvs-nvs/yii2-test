<?php
use yii\widgets\ActiveForm;
/**
 * Представление для actionRegexp
 * форма ввода файла
 * @var $this yii\web\View
*/
$this->title = 'Работа с базой данных';
?>
<div>

    <?php $form = ActiveForm::begin([
            'options' =>
            ['enctype' => 'multipart/form-data']
        ]) ?>

    <?= $form->field($model, 'txtFile')->fileInput() ?>

    <button>Отправить</button>
    <?php ActiveForm::end() ?>
</div>
