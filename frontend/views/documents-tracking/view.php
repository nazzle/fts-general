<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\DocumentsTracking */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Documents Trackings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documents-tracking-view">

    <h4><?= Html::encode($this->title) ?></h4>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'docId',
            'date',
            'title',
            'subject:ntext',
            'sender',
            'delivered_by',
            'received_by',
            'deadline',
            'time',
            'action:ntext',
            'action_number',
            'courier',
            'fileStatus.status',
            'messenger_time',
            'recipient_time',
        ],
    ]) ?>
    

</div>
