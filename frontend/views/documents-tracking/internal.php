<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\datetime\DateTimePicker;
use frontend\models\Positions;


/* @var $this yii\web\View */
/* @var $model frontend\models\IncomingFiles */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="incoming-files-form">
    
    <?php $form = ActiveForm::begin(); ?>
    
   <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
  <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
       
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
    
</div>
