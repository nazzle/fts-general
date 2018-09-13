<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DashboardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Registry Status                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dashboard-index">

    <h1><?php echo 'Registry Status'; ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    
 
    <h3><?php echo 'Files'; ?></h4>
     
    
    <?php Pjax::begin(); ?>
    
    <?= GridView::widget([
        'dataProvider'=> $dataProvider,
        'rowOptions'=>function($model){
            if($model->file_status == 1){
                return ['class' => 'success'];
            }elseif ($model->file_status == 2) {
                return ['class' => 'info'];  
            } else {
               return ['class' => 'danger']; 
           }
          },
         
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '-'],
                  
        'responsive'=>true,
        'hover'=>true,
        'pjax'=>true,
        'pjaxSettings'=>[
            'neverTimeout'=>true,
           // 'beforeGrid'=>'*This provides a list of file destination status.',
           // 'afterGrid'=>'My fancy content after.',
         ],
        'beforeHeader' => [],
        //'resizableColumns'=>true,
        'floatHeader'=>true,
       // 'showPageSummary' => true,
       // 'pageSummaryRowOptions' => ['class' => 'kv-page-summary warning'],
        'panel' => [
            'type' => GridView::TYPE_INFO,
            'heading' => '<i class="glyphicon glyphicon-list-alt"></i> &nbsp; Registry',
        ],          
        'toolbar' => [
        [
            'content'=>
                Html::button('<i class="glyphicon glyphicon-arrow-left"></i>&nbsp; Dashboard',[
                    'type'=>'button',
                    'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['dashboard/index']) . "';",
                    'title'=>Yii::t('kvgrid', 'Back to Dashboard'), 
                    'class'=>'btn btn-success',
                ])
        ],
        '{export}',
        '{toggleData}'
        ],          
                  
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'file_id',
                'value' => 'file.file_number'
                ],
            [
             'attribute'=>'forwaded_to',
             'value'=>'forward.position'
            ],

            'date',
            'time',            
            [
             'attribute'=>'sender',
             'value'=>'send.username'
            ],

            [
            'attribute' => 'deadline',
            'contentOptions' => function ($model) {
                return ['style' => 'background-color:' 
                    . ($model->deadline == NULL ? 'none' :  ($model->deadline < $model->finish_time ? 'red' : 'none'))];
                },
             ],
 
            ['class' => 'yii\grid\ActionColumn',
                'header'=>'See More', 
                'template' => '{view}',
             
                ],
             [
            'attribute' => 'registry_status',
            'contentOptions' => function ($model) {
                return ['style' => 'background-color:' 
                    . ($model->registry_status == 'Return To Registry' ? 'yellow' : 'green' )];
                },
             ],           
                    
            
        ],
    ]); ?>       
    
     <?php Pjax::end(); ?>
</div>