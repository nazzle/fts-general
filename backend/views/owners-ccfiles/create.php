<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\CopiedFiles */

$this->title = 'Create Copied Files';
$this->params['breadcrumbs'][] = ['label' => 'Copied Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="copied-files-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
