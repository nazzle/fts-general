<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\IncomingFilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'FTS Apps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoming-files-index" >
    
         <!-- Content Wrapper. Contains page content -->

        <!-- Content Header (Page header) -->
        
        <?php
             /*
             * Counter queries;
             */
          
          $sent = (new yii\db\Query())
            ->from('owners_history')
            ->where(['sender' => Yii::$app->user->identity->id ])
            ->count();
          
          $received = (new yii\db\Query())
            ->from('owners_history')
            ->where(['recipient_id' => Yii::$app->user->identity->id ])
            ->count();
        
        ?>
        
        <section class="content-header">
          <h1>
            User Profile
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?= Url::to(['incoming-files/apps'])?>"><i class="fa fa-dashboard"></i> Apps</a></li>
            <li class="active">User profile</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" src="./img/user.jpg" alt="User profile">
                  <h3 class="profile-username text-center"> <?php echo Yii::$app->user->identity->username ?> </h3>
                  <p class="text-muted text-center"> Username: <?php echo Yii::$app->user->identity->username ?> </p>

                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Total files you sent</b> <a class="pull-right"> <?= $sent ?> </a>
                    </li>
                    <li class="list-group-item">
                      <b>Total files you received</b> <a class="pull-right"> <?= $received ?> </a>
                    </li>
                    <li class="list-group-item">
                      <b>Files you delayed</b> <a class="pull-right">13,287</a>
                    </li>
                  </ul>

                  <a href="#" class="btn btn-primary btn-block"><b>Print performance report</b></a>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- About Me Box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Hints</h3>
                </div><!-- /.box-header -->
                <div class="box-body">   
                  <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                  <p class="text-muted">Judiciary, Dar es salaam</p>

                  <hr>

                  <strong><i class="fa fa-user margin-r-5"></i>User Designated Post </strong>
                  <p>
                    <span class="label label-warning">Judiciary Staff</span>
                  </p>

                  <hr>

                  <strong><i class="fa fa-thumb-tack margin-r-5"></i> Organization Motto</strong>
                  <p>Accountability, Discipline of action, Team work.</p>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-9">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
                  <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
                  <li><a href="#settings" data-toggle="tab">Change Password</a></li>
                </ul>
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <div class="post">

                      <div class="col-md-16">
                            <!-- Widget: user widget style 1 -->
                            <div class="box box-widget widget-user-2">
                              <!-- Add the bg color to the header using any of the bg-* classes -->
                              <div class="widget-user-header bg-yellow">
                                <div class="widget-user-image">
                                  <img class="img-circle" src="./img/user.jpg" alt="User Avatar">
                                </div><!-- /.widget-user-image -->
                                <h3 class="widget-user-username"><?= Yii::$app->user->identity->username ?></h3>
                                <h5 class="widget-user-desc">Username</h5>
                              </div>
                              <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                  <li><a href="#"> <?= Yii::$app->user->identity->privileges ?> <span class="pull-right badge bg-blue">Privileges</span></a></li>
                                  <li><a href="#"><?= Yii::$app->user->identity->type ?> <span class="pull-right badge bg-aqua">User type</span></a></li>
                                  <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>
                                  <li><a href="#">Followers <span class="pull-right badge bg-red">842</span></a></li>
                                </ul>
                              </div>
                            </div><!-- /.widget-user -->
                        </div><!-- /.col -->
                    </div><!-- /.post -->
                    
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <ul class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <li class="time-label">
                        <span class="bg-red">
                          <?php echo date('d-m-Y'); ?>
                        </span>
                      </li>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <li>
                        <i class="fa fa-envelope bg-blue"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
                          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                          <div class="timeline-body">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                            quora plaxo ideeli hulu weebly balihoo...
                          </div>
                          <div class="timeline-footer">
                            <a class="btn btn-primary btn-xs">Read more</a>
                            <a class="btn btn-danger btn-xs">Delete</a>
                          </div>
                        </div>
                      </li>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <li>
                        <i class="fa fa-user bg-aqua"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>
                          <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
                        </div>
                      </li>
                      <!-- END timeline item -->
                      <!-- timeline item -->
                      <li>
                        <i class="fa fa-comments bg-yellow"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>
                          <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                          <div class="timeline-body">
                            Take me to your leader!
                            Switzerland is small and neutral!
                            We are more like Germany, ambitious and misunderstood!
                          </div>
                          <div class="timeline-footer">
                            <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                          </div>
                        </div>
                      </li>
                      <!-- END timeline item -->
                      <!-- timeline time label -->
                      <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                      </li>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <li>
                        <i class="fa fa-camera bg-purple"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>
                          <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                          <div class="timeline-body">
                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                          </div>
                        </div>
                      </li>
                      <!-- END timeline item -->
                      <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                      </li>
                    </ul>
                  </div><!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Old Password</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputName" placeholder="Enter old password">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">New Password</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="Enter new password">
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-success">Change</button>
                        </div>
                      </div>
                    </form>
                  </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->

   
</div>

