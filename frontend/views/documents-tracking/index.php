<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DocumentsTrackingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Letters and other documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documents-tracking-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
     

      
    
    
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
            if($model->recipient_time == null){
                return ['class' => 'danger'];  
            } else {
               return ['class' => 'success']; 
           }
          },
        'filterModel' => $searchModel,
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
                Html::button('<i class="glyphicon glyphicon-plus"></i>',[
                    'type'=>'button',
                    'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['documents-tracking/create']) . "';",
                    'title'=>Yii::t('kvgrid', 'Add New Document'), 
                    'class'=>'btn btn-success',
                    'id' =>'modalButton',
                ]) . ' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], [
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
               'header' => 'Options',
               'template'=>'{update}',
                'buttons' => [

            //view button
            'update' => function ($id, $model) {

                 return  '<div class="dropdown">
                          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Foward Document
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
                'class' => 'yii\grid\ActionColumn',
               'header' => 'Receive Documents',
               'template'=>'{update}',
                'buttons' => [

            //view button
            'update' => function ($id, $model) {
                    if ($model->recipient_time == null){
                 return 
                        Html::a('<span class="fa fa-clone"></span>'.' Receive Document', ['recipient', 'id' =>$model->docId],
                        ['class' => 'btn btn-link']);
                    }else{
                        return '<span class="fa fa-check"></span>'.' Received';
                    }
            },
        ],
            ],     
                        
            ]
                  
    ]); ?>
    
     <?php Pjax::end(); ?>
</div>
