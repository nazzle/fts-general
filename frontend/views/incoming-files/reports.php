<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\IncomingFilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'FTS Apps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="incoming-files-index" >
    
         <!-- Content Wrapper. Contains page content -->

        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Reports
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?= Url::to(['incoming-files/apps'])?>"><i class="fa fa-dashboard"></i> Apps</a></li>
            <li class="active">Reports</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="row">
           
            <div class="col-md-9">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#activity" data-toggle="tab">General Reports</a></li>
                  <li><a href="#timeline" data-toggle="tab">Custom Reports</a></li>
                  <li><a href="#settings" data-toggle="tab">Timely Reports</a></li>
                </ul>
                <div class="tab-content">
                    
                    <!-- /.timeline-label 
                      Here is
                        where general
                            reports starts.
                    -->
                    
                  <div class="active tab-pane" id="activity">
                    <!-- The timeline -->
                    <ul class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <li class="time-label">
                        <span class="bg-green">
                          <?php echo date('d-m-Y'); ?>
                        </span>
                      </li>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <li>
                        <i class="fa fa-folder-open-o bg-blue"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> General</span>
                          <h3 class="timeline-header"><a href="#">All registered system files</a> that are in use.</h3>

                          <div class="timeline-footer" align="right">
                            <a class="btn btn-primary btn-xs">Priview</a>
                            <a class="btn btn-success btn-xs">Download</a>
                          </div>
                        </div>
                      </li>
                      <li>
                        <i class="fa fa-folder-open-o bg-blue"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> General</span>
                          <h3 class="timeline-header"><a href="#">All registered system users</a> fts users.</h3>

                          <div class="timeline-footer" align="right">
                            <a class="btn btn-primary btn-xs">Priview</a>
                            <a class="btn btn-success btn-xs">Download</a>
                          </div>
                        </div>
                      </li>
                      <!-- END timeline item -->              
                      <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                      </li>
                    </ul>
                  </div><!-- /.tab-pane -->
                  
                  
                  <!-- /.timeline-label 
                      Here is
                        where custom
                            reports starts.
                    -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <ul class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <li class="time-label">
                        <span class="bg-green">
                          <?php echo date('d-m-Y'); ?>
                        </span>
                      </li>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <li>
                        <i class="fa fa-folder-open-o bg-blue"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> custom</span>
                          <h3 class="timeline-header"><a href="#">Files sent by a user</a> in a specific time.</h3>

                          <div class="timeline-footer" align="right">
                            <a class="btn btn-primary btn-xs">Priview</a>
                            <a class="btn btn-success btn-xs">Download</a>
                          </div>
                        </div>
                      </li>
                      <li>
                        <i class="fa fa-folder-open-o bg-blue"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> custom</span>
                          <h3 class="timeline-header"><a href="#">Delayed Files</a> Files that crossed their finished lines.</h3>

                          <div class="timeline-footer" align="right">
                            <a class="btn btn-primary btn-xs">Priview</a>
                            <a class="btn btn-success btn-xs">Download</a>
                          </div>
                        </div>
                      </li>
                      <!-- END timeline item -->              
                      <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                      </li>
                    </ul>
                  </div><!-- /.tab-pane -->
                  
                  
                  
                  <!-- /.timeline-label 
                      Here is
                        where timely
                            reports starts.
                    -->
                  <div class="tab-pane" id="settings">
                    <!-- The timeline -->
                    <ul class="timeline timeline-inverse">
                      <!-- timeline time label -->
                      <li class="time-label">
                        <span class="bg-green">
                          <?php echo date('d-m-Y'); ?>
                        </span>
                      </li>
                      <!-- /.timeline-label -->
                      <!-- timeline item -->
                      <li>
                        <i class="fa fa-folder-open-o bg-blue"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="fa fa-clock-o"></i> custom</span>
                          <h3 class="timeline-header"><a href="#">Files sent by a user</a> in a specific time.</h3>

                          <div class="timeline-footer" align="right">
                            <a class="btn btn-primary btn-xs">Priview</a>
                            <a class="btn btn-success btn-xs">Download</a>
                          </div>
                        </div>
                      </li>
                      <!-- END timeline item -->              
                      <li>
                        <i class="fa fa-clock-o bg-gray"></i>
                      </li>
                    </ul>
                  </div><!-- /.tab-pane -->
                  
                  
                  
                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->

   
</div>

