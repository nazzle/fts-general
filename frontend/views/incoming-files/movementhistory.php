<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\IncomingFilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Movement History                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoming-files-index">

    <h1><?php echo 'Movement History'; ?></h1>
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
                  
        'responsive'=>false,
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
            'heading' => '<i class="glyphicon glyphicon-sort"></i> &nbsp; File Movements History',
        ],          
        'toolbar' => [
        [
            'content'=>
                Html::button('<i class="glyphicon glyphicon-arrow-left"></i>&nbsp; Dashboard',[
                    'type'=>'button',
                    'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['dashboard/index']) . "';",
                    'title'=>Yii::t('kvgrid', 'Back to Dashboard'), 
                    'class'=>'btn btn-success',
                ]) . ' '.
                Html::a('<i class="glyphicon glyphicon-transfer"></i>&nbsp; All History', ['incoming-files/index'], [
                    'class' => 'btn btn-default', 
                    'title' => Yii::t('kvgrid', 'To History')
                ]),
        ],
        '{export}',
        '{toggleData}'
        ],          
                  
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'date',
            [
                'attribute'=>'file_id',
                'value' => 'file.file_number'
                ],
      
           // [
            //    'attribute'=>'subject',
            //    'value' => 'file.file_name'
            //    ],
            [
             'attribute'=>'from_who',
             'value'=>'from.position'
            ],

            [
             'attribute'=>'forwaded_to',
             'value'=>'forward.position'
            ],
            
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
            'action_number',
 
             'time',
            [  
               'header' => 'status',
               'value'=>'fileStatus.status',
            ],           

            ['class' => 'yii\grid\ActionColumn',
                'header'=>'See More', 
                'template' => '{view}',
             
                ],
            
           [
        'class' => 'yii\grid\ActionColumn',
        'header'=>'Action',       
        'template' => '{update}',
        'buttons' => [
                'update' => function ($id, $model) {
                    if($model->file_status == 1) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-pencil"> Edit </span>' 
                                       ,Url::to(['files-update/update1','id'=>$model->incId]));
                    }else if($model->file_status == 2) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-pencil"> Edit </span>' 
                                       ,Url::to(['files-update/update2','id'=>$model->incId]));
                        
                    }else {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-pencil"> Edit </span>' 
                                       ,Url::to(['files-update/update3','id'=>$model->incId]));
                        
                    }
                },
                
        ],
],         
            
        ],
    ]); ?>       
    
     <?php Pjax::end(); ?>
</div>