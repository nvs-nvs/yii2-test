<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 12.10.2015
 * Time: 14:33
 */
<
div >

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'txtFile')->fileInput() ?>

<button>Отправить</button>
<?php ActiveForm::end() ?>
</div>