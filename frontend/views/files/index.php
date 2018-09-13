<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Files List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="files-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Create New File', ['value' => Url::to('index.php?r=files/create'), 'class' => 'btn btn-success', 'id' =>'modalButton']) ?>
    </p>
    
     <?php
        Modal::begin([
                'header' => '<h4> Create new file. </h4>',
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
        'dataProvider' => $pendingGrid,
        'filterModel' => $searchModel,
        'rowOptions' => function(){
                        return ['class' => 'danger'];
                            },
        'options' => [ 'style' => 'table-layout:fixed;' ],
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
            'type' => GridView::TYPE_DANGER,
            'heading' => '<i class="glyphicon glyphicon-folder-open"></i> &nbsp; Pending Files (Waiting for approval)',
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

            [
                'attribute' =>'owner_id',
                'value' => 'owner.username',
            ],
            'file_number',
            [
             'attribute' => 'file_name',
             'contentOptions' => [ 'style' => 'width: 30%;' ],
            ],
            'created_date',
            'created_by',

            ['class' => 'kartik\grid\ActionColumn',
                'header' =>'Edit File',
                'template' => '{update}',
                ],
            
                 [
        'class' => 'kartik\grid\ActionColumn',
        'header'=>'Action',       
        'template' => '{update}',
        'buttons' => [
                'update' => function ($id, $model) {
                    if($model->status == 4) {
                            return Html::a(
                                    '<span class="glyphicon glyphicon-ok">Approve </span>' 
                                       ,Url::to(['files/viewpending','id'=>$model->file_id]));
                    }
                            },

                    ],
            ],
        ],
    ]); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function(){
                        return ['class' => 'success'];
                            },
        'options' => [ 'style' => 'table-layout:fixed;' ],
         
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
            'heading' => '<i class="glyphicon glyphicon-list-alt"></i> &nbsp; Approved Files (In use already)',
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

            [
                'attribute' =>'owner_id',
                'value' => 'owner.username',
            ],
            'file_number',
            [
             'attribute' => 'file_name',
             'contentOptions' => [ 'style' => 'width: 30%;' ],
            ],
            'created_date',
            'created_by',

            ['class' => 'kartik\grid\ActionColumn',
                'header' =>'Edit File',
                'template' => '{update}',
                ],
        ],
    ]); ?>
</div>
