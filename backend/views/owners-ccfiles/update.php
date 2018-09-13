<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CopiedFiles */

$this->title = 'Update Copied Files: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Copied Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="copied-files-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
