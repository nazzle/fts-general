<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\MailboxSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cc: Files & SMS';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mailbox-index" >
    
    <!-- Content Wrapper. Contains page content -->
    
    <!-- Notifications counter queris -->
    <?php
    $sms = (new yii\db\Query())
        ->from('mailbox')
        ->where(['recipient_id' =>  Yii::$app->user->identity->id ])
        ->andWhere(['status' => 6])        
        ->count();
        
        $ccfiles = (new yii\db\Query())
        ->from('copied_files')
        ->where(['recipient_id' =>  Yii::$app->user->identity->id ])
        ->andWhere(['status' => 6])        
        ->count();
    
         $mails = $sms + $ccfiles;
    
    ?>

        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Mailbox
            <small> <?= $mails ?> unread notifications</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?= Url::to(['incoming-files/apps'])?>"><i class="fa fa-dashboard"></i> Apps</a></li>
            <li class="active">Cc: Files & SMS</li>
          </ol>
        </section>

         <!-- Main content -->
        <section class="content">
          <div class="row">
              
            <div class="col-md-3">
              <a href="<?= Url::to(['mailbox/create'])?>" class="btn btn-primary btn-block margin-bottom">Compose SMS</a>
              <div class="box box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title">Directories</h3>
                  <div class="box-tools">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <li><a href="<?= Url::to(['mailbox/ccfiles'])?>"><i class="fa fa-file-text-o"></i> Cc: Files <?= $ccfiles > 0? '<span class="label label-primary pull-right">'. $ccfiles.'</span>' : ''; ?></a></li>
                    <li class="active"><a href="<?= Url::to(['mailbox/index'])?>"><i class="fa fa-inbox"></i> Received SMS <?= $sms > 0? '<span class="label label-primary pull-right">'. $sms.'</span>' : ''; ?> </a></li>
                    <li><a href="<?= Url::to(['mailbox/sentmails'])?>"><i class="fa fa-envelope-o"></i> Sent SMS</a></li>
                  </ul>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
            </div><!-- /.col -->  
            <div class="col-md-9">
              <div class="box box-primary">
               <div class="box-header with-border">
                  <h3 class="box-title">Received SMS</h3>
                  <div class="box-tools pull-right">
                    <div class="has-feedback">
                      <input type="text" class="form-control input-sm" placeholder="Search Mail">
                      <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header --> 
                
                <div class="box-body no-padding">
                    <div class="table-responsive mailbox-messages">
                    <table class="table table-hover table-striped">
                      <tbody>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
                            if($model->status == 7){
                                return [
                                    'class' => 'success',
                                    'data-id' => $model->id
                                    ];
                            }else {
                               return [
                                   'class' => 'danger',
                                   'data-id' => $model->id
                                   ]; 
                           }
       },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
             'attribute' => 'sender',
              'value' => 'from.username'
            ],          
            'title', 
            'date',
            'time',
            [
                'attribute' => 'status',
                'value' => 'fileStatus.status'
            ],

        ],
    ]); ?>
        
      <?php
$this->registerJs("

    $('td').click(function (e) {
        var id = $(this).closest('tr').data('id');
        if(e.target == this)
            location.href = '" . Url::to(['mailbox/viewmailbox']) . "&id=' + id;
    });

"); ?>                    
    
             </tbody>
             </table>    
            </div><!-- /.mail-box-messages -->
          </div>
         </div><!-- /. box -->
         </div><!-- /.col -->
          </div>
        </section>
</div>
