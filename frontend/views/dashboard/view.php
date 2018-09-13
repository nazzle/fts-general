<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\Files;

/* @var $this yii\web\View */
/* @var $model frontend\models\IncomingFiles */
$file = new Files;
//$this->title = $model->id;
$this->title = 'Movement Details';
$this->params['breadcrumbs'][] = ['label' => 'dashboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dashboard-view">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    <p>
        <?= Html::a('Go Back', ['dashboard/index'], ['class' => 'btn btn-primary']) ?>        

    </p>-->
    
   

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
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
   

</div>
