<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Files;
use frontend\models\Positions;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\models\IncomingFiles */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dashboard-form">
    
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
    
    <?= $form->field($model, 'delivered_by')->textInput(['maxlength' => true]) ?>

    
     <?= $form->field($model, 'from_who')->widget(Select2::classname(),[
    'name' => 'kv-state-210',
    'data' =>[ArrayHelper::map(Positions::find()->where(['user_type'=>'facilitator'])->all(), 'id', 'position')],
    'size' => Select2::MEDIUM,
    'options' => ['placeholder' => 'File from...'],
    'pluginOptions' => [
        'allowClear' => true
        ],
        ])    
            ?>
    
    
     <?= $form->field($model, 'forwarded_to')->widget(Select2::classname(),[
    'name' => 'kv-state-210',
    'data' =>[ArrayHelper::map(Positions::find()->where(['user_type'=>'implementer'])->all(), 'id', 'position')],
    'size' => Select2::MEDIUM,
    'options' => ['placeholder' => 'Forward to...'],
    'pluginOptions' => [
        'allowClear' => true
      ],
        ])    
            ?>
    
    
    <?= $form->field($model, 'action_number')->textInput(['autofocus' => true]) ?>
    
    
   
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Receive File', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
