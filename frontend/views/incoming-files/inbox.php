<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use frontend\models\IncomingFiles;
use yii\widgets\Pjax;
use kartik\popover\PopoverX;
use kartik\widgets\DatePicker;
use frontend\models\Dashboard;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\IncomingFilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'FTS inbox';
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
    
    <?php $model = new IncomingFiles; ?>
    
     <?= Html::a('Receive Checked ', ['receivechecked', 'id' => [3,3,2]], ['class' => 'btn btn-warning']) ?>  
     <?= Html::a('Receive all ', ['receiveall'], ['class' => 'btn btn-info']) ?>
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
            'heading' => '<i class="glyphicon glyphicon-inbox"></i> &nbsp; Files To Attend (New)',
        ],          
        'toolbar' => [
       // 'beforeGrid' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',    
        [
            'content'=>
                Html::button('<i class="glyphicon glyphicon-tasks"></i>&nbsp; Dashboard',[
                    'type'=>'button',
                    'onclick'=>"window.location.href = '" . \Yii::$app->urlManager->createUrl(['dashboard/index']) . "';",
                    'title'=>Yii::t('kvgrid', 'To Dashboard'), 
                    'class'=>'btn btn-success',
                    'id' =>'filesModal',
                ]) . ' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i>&nbsp; Refresh', ['inbox'], [
                    'class' => 'btn btn-default', 
                    'title' => Yii::t('kvgrid', 'Reset Grid')
                ]),
        ],
        '{export}',
        '{toggleData}'   
        ],                
                  
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            
            [
          'class' => 'kartik\grid\CheckboxColumn', 
                'checkboxOptions' => function($model) {
                return ['value' => $model['incId']];
            },
                ],

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
               'header' => 'Receive files',
               'template'=>'{update}',
                'buttons' => [

                //view button
                'update' => function ($id, $model) {

                 return 
                        Html::a('<span class="fa fa-folder-open"></span>'.' Receive file', ['recipient', 'id' =>$model->incId],
                        ['class' => 'btn btn-success']);
                   },
                 ],
            ],

            
        ],
    ]); ?>
     
    <?php $registry = new Dashboard; ?>
    <?= GridView::widget([
        'dataProvider' => $todayProvider,
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
                  
//        Kartik from here          
                           
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
            'type' => GridView::TYPE_WARNING,
            'heading' => '<i class="glyphicon glyphicon-inbox"></i> &nbsp; Today&nbsp;'. date('d-m-Y'),
        ],          
        'toolbar' => [
       // 'beforeGrid' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',    

        '{export}',
        '{toggleData}'   
        ],                
                  
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            
            [
          'class' => 'kartik\grid\CheckboxColumn', 
                'checkboxOptions' => function($model) {
                return ['value' => $model['id']];
            },
                ],
                   
            [
                'attribute'=>'file_id',
                'value' => 'file.file_number'
                ],
            [
             'attribute'=>'from_who',
             'value'=>'from.position'
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
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'registry_status',
                'pageSummary' => 'Total',
               // 'vAlign' => 'middle',
                'editableOptions' =>  function ($registry, $key, $index)  {
                    return [
                        'header' => 'Registry Form',
                        'size' => 'md',
                        'footer' => Html::button('Submit', [
                        'class' => 'btn btn-sm btn-primary', 
                        'onclick' => '$.post("#intoh").trigger("submit")'
                        ]) . Html::button('Reset', [
                            'class' => 'btn btn-sm btn-default', 
                            'onclick' => '$("#kv-login-form").trigger("reset")'
                        ]),
                        'placement' => PopoverX::ALIGN_LEFT,
                        'afterInput' => function ($form, $registry) use ($registry, $index) {
                            return $form->field($registry, 'action').
                                    $form->field($registry, 'deadline')->widget(DatePicker::classname(), [
                                   'options' => ['placeholder' => 'Enter date if is for return ...'],
                                   'pluginOptions' => [
                                       'autoclose'=>true
                                   ]
                                   ]);  
                                 }
                          ];
                      }
                     ],                                                                                               
        ],
    ]); ?>
    
    
     <?php Pjax::end(); ?>
    
</div>