<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FileStatus */

$this->title = 'Create File Status';
$this->params['breadcrumbs'][] = ['label' => 'File Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
