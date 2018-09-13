<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\IncomingFiles */

$this->title = 'Files History';
$this->params['breadcrumbs'][] = ['label' => 'Incoming Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoming-files-view">

    <h1><?= 'Files History' ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'incId',
            'date',
            'file.file_number',
            'file.file_name',
            'deadline',
            'delivered_by',
            'received_by',
            'action_number',
            'action',
            'courier',
            'time',
            'fileStatus.status',
            'messenger_time',
            'recipient_time',
        ],
    ])
        ?>
<p>
        <?= Html::a('Send File (PS) ', ['messenger', 'id' => $model->incId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Receive File', ['recipient', 'id' => $model->incId], ['class' => 'btn btn-success']) ?>
    </p>
</div>
