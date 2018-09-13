<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\IncomingFilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'FTS messenger box';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoming-files-index">

    <h1><?php echo 'Messenger box'; ?></h1>
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

            'deadline',
            'action_number',
 
             'time',
            [  
               'header' => 'status',
               'value'=>'fileStatus.status',
            ],
            [  
                 'class' => 'yii\grid\ActionColumn',
               'header' => 'Send to Recipient',
               'template'=>'{update}',
                'buttons' => [

            //view button
            'update' => function ($id, $model) {

                 return 
                        Html::a('<span class="fa fa-cart-arrow-down "></span>'.' Send file', ['messenger', 'id' =>$model->incId],
                        ['class' => 'btn btn-success']);

            },
        ],
            ],
                
        ],
    ]); ?>
     <?php Pjax::end(); ?>
    
</div>