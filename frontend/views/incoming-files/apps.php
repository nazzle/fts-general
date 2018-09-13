<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\IncomingFilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'FTS Apps - Facilitators Portal';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoming-files-index" >
    
    <?php
       /*
        * Notification queries;
        */
    
        $ps_sms = (new yii\db\Query())
        ->from('incoming_files')
        ->where(['messenger_time' =>  NULL ])
        ->count();
        

        $delayed = (new yii\db\Query())
        ->from('incoming_files')
        ->where(['>', 'finish_time', 'deadline'])       
        ->count();
        
        $inbox = (new yii\db\Query())
        ->from('incoming_files')
        ->where(['recipient_id' =>  Yii::$app->user->identity->id ])
        ->andWhere(['recipient_time' => null])        
        ->count();
        
        $documents = (new yii\db\Query())
        ->from('documents_tracking')
        ->where(['recipient_id' =>  Yii::$app->user->identity->id ])
        ->andWhere(['recipient_time' => null])        
        ->count();
        
        $pendingfiles = (new yii\db\Query())
        ->from('files')
        ->where(['status' => 4])        
        ->count();
        
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

    <h1><?php echo 'FTS Apps - Facilitators Portal'; ?></h1>

      <div class="box" onload="refreshPage()">
                <div class="box-header">
                  <h3 class="box-title">Applications Dashboard</h3>
                </div>
                <div class="box-body">
                    <p>Click on the respective <code><b>App icon</b></code> to perform task:</p>
                    <a class="btn btn-app" href="<?= Url::to(['dashboard/index'])?>" style="background: linear-gradient(lightblue, lightcyan);">
                    <i class="fa fa-list-alt"></i> Dashboard
                  </a>                
                  <a class="btn btn-app" href="<?= Url::to(['incoming-files/inbox'])?>" style="background: linear-gradient(lightblue, lightcyan);">
                    <?= $inbox > 0? '<span class="badge bg-green">'. $inbox.'</span>' : ''; ?>                                 
                    <i class="fa fa-inbox"></i> Your Files
                  </a>
                  <a class="btn btn-app" href="<?= Url::to(['documents-tracking/index'])?>" style="background: linear-gradient(lightblue, lightcyan);">
                   <?= $documents > 0? '<span class="badge bg-green">'. $documents.'</span>' : ''; ?> 
                    <i class="fa fa-file-o"></i> Your Documents
                  </a>
                   <a class="btn btn-app" href="<?= Url::to(['incoming-files/index'])?>" style="background: linear-gradient(lightblue, lightcyan);">
                    <i class="fa fa-map-signs"></i> Movement History
                  </a> 
                  <a class="btn btn-app" href="<?= Url::to(['incoming-files/messengerbox'])?>" style="background: linear-gradient(lightblue, lightcyan);">
                    <?= $ps_sms > 0? '<span class="badge bg-yellow">'. $ps_sms.'</span>' : ''; ?> 
                    <i class="fa fa-exchange"></i> Messenger Box
                  </a>
                  <a class="btn btn-app" href="<?= Url::to(['incoming-files/delayedfiles'])?>" style="background: linear-gradient(lightblue, lightcyan);">
                    <?= $delayed > 0? '<span class="badge bg-red">'. $delayed.'</span>' : ''; ?>
                    <i class="fa fa-archive"></i> Delayed files
                  </a>
                  <a class="btn btn-app" href="<?= Url::to(['dashboard/registry'])?>" style="background: linear-gradient(lightblue, lightcyan);"> 
                    <i class="fa fa-building"></i> Registry
                  </a>
                  <a class="btn btn-app" href="<?= Url::to(['user/index'])?>" style="background: linear-gradient(lightblue, lightcyan);">
                    <i class="fa fa-users"></i> Users App
                  </a>
                  <a class="btn btn-app" href="<?= Url::to(['files/index'])?>" style="background: linear-gradient(lightblue, lightcyan);">
                       <?= $pendingfiles > 0? '<span class="badge bg-blue">'. $pendingfiles.'</span>' : ''; ?>
                    <i class="fa fa-folder-open"></i> Files App
                  </a>
                    <a class="btn btn-app" href="<?= Url::to(['mailbox/ccfiles'])?>" style="background: linear-gradient(lightblue, lightcyan);">
                        <?= $mails > 0? '<span class="badge bg-black">'. $mails.'</span>' : ''; ?>
                    <i class="fa fa-envelope"></i> Cc: Files & SMS
                  </a>
                  <a class="btn btn-app" href="<?= Url::to(['incoming-files/documentation'])?>" style="background: linear-gradient(lightblue, lightcyan);">
                    <i class="fa fa-folder-open-o"></i> Documentation
                  </a>
                  <a class="btn btn-app" href="<?= Url::to(['incoming-files/profile'])?>" style="background: linear-gradient(lightblue, lightcyan);">
                    <i class="fa fa-user"></i> Your Profile
                  </a>
                  <a class="btn btn-app" href="<?= Url::to(['incoming-files/reports'])?>" style="background: linear-gradient(lightblue, lightcyan);">
                    <i class="fa fa-line-chart"></i> Reports
                  </a>
                    
                </div><!-- /.box-body -->
              </div><!-- /.box -->

   
</div>

