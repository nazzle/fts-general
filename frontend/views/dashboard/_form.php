<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Dashboard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dashboard-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'file_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subject')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'from_who')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_who')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sender')->textInput() ?>

    <?= $form->field($model, 'delivered_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'received_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'forwarded_to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deadline')->textInput() ?>

    <?= $form->field($model, 'time')->textInput() ?>

    <?= $form->field($model, 'action')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'action_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'courier')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file_status')->textInput() ?>

    <?= $form->field($model, 'messenger_time')->textInput() ?>

    <?= $form->field($model, 'recipient_time')->textInput() ?>

    <?= $form->field($model, 'finish_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
