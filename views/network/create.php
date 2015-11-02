<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\database\ActiveRecords\NetworkRecord */

$this->title = 'Create Network Record';
$this->params['breadcrumbs'][] = ['label' => 'Network Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="network-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>