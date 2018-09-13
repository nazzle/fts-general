 <?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        
    ],
    
    'modules' => [
         'noty' => [
             'class' => 'lo\modules\noty\Module',
        ],
    ],
    
];
