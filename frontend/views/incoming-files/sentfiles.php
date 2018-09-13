<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\IncomingFilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'FTS Sent Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoming-files-index">

  
   <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

   <?php
        Modal::begin([
                'header' => '<h4> FTS Documents tracking. </h4>',
                'id' => 'modal',
                'size' => 'modal-lg', 
                'options'=> [
                    'data-backdrop'=>'static',
                    //'data-keyboard'=>'false',
                ],
               ]);
               echo "<div id='modalContent'></div>";
               
           Modal::end();    
    ?>      
    
    <?php Pjax::begin(); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
            'heading' => '<i class="glyphicon glyphicon-send"></i> &nbsp; Sent Files',
        ],          
        'toolbar' => [
        [
            'content'=>
                Html::button('<i class="glyphicon glyphicon-tasks"></i>&nbsp; Dashboard',[
                    'type'=>'button',
                    'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['dashboard/index']) . "';",
                    'title'=>Yii::t('kvgrid', 'To Dashboard'), 
                    'class'=>'btn btn-success',
                    'id' =>'filesModal',
                ]) . ' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i>&nbsp; Refresh', ['index'], [
                    'class' => 'btn btn-default', 
                    'title' => Yii::t('kvgrid', 'Reset Grid')
                ]),
        ],
        '{export}',
        '{toggleData}'
        ],          
                  
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

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
                    . ($model->deadline == NULL ? 'none' :  ($model->deadline < $model->finish_time ? 'pale-red' : 'none'))];
                },
             ],
            'action_number',
 
             'time',
            [  
               'header' => 'status',
               'value'=>'fileStatus.status',
            ],
            [  
                'class' => 'yii\grid\ActionColumn',
               'header' => 'Change',
               'template'=>'{update}',
                'buttons' => [

            //view button
            'update' => function ($id, $model) {

                 return  '<div class="dropdown">
                          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Change Status
                          <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                          <li>'.Html::a('<span class="glyphicon glyphicon-download-alt"> To Incoming</span>',Url::to(['incoming-files/update1','id'=>$model->incId]), ['title' => 'Incoming','style'=>'background:none;border:none']).' </li>
                          <li>'.Html::a('<span class="glyphicon glyphicon-download"> To Internal</span>',Url::to(['incoming-files/update2','id'=>$model->incId]), ['title' => 'Internal','style'=>'background:none;border:none']).' </li>
                              <li>'.Html::a('<span class="glyphicon glyphicon-share-alt"> To Outgoing</span>',Url::to(['incoming-files/update3','id'=>$model->incId]), ['title' => 'Outgoing','style'=>'background:none;border:none']).' </li>
                          </ul>
                        </div>';


            },
        ],
            ],

            [
                'class' => 'kartik\grid\ExpandRowColumn',
                //'width' => '50px',
                'header'=> 'See More',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detail' => function ($model, $key, $index, $column) {
                    return Yii::$app->controller->renderPartial('view', ['model' => $model]);
                },
                'headerOptions' => ['class' => 'kartik-sheet-style'], 
                'expandOneOnly' => true
            ],
             
             [
                'class' => 'kartik\grid\ActionColumn',
                 'header'=> 'Delete',
                'template' => '{delete}',
                 'deleteOptions' => ['title' => 'This will erase all of this entry details.', 'data-toggle' => 'tooltip'],
                ],                
        ],
    ]); ?>
     <?php Pjax::end(); ?>
    
</div>
