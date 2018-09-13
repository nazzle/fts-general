<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\IncomingFiles */

$this->title = 'Send Document: ' . $model->docId;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->docId, 'url' => ['view', 'id' => $model->docId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="incoming-files-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('outgoing', [
        'model' => $model,
        'outgoing' =>$outgoing,
    ]) ?>

</div>
