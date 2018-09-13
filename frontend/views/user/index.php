<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <p align="right">
        <?= Html::button('Create New User', ['value' => Url::to('index.php?r=user/create'), 'class' => 'btn btn-success', 'id' =>'modalButton']) ?>        
        <?= Html::a('Authenticated User', ['/site/signup'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Assign Position', ['/site/signup'], ['class' => 'btn btn-info']) ?>
    </p> 
    
     <?php
        Modal::begin([
                'header' => '<h4> Create new user. </h4>',
                'id' => 'modal',
                'size' => 'modal-lg',
                'options'=> [
                    'data-backdrop'=>'static',
                    //'data-keyboard'=>'false',
                ],            
               ]);
               echo "<div id='modalContent'></div>";
               
           Modal::end();    
    ?>     
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
             'email:email',
            // 'status',
            // 'created_at',
            // 'updated_at',
             'privileges',
             'type',

            ['class' => 'yii\grid\ActionColumn',
                'header' =>'Action',
                'template' => '{update}',
                ],
        ],
    ]); ?>
</div>
