<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Files;
use frontend\models\Owners;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model frontend\models\IncomingFiles */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $name = new User; ?>

<div class="incoming-files-form">
    
    <?php $form = ActiveForm::begin(); ?>
    
 <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>  
 
<?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($outgoing, 'from_who')->dropDownList(
              ArrayHelper::map(User::find()->all(), 'id', 'username'), ['prompt'=>'File sent to..']
            ) ?>
    
     <?= $form->field($outgoing, 'forwarded_to')->dropDownList(
              ArrayHelper::map(User::find()->all(), 'id', 'username'), ['prompt'=>'File sent to..']
            ) ?>
     
     <?= $form->field($outgoing, 'action_number')->textInput(['autofocus' => true]) ?>
    
    
    <?= $form->field($outgoing, 'courier')->textInput(['maxlength' => true,]) ?>
    
   
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Send File', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>

