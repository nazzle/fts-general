<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Positions;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model frontend\models\IncomingFiles */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="incoming-files-form">
    
    <?php $form = ActiveForm::begin(); ?>
    
   
 
     <?= $form->field($model, 'title')->widget(Select2::classname(), [
                'data' => [ 'Letter' => 'Letter', 'Loose Minute' => 'Loose Minute', 'Other Documents' => 'Other Documents', ],
                'options' => ['placeholder' => 'Select a document type ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
             ]); ?>
    
    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
    
    
        <?= $form->field($model, 'from_who')->widget(Select2::classname(),[
    'name' => 'kv-state-210',
    'data' =>[ArrayHelper::map(Positions::find()->all(), 'id', 'position')],
    'size' => Select2::MEDIUM,
    'options' => ['placeholder' => 'Select From...'],
    'pluginOptions' => [
        'allowClear' => true
        ],
        ])    
            ?>    
    
     <?= $form->field($model, 'forwarded_to')->widget(Select2::classname(),[
    'name' => 'kv-state-210',
    'data' =>[ArrayHelper::map(Positions::find()->all(), 'id', 'position')],
    'size' => Select2::MEDIUM,
    'options' => ['placeholder' => 'Select document Destination...'],
    'pluginOptions' => [
        'allowClear' => true
        ],
        ])    
            ?>
    
    <?= $form->field($model, 'delivered_by')->textInput(['maxlength' => true]) ?>
     
     <?= $form->field($model, 'action_number')->textInput(['autofocus' => true]) ?>
    
    <?= $form->field($model, 'action')->textarea(['rows' => '4']) ?>
    


    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
