<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\IncomingFiles */

$this->title = 'Update Incoming Files: ' . $model->incId;
$this->params['breadcrumbs'][] = ['label' => 'Incoming Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->incId, 'url' => ['view', 'id' => $model->incId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="incoming-files-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
