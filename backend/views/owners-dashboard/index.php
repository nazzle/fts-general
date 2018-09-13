<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use dimmitri\grid\ExpandRowColumn;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DashboardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dashboard-index">

    <h1><?= Html::encode($this->title) ?></h1>
   
       <?php  echo $this->render('_search', ['model' => $searchModel]); ?> 
    
    
   <h3><?php echo 'Files'; ?></h3>
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
   
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
                'class' => 'yii\grid\ActionColumn',
               'header' => 'Change',
               'template'=>'{update}',
                'buttons' => [

            //view button
            'update' => function ($id, $model) {

                 return  '<div class="dropdown">
                          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">File Options
                          <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                                <li>'.Html::a('<span class="glyphicon glyphicon-download-alt"> To Incoming</span>',Url::to(['owners-dashboard/update1','id'=>$model->id]), ['title' => 'Incoming','style'=>'background:none;border:none']).' </li>
                                <li>'.Html::a('<span class="glyphicon glyphicon-download"> To Internal</span>',Url::to(['owners-dashboard/update2','id'=>$model->id]), ['title' => 'Internal','style'=>'background:none;border:none']).' </li>
                                <li>'.Html::a('<span class="glyphicon glyphicon-share-alt"> To Outgoing</span>',Url::to(['owners-dashboard/update3','id'=>$model->id]), ['title' => 'Outgoing','style'=>'background:none;border:none']).' </li>
                                <li>'.Html::a('<span class="glyphicon glyphicon-transfer"> Movement History</span>',Url::to(['owners-history/movementhistory','id'=>$model->file_id]), ['title' => 'Movement history','style'=>'background:none;border:none']).' </li>    
                             
                        </ul>
                          
                        </div>';


            },
        ],
            ],

            [
            'class' => ExpandRowColumn::class,
            'header'=>'See More',
            'attribute' => 'view_link',   
            'ajaxErrorMessage' => 'Oops',
            'ajaxMethod' => 'GET',
            'url' => Url::to(['view']),
            'submitData' => function ($model, $key, $index) {
                return ['id' => $model->id, 'advanced' => true];
            },
            'enableCache' => false,
            'format' => 'raw',
            'expandableOptions' => [
                'title' => 'See More!',
                'class' => 'my-expand',
            ],
            'contentOptions' => [
                'style' => 'display: flex; justify-content: space-between;',
            ],
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
                                       ,Url::to(['owners-dashboardupdate/update1','id'=>$model->id]));
                    }else if($model->file_status == 2) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-pencil"> Edit </span>' 
                                       ,Url::to(['owners-dashboardupdate/update2','id'=>$model->id]));
                        
                    }else {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-pencil"> Edit </span>' 
                                       ,Url::to(['owners-dashboardupdate/update3','id'=>$model->id]));
                        
                    }
                },
                
        ],
],      

            
        ],
    ]); ?>
    

    <p>
       <?= Html::button('New Document', ['value' => Url::to('index.php?r=owners-documents/create'), 'class' => 'btn btn-success', 'id' =>'modalButton']) ?>
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

    
    <h3><?php echo 'Letters and other documents'; ?></h3>
    <?= GridView::widget([
        'dataProvider' => $docProvider,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '-'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
            [
             'attribute'=>'sender',
             'value'=>'send.username'
            ],
            'time',
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
                          <li>'.Html::a('<span class="glyphicon glyphicon-download"> To Internal</span>',Url::to(['owners-documents/update2','id'=>$model->docId]), ['title' => 'Internal','style'=>'background:Bisque;border:none']).' </li>
                          <li>'.Html::a('<span class="glyphicon glyphicon-share-alt"> To Outgoing</span>',Url::to(['owners-documents/update3','id'=>$model->docId]), ['title' => 'Outgoing','style'=>'background:Bisque;border:none']).' </li>
                          </ul>
                        </div>';


            },
        ],
            ],
            
            
            ['class' => 'yii\grid\ActionColumn',
                'header'=>'See More', 
                'template' => '{view}',
                'buttons' => [
                'view' => function ($id, $model) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-eye-open"></span>' 
                                       ,Url::to(['owners-documents/view','id'=>$model->docId]));
                },
                
        ],
             
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
                                       ,Url::to(['owners-documentsupdate/editincomingdoc','id'=>$model->docId]));
                    }else if($model->file_status == 2) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-pencil"> Edit </span>' 
                                       ,Url::to(['owners-documentsupdate/editinternaldoc','id'=>$model->docId]));
                        
                    }else {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-pencil"> Edit </span>' 
                                       ,Url::to(['owners-documentsupdate/editoutgoingdoc','id'=>$model->docId]));
                        
                    }
                },
                
        ],
],                
                        
                        
            ]
                  
    ]); ?>
    <?php Pjax::end(); ?>
</div>
