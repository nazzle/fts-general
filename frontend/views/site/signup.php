<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'User Registration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h2>System user registration form.</h2>

    <p>Please fill out the following fields to create user:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>
            
                <?= $form->field($model, 'privileges')->dropDownList([ 'HIGH' => 'HIGH', 'MEDIUM' => 'MEDIUM','LOW'=>'LOW','ADMIN'=>'ADMIN', 'NONE'=>'NONE' ], ['prompt' => 'Select Privilege']) ?>
            
                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
