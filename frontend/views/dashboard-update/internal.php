<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Files;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Collapse;
use kartik\widgets\Select2;
use frontend\models\Positions;


/* @var $this yii\web\View */
/* @var $model frontend\models\IncomingFiles */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="dashboard-update-form">
    
    <?php $form = ActiveForm::begin(); ?>
    
   

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
    
   
    
    <?= $form->field($model, 'forwarded_to')->widget(Select2::classname(),[
    'name' => 'kv-state-210',
    'data' =>[ArrayHelper::map(Positions::find()->where(['user_type'=>'facilitator'])->all(), 'id', 'position')],
    'size' => Select2::MEDIUM,
    'options' => ['placeholder' => 'Forward to...'],
    'pluginOptions' => [
        'allowClear' => true
      ],
        ])    
            ?>
    
     
     <?=  Collapse::widget([
    'items' => [
      '+ Add another recipient' => 
            $form->field($ccfiles, "forward_to[]")->widget(Select2::classname(),[    
                        'data' => [ArrayHelper::map(Positions::find()->where(['user_type'=>'facilitator'])->all(), 'id', 'position')],
                        'size' => Select2::MEDIUM,
                        'options' => [
                            'data' =>['forward_to[]'],
                            'multiple'=>'true',
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
  'model' => $model,
  'attribute' => 'deadline',
  'options' => ['placeholder' => 'Enter deadline ...'],
  'pluginOptions' => [
    'autoclose' => true
  ]
 ]);   ?>      
    
    
    <?= $form->field($model, 'action_number')->textInput(['autofocus' => true]) ?>
    
    <?= $form->field($model, 'action' )->textarea(['rows' => '2']) ?>
   
   
     

    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update Details', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
