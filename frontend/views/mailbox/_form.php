<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use frontend\models\User;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model frontend\models\Mailbox */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mailbox-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'forward_to')->widget(Select2::classname(),[
    'name' => 'kv-state-210',
    'data' =>[ArrayHelper::map(User::find()->all(), 'id', 'username')],
    'size' => Select2::MEDIUM,
    'options' => ['placeholder' => 'Send to ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])    
            ?>
    <?= $form->field($model, 'title')->textInput(['placeholder' => 'Message Title here']) ?>
    
    <?= $form->field($model, 'message')->widget(TinyMce::className(), [
    'options' => ['rows' => 6],
    'language' => 'en',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    ]
]);?>

    <div class="form-group">
        <?= Html::submitButton('Send Mail', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
