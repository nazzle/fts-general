<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\DocumentsTracking */

$this->title = 'Create Documents Tracking';
$this->params['breadcrumbs'][] = ['label' => 'Documents Trackings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="documents-tracking-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
