<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use backend\assets\AppAsset;
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
    $model = new backend\models\OwnersHistory();
    NavBar::begin([
        'brandLabel' => 'FILE TRACKING SYSTEM',
        'brandUrl' => Url::toRoute(['/owners-history/index']),
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Apps', 'url' => ['/owners-history/apps']],
        ['label' => 'Dashboard', 'url' => ['/owners-dashboard/index']],
        ['label' =>  'Your Files' , 'url' => ['/owners-history/inbox']],
        ['label' => 'Sent Files', 'url' => ['/owners-history/sentfiles']],
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
        
     
        $inbox = (new yii\db\Query())
        ->from('owners_history')
        ->where(['forwarded_to' =>  Yii::$app->user->identity->id ])
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
