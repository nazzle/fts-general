<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use kartik\widgets\Growl;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="<?= Yii::$app->params['commonPath']; ?>/favicon.ico" type="image/x-icon" />
</head>
<body>
<?php $this->beginBody()  ?>
    

<div class="wrap"  style="background: linear-gradient(#ffffff, #ffffff);">
    <?php
    $model = new frontend\models\IncomingFiles();
    NavBar::begin([
        'brandLabel' => 'FILE TRACKING SYSTEM',
        'brandUrl' => Url::toRoute(['/incoming-files/index']),
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Apps', 'url' => ['/incoming-files/apps']],
        ['label' => 'Dashboard', 'url' => ['/dashboard/index']],
        ['label' =>  'Your Files' , 'url' => ['/incoming-files/inbox']],
        ['label' => 'Sent Files', 'url' => ['/incoming-files/sentfiles']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    
    NavBar::end();
    ?>

    <div class="container">
        
        <?php
        
        $pendingfiles = (new yii\db\Query())
        ->from('files')
        ->where(['status' => 4])        
        ->count();
               
        
    if ($pendingfiles > 0 && Yii::$app->user->can('HEAD'))
    {
        echo Growl::widget([
            'type' => Growl::TYPE_INFO,
            'title' => '<h4>'.$pendingfiles .'&nbsp;Files needs your approval!'.'</h4>',
            'icon' => 'glyphicon glyphicon-ok-sign',
            'body' => 'New Files:  You have&nbsp'. $pendingfiles .'&nbspfiles to approve',
            'showSeparator' => true,
            'linkUrl' => 'index.php?r=files%2Findex',
            'delay' => 0,
            'pluginOptions' => [
                'delay' => 15000,
                'showProgressbar' => true,
                'placement' => [
                    'from' => 'top',
                    'align' => 'left',
                ]
            ]
        ]);
    }    
        
        
        
        $inbox = (new yii\db\Query())
        ->from('incoming_files')
        ->where(['recipient_id' =>  Yii::$app->user->identity->id ])
        ->andWhere(['recipient_time' => null])        
        ->count();
        
        
    if( $inbox > 0) {   
        echo Growl::widget([
            'type' => Growl::TYPE_SUCCESS,
            'title' => '<h4>'.'You have&nbsp;'. $inbox . '&nbsp;new Files!'.'</h4>',
            'icon' => 'glyphicon glyphicon-info-sign',
            'body' => 'Dear&nbsp;'. '<b>'.Yii::$app->user->identity->username.'</b>' .'&nbsp;' . $inbox .'&nbsp;files awaits your attendance in the inbox. Click inbox to see',
            'showSeparator' => true,
            'linkUrl' => 'index.php?r=incoming-files%2Finbox',
            'delay' => 1500,
            'pluginOptions' => [
                'delay' => 15000,
                'showProgressbar' => true,
                'placement' => [
                    'from' => 'top',
                    'align' => 'left',
                ]
            ]
        ]);
    }
        
//            echo Growl::widget([
//                'type' => Growl::TYPE_WARNING,
//                'title' => '<h4>'.'0 files on desk yesterday!'.'</h4>',
//                'icon' => 'glyphicon glyphicon-exclamation-sign',
//                'body' => '0 files were left on the desk yesterday.',
//                'showSeparator' => true,
//                'delay' => 3000,
//                'pluginOptions' => [
//                    'delay' => 15000,
//                    'showProgressbar' => true,
//                    'placement' => [
//                        'from' => 'top',
//                        'align' => 'center',
//                    ]
//                ]
//            ]);
            
            
//            $delayed = (new yii\db\Query())
//             ->from('incoming_files')
//             ->where(['>', 'deadline', 'finish_time'])       
//             ->count();
//            
//            $yesterday = date("Y-m-d")-3; 
//        if($delayed > 0 && $model->date <= $yesterday)
//        {
//            echo Growl::widget([
//                'type' => Growl::TYPE_DANGER,
//                'title' => '<h4>'.$delayed.'&nbsp DELAYED FILES!'.'</h4>',
//                'icon' => 'glyphicon glyphicon-remove-sign',
//                'body' => 'The total number of&nbsp'. $delayed .'&nbspfiles have crossed the deadline',
//                'showSeparator' => true,
//                'delay' => 4500,
//                'pluginOptions' => [
//                    'delay' => 15000,
//                    'showProgressbar' => true,
//                    'placement' => [
//                        'from' => 'bottom',
//                        'align' => 'right',
//                    ]
//                ]
//            ]);
//        }   
            
        date_default_timezone_set("Africa/Dar_es_Salaam");
        if ( date("h:i:sa") >= '09:00:00'  )
        {
            if ( date("h:i:sa") <= '09:06:00'  )
        {
            echo Growl::widget([
                'type' => Growl::TYPE_WARNING,
                'title' => '<h4>'.'NEW VERSION | (V 3) has been deployed.'.'</h4>',
                'icon' => 'glyphicon glyphicon-info-sign',
                'body' => ' NEW FEATURES: Multiple Recipient, Auto-view page on gridview, Delete entry via sent files. ',
                'showSeparator' => false,
                'linkUrl' => 'index.php?r=incoming-files%2Fapps',
                'delay' => 0,
                'pluginOptions' => [
                    'delay' => 30000,
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'bottom',
                        'align' => 'right',
                    ],
                ]
            ]);
        }
        }
         
        ?>

        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <strong>JDU</strong> <?= date('Y') ?></p>

        <p class="pull-right"> <strong>Version 3 |</strong> <a href="http://www.judiciary.go.tz/">Judiciary Website</a></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
