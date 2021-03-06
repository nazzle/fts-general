<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */

$this->title = 'FTS Home';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>JUDICIARY <font color="blue"> File Tracking System</font></h1>

        <p class="lead">Welcome to FTS, to use the system login and fill the crediatials given by adminstrator.</p>

        <p>
        <?= Html::button('Login to FTS', ['value' => Url::to('index.php?r=site/login'), 'class' => 'btn btn-primary', 'id' =>'modalButton']) ?>
        </p>
         <?php
        Modal::begin([
                'header' => '<h4> Login Form </h4>',
                'id' => 'modal',
                'size' => 'modal-lg', 
                'options'=> [
                    //'data-backdrop'=>'static',
                    //'data-keyboard'=>'false',
                ],
               ]);
               echo "<div id='modalContent'></div>";
               
           Modal::end();    
    ?>      
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>INCOMING FILES</h2>

                <p>This module is intended to track all files coming from external <br> (Apart from the Unit).</p>

                <p><a class="btn btn-default" href="#">FTS Incoming &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>INTERNAL FILES</h2>

                <p>This module tracks the movements of files within the unit.<br> (i.e. from one staff to another for correspondence)</p>

                <p><a class="btn btn-default" href="#">FTS Internal &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>OUTGOING FILES</h2>

                <p>This module is when a file is being sent outside the unit, <br> this captures who sent the file and who is the designated destination.</p>

                <p><a class="btn btn-default" href="#">FTS Outgoing &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
