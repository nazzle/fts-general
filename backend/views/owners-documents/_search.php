<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\DocumentsTrackingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documents-tracking-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'docId') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'subject') ?>

    <?= $form->field($model, 'from_who') ?>

    <?php // echo $form->field($model, 'to_who') ?>

    <?php // echo $form->field($model, 'sender') ?>

    <?php // echo $form->field($model, 'delivered_by') ?>

    <?php // echo $form->field($model, 'received_by') ?>

    <?php // echo $form->field($model, 'forwarded_to') ?>

    <?php // echo $form->field($model, 'deadline') ?>

    <?php // echo $form->field($model, 'time') ?>

    <?php // echo $form->field($model, 'action') ?>

    <?php // echo $form->field($model, 'action_number') ?>

    <?php // echo $form->field($model, 'courier') ?>

    <?php // echo $form->field($model, 'file_status') ?>

    <?php // echo $form->field($model, 'messenger_time') ?>

    <?php // echo $form->field($model, 'recipient_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
