<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use frontend\models\DocumentsTracking;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DashboardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dashboard-index">

   
       <?php  echo $this->render('_search', ['model' => $searchModel]); ?> 
               
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
            'type' => GridView::TYPE_SUCCESS,
            'heading' => '<i class="glyphicon glyphicon-folder-open"></i> &nbsp; Files Movements Dashboard',
        ],          
        'toolbar' => [
        [
            'content'=>
                Html::button('<i class="glyphicon glyphicon-plus"></i>&nbsp; New File',[
                    'type'=>'button',
                    'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['files/create']) . "';",
                    'title'=>Yii::t('kvgrid', 'Add New File'), 
                    'class'=>'btn btn-success',
                    'id' =>'filesModal',
                ]) . ' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i>&nbsp; Refresh', ['index'], [
                    'class' => 'btn btn-default', 
                    'title' => Yii::t('kvgrid', 'Reset Grid'),
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
            
            
             [  
                'class' => 'kartik\grid\ActionColumn',
               'header' => 'Change',
               'template'=>'{update}',
                'buttons' => [

            //view button
            'update' => function ($id, $model) {

                 return  '<div class="dropdown">
                          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">File Options
                          <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                                <li>'.Html::a('<span class="glyphicon glyphicon-download-alt"> To Incoming</span>',Url::to(['dashboard/update1','id'=>$model->id]), ['title' => 'Incoming','style'=>'background:none;border:none']).' </li>
                                <li>'.Html::a('<span class="glyphicon glyphicon-download"> To Internal</span>',Url::to(['dashboard/update2','id'=>$model->id]), ['title' => 'Internal','style'=>'background:none;border:none']).' </li>
                                <li>'.Html::a('<span class="glyphicon glyphicon-share-alt"> To Outgoing</span>',Url::to(['dashboard/update3','id'=>$model->id]), ['title' => 'Outgoing','style'=>'background:none;border:none']).' </li>
                                <li>'.Html::a('<span class="glyphicon glyphicon-transfer"> Movement History</span>',Url::to(['incoming-files/movementhistory','id'=>$model->file_id]), ['title' => 'Movement history','style'=>'background:none;border:none']).' </li>    
                             
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
        'header'=>'Action',       
        'template' => '{update}',
        'buttons' => [
                'update' => function ($id, $model) {
                            if($model->file_status == 1) {
                                    return Html::a(
                                            '<span class="glyphicon glyphicon-pencil"> Edit </span>' 
                                               ,Url::to(['dashboard-update/update1','id'=>$model->id]));
                            }else if($model->file_status == 2) {
                                    return Html::a(
                                            '<span class="glyphicon glyphicon-pencil"> Edit </span>' 
                                               ,Url::to(['dashboard-update/update2','id'=>$model->id]));

                            }else {
                                    return Html::a(
                                            '<span class="glyphicon glyphicon-pencil"> Edit </span>' 
                                               ,Url::to(['dashboard-update/update3','id'=>$model->id]));                       
                                         }      
                             },                
                         ],
                     ],        
                  ],
             ]); ?>
    
    <?php
        Modal::begin([
                'header' => '<h4> Create new file. </h4>',
                'id' => 'files',
                'size' => 'modal-lg',
                'options'=> [
                    'data-backdrop'=>'static',
                    'data-keyboard'=>'false',
                ],            
               ]);
               echo "<div id='filesContent'></div>";
               
           Modal::end();    
    ?>  
    
    
    
    <?php
      $documents = new DocumentsTracking;
    ?>

    <p>
       <?= Html::button('New Document', ['value' => Url::to('index.php?r=documents-tracking/create'), 'class' => 'btn btn-success', 'id' =>'modalButton']) ?>
    </p>
    
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

    
    <?= GridView::widget([
        'dataProvider' => $docProvider,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        
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
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="glyphicon glyphicon-envelope"></i> &nbsp; Letters, Loose Minutes and Other Documents Dashboard',
        ],          
        'toolbar' => [
        [
            'content'=>
                Html::button('<i class="glyphicon glyphicon-plus"></i>&nbsp; New Document',[
                    'type'=>'button',
                    'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['documents-tracking/create']) . "';",
                    'title'=>Yii::t('kvgrid', 'Add New Document'), 
                    'class'=>'btn btn-success',
                    'id' =>'filesModal',
                ]) . ' '.
                Html::a('<i class="glyphicon glyphicon-tasks"></i>&nbsp; Your Documents', ['documents-tracking/index'], [
                    'class' => 'btn btn-default', 
                    'title' => Yii::t('kvgrid', 'All Documents')
                ]),
        ],
        '{export}',
        '{toggleData}'
        ],
        
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'date',
            [
             'attribute' => 'subject',
             'contentOptions' => [ 'style' => 'width: 30%;' ],
            ],
            [
             'attribute'=>'from_who',
             'value'=>'from.username'
            ],
            [
             'attribute'=>'forwaded_to',
             'value'=>'forward.username'
            ],
            'time',
            [  
                'class' => 'kartik\grid\ActionColumn',
               'header' => 'Change',
               'template'=>'{update}',
                'buttons' => [

            //view button
            'update' => function ($id, $model) {

                 return  '<div class="dropdown">
                          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Change Status
                          <span class="caret"></span></button>
                          <ul class="dropdown-menu">                    
                          <li>'.Html::a('<span class="glyphicon glyphicon-download"> To Internal</span>',Url::to(['documents-tracking/update2','id'=>$model->docId]), ['title' => 'Internal','style'=>'background:Bisque;border:none']).' </li>
                          <li>'.Html::a('<span class="glyphicon glyphicon-share-alt"> To Outgoing</span>',Url::to(['documents-tracking/update3','id'=>$model->docId]), ['title' => 'Outgoing','style'=>'background:Bisque;border:none']).' </li>
                          </ul>
                        </div>';


            },
        ],
            ],
               
                        
             [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'Action',       
        'template' => '{update}',
        'buttons' => [
                'update' => function ($id, $model) {
                    if($model->file_status == 1) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-pencil"> Edit </span>' 
                                       ,Url::to(['documents-update/editincomingdoc','id'=>$model->docId]));
                    }else if($model->file_status == 2) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-pencil"> Edit </span>' 
                                       ,Url::to(['documents-update/editinternaldoc','id'=>$model->docId]));
                        
                    }else {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-pencil"> Edit </span>' 
                                       ,Url::to(['documents-update/editoutgoingdoc','id'=>$model->docId]));
                        
                    }
                },
                
        ],
],                
                        
                        
            ]
                  
    ]); ?>
    <?php Pjax::end(); ?>
</div>