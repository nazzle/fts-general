<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\IncomingFiles */

$this->title = 'Receive File: ' . $model->incId;
$this->params['breadcrumbs'][] = ['label' => 'Incoming Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->incId, 'url' => ['view', 'id' => $model->incId]];
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="incoming-files-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('incoming', [
        'model' => $model,
        'incoming' => $incoming,
    ]) ?>

</div>
