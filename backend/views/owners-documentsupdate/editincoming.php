<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\DocumentsTracking */

$this->title = 'Update Documents Tracking: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Documents Trackings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->docId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="documents-tracking-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('incoming', [
        'model' => $model,
    ]) ?>

</div>
