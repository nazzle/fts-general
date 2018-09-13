<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model frontend\models\IncomingFiles */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $name = new User; ?>

<div class="documents-tracking-form">
    
    <?php $form = ActiveForm::begin(); ?>
    
   

    <?= $form->field($model, 'title')->dropDownList([ 'Letter' => 'Letter', 'Loose Minute' => 'Loose Minute', 'Other Documents' => 'Other Documents', ], ['prompt' => 'Select Document Type..']) ?>
 
    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'from_who')->dropDownList(
              ArrayHelper::map(User::find()->all(), 'id', 'username'), ['prompt'=>'Select From...']
            ) ?>

    <?= $form->field($model, 'forwarded_to')->dropDownList(
              ArrayHelper::map(User::find()->all(), 'id', 'username'), ['prompt'=>'Select document Destination..']
            ) ?>
    
    <?= $form->field($model, 'delivered_by')->textInput(['maxlength' => true]) ?>
     
     <?= $form->field($model, 'action_number')->textInput(['autofocus' => true]) ?>
    
    <?= $form->field($model, 'action')->textarea(['rows' => '4']) ?>
    


    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update Details', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
