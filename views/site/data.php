<?php
use yii\widgets\ActiveForm;
/* @var $this yii\web\View
 */
$this->title = 'Загрузка в базу';
?>
<div>
    <p>Все три файла: agency_network.txt, agency.txt и billing.txt обязателены к отправке</p>
    <br>
    <?php $form = ActiveForm::begin([
        'options' =>
            ['enctype' => 'multipart/form-data']
    ]) ?>

    <?= $form->field($model, 'txtFile[]')->fileInput(['multiple' => true]) ?>

    <button>Отправить</button>
    <?php ActiveForm::end() ?>
</div>

