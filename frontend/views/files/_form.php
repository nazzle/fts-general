<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use frontend\models\Owners;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Files */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="files-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <?= $form->field($model, 'owner_id')->widget(Select2::classname(),[
    'name' => 'kv-state-210',
    'data' =>[ArrayHelper::map(Owners::find()->all(), 'id', 'username')],
    'size' => Select2::MEDIUM,
    'options' => ['placeholder' => 'Select a file owner ...'],
    'pluginOptions' => [
        'allowClear' => true
        ],
        ])    
            ?>

    <?= $form->field($model, 'file_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file_name')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'created_by')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
