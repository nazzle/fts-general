<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Files;
use kartik\datetime\DateTimePicker;
use frontend\models\Positions;
use yii\bootstrap\Collapse;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\models\IncomingFiles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dashboard-form">
    
    <div class="box"> <br/>
    
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    
   

    <?= $form->field($model, 'file_id')->dropDownList(
               ArrayHelper::map(Files::find()->all(), 'file_id', 'file_number'), 
                   [
                       'prompt'=>'Select file Number...',
                       'onchange'=> '$.post("index.php?r=files/filelist&id='.'" +$(this).val(),function(data){$("select#incomingfiles-subject").html(data);});'

                       ]
            ) ?>

    
    <?= $form->field($model, 'subject')->dropDownList(
              ArrayHelper::map(Files::find()->all(), 'file_id', 'file_name'), 
                    [
                        'prompt'=>'File Subject...',
                        'onchange'=> '$.post("index.php?r=files/ownerslist&id='.'" +$(this).val(),function(data){$("select#incomingfiles-from_who").html(data);});',
                        'readonly'=>true,
                        ]
            ) ?>   
    
     <?= $form->field($internal, 'forwarded_to')->widget(Select2::classname(),[
    'name' => 'kv-state-210',
    'data' =>[ArrayHelper::map(Positions::find()->where(['user_type' =>'facilitator'])->all(), 'id', 'position')],
    'size' => Select2::MEDIUM,
    'options' => ['placeholder' => 'Forward to...'],
    'pluginOptions' => [
        'allowClear' => true
      ],
        ])    
            ?>
        
    <?= 
       Collapse::widget([
    'items' => [
      '+ Add another recipient' => 
            $form->field($ccfiles, "forward_to[]")->widget(Select2::classname(),[    
                        'data' => [ArrayHelper::map(Positions::find()->where(['user_type' =>'facilitator'])->all(), 'id', 'position')],
                        'size' => Select2::MEDIUM,
                        'options' => [
                            'multiple'=>'true',
                            'data' =>['forward_to[]'],
                            'placeholder' => 'Add recipient...',
                            'class'=>'form-control',
                            ],
                        'pluginOptions' => [
                            'allowClear' => true
                            ],
                           ])   
             ]
            ])      
         ?>

    <?=  '<label class="control-label">Deadline</label>'; ?>
    <?= DateTimePicker::widget([
  'model' => $internal,
  'attribute' => 'deadline',
  'options' => ['placeholder' => 'Enter deadline ...'],
  'pluginOptions' => [
    'autoclose' => true
  ]
 ]);   ?> 
           
    <?= $form->field($internal, 'action_number')->textInput(['autofocus' => true]) ?>
    
    <?php
     if(Yii::$app->user->can('messenger'))
        {
        echo  $form->field($internal, 'action' )->textarea(['rows' => '2','readOnly'=> true]);
        } else {       
        echo  $form->field($internal, 'action' )->textarea(['rows' => '2']); 
       }
    ?> 
     
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Forward File', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
        
      <br/>  </div> 
    
</div>
