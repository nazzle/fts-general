<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\IncomingFilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'FTS Apps - Implementers Portal';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoming-files-index" >
    
    <?php
       /*
        * Notification queries;
        */
    
        $ps_sms = (new yii\db\Query())
        ->from('owners_history')
        ->where(['messenger_time' =>  NULL ])
        ->count();
        

        $delayed = (new yii\db\Query())
         ->from('owners_history')
         ->where(['>', 'finish_time', 'deadline'])       
         ->count();
        
        $inbox = (new yii\db\Query())
        ->from('owners_history')
        ->where(['recipient_id' =>  Yii::$app->user->identity->id ])
        ->andWhere(['recipient_time' => null])        
        ->count();
        
        
        $sms = (new yii\db\Query())
        ->from('owners_mailbox')
        ->where(['recipient_id' =>  Yii::$app->user->identity->id ])
        ->andWhere(['status' => 6])        
        ->count();
        
        $ccfiles = (new yii\db\Query())
        ->from('owners_ccfiles')
        ->where(['recipient_id' =>  Yii::$app->user->identity->id ])
        ->andWhere(['status' => 6])        
        ->count();
    
         $mails = $sms + $ccfiles;
    ?> 

    <h1><?php echo 'FTS Apps - Implementers Portal'; ?></h1>

      <div class="box" onload="refreshPage()">
                <div class="box-header">
                  <h3 class="box-title">Applications Dashboard</h3>
                </div>
                <div class="box-body">
                    <p>Click on the respective <code><b>App icon</b></code> to perform task:</p>
                    <a class="btn btn-app" href="<?= Url::to(['owners-dashboard/index'])?>" style="background: linear-gradient(#ffd7d7, #c8d7dc);">
                    <i class="fa fa-list-alt"></i> Dashboard
                  </a>                
                  <a class="btn btn-app" href="<?= Url::to(['owners-history/inbox'])?>" style="background: linear-gradient(#ffd7d7, #c8d7dc);">
                    <?= $inbox > 0? '<span class="badge bg-green">'. $inbox.'</span>' : ''; ?>                                 
                    <i class="fa fa-inbox"></i> Your Files
                  </a>
                  <a class="btn btn-app" href="<?= Url::to(['owners-documents/index'])?>" style="background: linear-gradient(#ffd7d7, #c8d7dc);">
                    <i class="fa fa-file-o"></i> Other Documents
                  </a>
                   <a class="btn btn-app" href="<?= Url::to(['owners-history/index'])?>" style="background: linear-gradient(#ffd7d7, #c8d7dc);">
                    <i class="fa fa-map-signs"></i> Movement History
                  </a> 
                  <a class="btn btn-app" href="<?= Url::to(['owners-history/messengerbox'])?>" style="background: linear-gradient(#ffd7d7, #c8d7dc);">
                    <?= $ps_sms > 0? '<span class="badge bg-yellow">'. $ps_sms.'</span>' : ''; ?> 
                    <i class="fa fa-exchange"></i> Messenger Box
                  </a>
                  <a class="btn btn-app" href="<?= Url::to(['owners-history/delayedfiles'])?>" style="background: linear-gradient(#ffd7d7, #c8d7dc);">
                    <?= $delayed > 0? '<span class="badge bg-red">'. $delayed.'</span>' : ''; ?>
                    <i class="fa fa-archive"></i> Delayed files
                  </a>
                    <a class="btn btn-app" href="<?= Url::to(['owners-mailbox/ccfiles'])?>" style="background: linear-gradient(#ffd7d7, #c8d7dc);">
                        <?= $mails > 0? '<span class="badge bg-black">'. $mails.'</span>' : ''; ?>
                    <i class="fa fa-envelope"></i> Cc: Files & SMS
                  </a>
                  <a class="btn btn-app" href="<?= Url::to(['owners-history/documentation'])?>" style="background: linear-gradient(#ffd7d7, #c8d7dc);">
                    <i class="fa fa-folder-open-o"></i> Documentation
                  </a>
                  <a class="btn btn-app" href="<?= Url::to(['owners-history/profile'])?>" style="background: linear-gradient(#ffd7d7, #c8d7dc);">
                    <i class="fa fa-user"></i> Your Profile
                  </a>
                  <a class="btn btn-app" style="background: linear-gradient(#ffd7d7, #c8d7dc);">
                    <i class="fa fa-line-chart"></i> Reports
                  </a>
                    
                </div><!-- /.box-body -->
              </div><!-- /.box -->

   
</div>

