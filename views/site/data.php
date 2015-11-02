<?php
use yii\widgets\ActiveForm;
/** Представление для actionData
 * Форма отправки трех файлов
 * @var $this yii\web\View
 *
 */
$this->title = 'Загрузка в базу';
?>
<div>
    <p>Разрешена только отправка трех файлов вместе: agency_network.txt, agency.txt и billing.txt</p>
    <br>
    <?php $form = ActiveForm::begin([
        'options' =>
            ['enctype' => 'multipart/form-data']
    ]) ?>

    <?= $form->field($model, 'txtFile[]')->fileInput(['multiple' => true]) ?>

    <button>Отправить</button>
    <?php ActiveForm::end() ?>
</div>

