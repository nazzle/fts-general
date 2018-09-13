<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\IncomingFiles */

$this->title = 'Outgoing File';// . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Incoming Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dashboard-update">

    <h2><code><?= Html::encode($this->title) ?></code></h2>

    <?= $this->render('outgoing', [
        'model' => $model,
        'outgoing' => $outgoing,
    ]) ?>

</div>
