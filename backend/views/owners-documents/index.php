<?php

use yii\helpers\Html;
use yii\grid\GridView;
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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
     

       <?= Html::button('New Document ', ['value' => Url::to('index.php?r=owners-documents/create'), 'class' => 'btn btn-success', 'id' =>'modalButton']) ?>
    
    
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
        'filterModel' => $searchModel,
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
