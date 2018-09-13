<?php

namespace backend\controllers;

use Yii;
use backend\models\OwnersHistory;
use backend\models\OwnersHistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

/**
 * IncomingFilesController implements the CRUD actions for IncomingFiles model.
 */
class OwnersHistoryController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                
                'class' => AccessControl::classname(),
                'only' => ['index','create', 'update', 'index', 'delete', 'view','apps',
                            'inbox','Sentfiles','View','Update1','Update2','Update3','Messenger',
                            'Messengerbox','Recipient','Delete'],
                'rules' => [
                    [
                    
                     'allow' => true,
                     'roles' => ['@']
                    ],                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all IncomingFiles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OwnersHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
        'attributes' => [
            'incId' => [
                'asc' => ['incId' => SORT_ASC],
                'desc' => ['incId' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'date' => [
                'asc' => ['date' => SORT_ASC],
                'desc' => ['date' => SORT_DESC],
                'default' => SORT_ASC,
            ],
        ],
        'defaultOrder' => [
            'incId' => SORT_DESC
        ]
    ]);
        
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,          
        ]);
    }
    
    
    
    /*
     * App thumbnails controller
     * 
     */
    
    public function actionApps()
    {
       
        
        return $this->render('apps');
    }
    
    /*
     * Mailbox controller
     * 
     */
    
    public function actionMailbox()
    {
       
        return $this->render('mailbox');
    }
    
    /*
     * Documentation controller
     * 
     */
    
    public function actionDocumentation()
    {
       
        return $this->render('documentation');
    }
    
    /*
     * Profile controller
     * 
     */
    
    public function actionProfile()
    {
       
        return $this->render('profile');
    }

    /**
     * Lists all IncomingFiles models that are sent to the logged in user.
     * @return mixed
     */
    public function actionInbox()
    {
        $searchModel = new OwnersHistorySearch();
        $dataProvider = new ActiveDataProvider([
        'query' => OwnersHistory::find()->
                  andWhere(['forwarded_to' =>  Yii::$app->user->identity->id ])
                ->andWhere(['recipient_time' => null])
                ]);
        
        $dataProvider->pagination = ['pageSize' => 5];
        $dataProvider->setSort([
        'attributes' => [
            'incId' => [
                'asc' => ['incId' => SORT_ASC],
                'desc' => ['incId' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'date' => [
                'asc' => ['date' => SORT_ASC],
                'desc' => ['date' => SORT_DESC],
                'default' => SORT_ASC,
            ],
        ],
        'defaultOrder' => [
            'incId' => SORT_DESC
        ]
    ]);

        return $this->render('inbox', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
     /**
     * Lists all IncomingFiles models.
     * @return mixed
     */
 
    
    public function actionMovementhistory($id)
    {
        $searchModel = new OwnersHistorySearch();
        $dataProvider = new ActiveDataProvider([
        'query' => OwnersHistory::find()->
                    Where(['file_id' => $id ])
                ]);
        $dataProvider->setSort([
        'attributes' => [
            'incId' => [
                'asc' => ['incId' => SORT_ASC],
                'desc' => ['incId' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'date' => [
                'asc' => ['date' => SORT_ASC],
                'desc' => ['date' => SORT_DESC],
                'default' => SORT_ASC,
            ],
        ],
        'defaultOrder' => [
            'incId' => SORT_DESC
        ]
    ]);

        return $this->render('movementhistory', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    public function actionDelayedfiles()
    {

            $searchModel = new OwnersHistorySearch();
            $dataProvider = new ActiveDataProvider([
            'query' => OwnersHistory::find()->
                     where(['>', 'finish_time', 'deadline'])
                    ]);

            $dataProvider->pagination = ['pageSize' => 5];
            $dataProvider->setSort([
            'attributes' => [
                'incId' => [
                    'asc' => ['incId' => SORT_ASC],
                    'desc' => ['incId' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'date' => [
                    'asc' => ['date' => SORT_ASC],
                    'desc' => ['date' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
            ],
            'defaultOrder' => [
                'incId' => SORT_DESC
            ]
        ]);

            return $this->render('delayedfiles', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);        
    }
    
    
     /**
     * Lists all IncomingFiles models that logged in user sent to other users.
     * @return mixed
     */
    public function actionSentfiles()
    {
        $searchModel = new OwnersHistorySearch();
        $dataProvider = new ActiveDataProvider([
        'query' => OwnersHistory::find()->
                  where(['sender' =>  Yii::$app->user->identity->id ]),
                ]);
        $dataProvider->pagination = ['pageSize' => 5];
        $dataProvider->setSort([
        'attributes' => [
            'incId' => [
                'asc' => ['incId' => SORT_ASC],
                'desc' => ['incId' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'date' => [
                'asc' => ['date' => SORT_ASC],
                'desc' => ['date' => SORT_DESC],
                'default' => SORT_ASC,
            ],
        ],
        'defaultOrder' => [
            'incId' => SORT_DESC
        ]
    ]);

        return $this->render('sentfiles', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single IncomingFiles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
        
    }
    

    /**
     * Updates an existing IncomingFiles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
   
            return $this->redirect(['view', 'id' => $model->incId]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    
   /**
    * 
    * @param type $id
    * @return type
    * This update the file messenger time by capturing the time it was clicked.
    */
    public function actionMessenger($id)
    {
        if(Yii::$app->user->can('messenger'))
        {
                $model = $this->findModel($id);
                date_default_timezone_set("Africa/Dar_es_Salaam");
                $messengerTime= date('Y-m-d H:i:s');
                 Yii::$app->db->createCommand()
                    ->update('owners_history', 
                            ['messenger_time' => $messengerTime,],['incId' =>$id]
                    )->execute();
                 
                 Yii::$app->db->createCommand()
                    ->update('owners_dashboard', 
                            ['messenger_time' => $messengerTime,],['file_id' =>$model->file_id]
                    )->execute();
                return $this->redirect(['messengerbox']); 
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }        
    }
    
    
    /*
     * This is to display files that awaits messenger attendance.
     */
    public function actionMessengerbox()
    {
        if(Yii::$app->user->can('messenger') || Yii::$app->user->can('HEAD'))
        {
      $searchModel = new OwnersHistorySearch();
        $dataProvider = new ActiveDataProvider([
        'query' => OwnersHistory::find()
                ->andWhere(['messenger_time' => null])
                ]);
        
        $dataProvider->pagination = ['pageSize' => 10];
        $dataProvider->setSort([
        'attributes' => [
            'incId' => [
                'asc' => ['incId' => SORT_ASC],
                'desc' => ['incId' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'date' => [
                'asc' => ['date' => SORT_ASC],
                'desc' => ['date' => SORT_DESC],
                'default' => SORT_ASC,
            ],
        ],
        'defaultOrder' => [
            'incId' => SORT_DESC
        ]
    ]);

        return $this->render('messengerbox', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); 
        }else {
            throw new ForbiddenHttpException(Yii::t('yii', 'This is for users with Messenger privilege. Contact Admin'));

        }    
    }

    
    /**
    * 
    * @param type $id
    * @return type
    * This update the file messenger time by capturing the time it was clicked.
    */
    public function actionRecipient($id)
    {
        $model = $this->findModel($id);
        if(Yii::$app->user->id == $model->recipient_id)
        {
                
                date_default_timezone_set("Africa/Dar_es_Salaam");
                $recipientTime= date('Y-m-d H:i:s');
                 Yii::$app->db->createCommand()
                    ->update('owners_history', 
                            ['recipient_time' => $recipientTime,],['incId' =>$id]
                    )->execute();
                 
                 Yii::$app->db->createCommand()
                    ->update('owners_dashboard', 
                            ['recipient_time' => $recipientTime,],['file_id' =>$model->file_id]
                    )->execute();
                return $this->redirect(['inbox']);
        } else {
             throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }           
    } 
   
    
     /**
    * 
    * @param type $id
    * @return type
    * This update the file messenger time by capturing the time it was clicked.
    */
    public function actionReceivechecked($id)
    {
        $model = $this->findModel($id);
        
        print_r($id);
        die();
        if(Yii::$app->user->id == $model->recipient_id)
        {
                
                date_default_timezone_set("Africa/Dar_es_Salaam");
                $recipientTime= date('Y-m-d H:i:s');
                 Yii::$app->db->createCommand()
                    ->update('owners_history', 
                            ['recipient_time' => $recipientTime,],['incId' =>$id]
                    )->execute();
                return $this->redirect(['inbox']);
        } else {
             throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }        
    } 
    
     /**
    * 
    * @param type $id
    * @return type
    * This update the file messenger time by capturing the time it was clicked.
    */
    public function actionReceiveall()
    {
        
    date_default_timezone_set("Africa/Dar_es_Salaam");
                $recipientTime= date('Y-m-d H:i:s');
                 Yii::$app->db->createCommand()
                    ->update('owners_history',
                            ['recipient_time' => $recipientTime],
                            ['recipient_id' => Yii::$app->user->id,
                                'recipient_time' => NULL]
                    )->execute();
                
                Yii::$app->db->createCommand()
                    ->update('owners_dashboard', 
                            ['recipient_time' => $recipientTime],
                            ['recipient_id' => Yii::$app->user->id,
                                'recipient_time' => NULL]
                    )->execute(); 
                return $this->redirect(['owners-dashboard/index']);
        
    } 
    

    /**
     * Deletes an existing Owners history model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
         date_default_timezone_set("Africa/Dar_es_Salaam");
        $thisTime = date("h:i:sa");
        $todayDate = date('y-m-d');
        Yii::$app->db->createCommand()
                    ->update('owners_dashboard', 
                            [
                                'date'=> $todayDate ,
                                'from_who'=> NULL,
                                'sender'=> NULL,
                                'from_who' => NULL,
                                'forwarded_to'=> NULL,
                                'deadline'=> NULL,
                                'action' => NULL,
                                'action_number' => NULL,
                                'time'=> $thisTime,
                                'courier' => NULL,
                                'received_by' => NULL,
                                'delivered_by' => NULL,
                                'messenger_time' => NULL,
                                'recipient_time' => NULL,
                                'finish_time' => NULL,
                                'file_status' => 2,  
                                ],['file_id' =>$model->file_id]
                    )->execute();
        
        $this->findModel($id)->delete();

        return $this->redirect(['sentfiles']);
    }
    
    

    /**
     * Finds the IncomingFiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return IncomingFiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OwnersHistory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}


