<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Files;
use kartik\widgets\Select2;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model frontend\models\IncomingFiles */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $name = new User; ?>

<div class="incoming-files-form">
    
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
    
     <?= $form->field($outgoing, 'from_who')->widget(Select2::classname(),[
    'name' => 'kv-state-210',
    'data' =>[ArrayHelper::map(User::find()->all(), 'id', 'username')],
    'size' => Select2::MEDIUM,
    'options' => ['placeholder' => 'File from...'],
    'pluginOptions' => [
        'allowClear' => true
      ],
        ])    
            ?>
    
     <?= $form->field($outgoing, 'forwarded_to')->widget(Select2::classname(),[
    'name' => 'kv-state-210',
    'data' =>[ArrayHelper::map(User::find()->all(), 'id', 'username')],
    'size' => Select2::MEDIUM,
    'options' => ['placeholder' => 'Send to...'],
    'pluginOptions' => [
        'allowClear' => true
      ],
        ])    
            ?>
    
     
     <?= $form->field($outgoing, 'action_number')->textInput(['autofocus' => true]) ?>

     <?= $form->field($outgoing, 'action' )->textarea(['rows' => '2']) ?>
    
    
    <?= $form->field($outgoing, 'courier')->textInput(['maxlength' => true,]) ?>
    
   
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Send File', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
