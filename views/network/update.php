<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\database\ActiveRecords\NetworkRecord */

$this->title = 'Update Network Record: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Network Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="network-record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>