<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Positions;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\models\IncomingFiles */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="incoming-files-form">
    
    <?php $form = ActiveForm::begin(); ?>
    
 <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>  
 
<?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($outgoing, 'from_who')->widget(Select2::classname(),[
    'name' => 'kv-state-210',
    'data' =>[ArrayHelper::map(Positions::find()->where(['user_type' =>'facilitator'])->all(), 'id', 'position')],
    'size' => Select2::MEDIUM,
    'options' => ['placeholder' => 'File from...'],
    'pluginOptions' => [
        'allowClear' => true
      ],
        ])    
            ?>
    
     <?= $form->field($outgoing, 'forwarded_to')->widget(Select2::classname(),[
    'name' => 'kv-state-210',
    'data' =>[ArrayHelper::map(Positions::find()->where(['user_type' =>'implementer'])->all(), 'id', 'position')],
    'size' => Select2::MEDIUM,
    'options' => ['placeholder' => 'Send to...'],
    'pluginOptions' => [
        'allowClear' => true
      ],
        ])    
            ?>
     
     <?= $form->field($outgoing, 'action_number')->textInput(['autofocus' => true]) ?>
    
    
    <?= $form->field($outgoing, 'courier')->textInput(['maxlength' => true,]) ?>
    
   
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Send File', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>

