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

<div class="incoming-files-form">
    
    <?php $form = ActiveForm::begin(); ?>
    
   

    <?= $form->field($doc, 'title')->dropDownList([ 'Letter' => 'Letter', 'Loose Minute' => 'Loose Minute', 'Other Documents' => 'Other Documents', ], ['prompt' => 'Select Document Type..']) ?>
 
    <?= $form->field($doc, 'subject')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($doc, 'from_who')->dropDownList(
              ArrayHelper::map(User::find()->all(), 'id', 'username'), ['prompt'=>'Select From...']
            ) ?>

    <?= $form->field($doc, 'forwarded_to')->dropDownList(
              ArrayHelper::map(User::find()->all(), 'id', 'username'), ['prompt'=>'Select document Destination..']
            ) ?>
    
    <?= $form->field($doc, 'delivered_by')->textInput(['maxlength' => true]) ?>
     
     <?= $form->field($doc, 'action_number')->textInput(['autofocus' => true]) ?>
    
    <?= $form->field($doc, 'action')->textarea(['rows' => '4']) ?>
    


    
    <div class="form-group">
        <?= Html::submitButton($doc->isNewRecord ? 'Create' : 'Update', ['class' => $doc->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
