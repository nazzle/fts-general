<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Dashboard;
use frontend\models\DashboardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\IncomingUpdate;
use frontend\models\DocumentsTrackingSearch;
use frontend\models\InternalUpdate;
use frontend\models\OutgoingUpdate;
use yii\data\ActiveDataProvider;
use frontend\models\CopiedFiles;

/**
 * DashboardController implements the CRUD actions for Dashboard model.
 */
class DashboardController extends Controller
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
     * Lists all Dashboard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DashboardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 5];
        $dataProvider->setSort([
        'attributes' => [
            'date' => [
                'asc' => ['date' => SORT_ASC],
                'desc' => ['date' => SORT_DESC],
                'default' => SORT_ASC,
            ],
            
            'time' => [
                'asc' => ['id' => SORT_ASC],
                'desc' => ['id' => SORT_DESC],
                'default' => SORT_DESC
            ],
            
        ],
        'defaultOrder' => [
            'date' => SORT_DESC,
            'time' => SORT_DESC,
        ]
    ]);

       $docModel = new DocumentsTrackingSearch();
        $docProvider = $docModel->search(Yii::$app->request->queryParams);
        $docProvider->pagination = ['pageSize' => 4];
        $docProvider->setSort([
        'attributes' => [
            'docId' => [
                'asc' => ['docId' => SORT_ASC],
                'desc' => ['docId' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'date' => [
                'asc' => ['date' => SORT_ASC],
                'desc' => ['date' => SORT_DESC],
                'default' => SORT_ASC,
            ],
        ],
        'defaultOrder' => [
            'docId' => SORT_DESC
        ]
    ]);
 
   
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'docModel' => $docModel,
            'docProvider' => $docProvider,
            
        ]);
    }
    
    
      /*
     * Registry controller
     * 
     */
    
    public function actionRegistry()
    {
        $searchModel = new DashboardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
        'attributes' => [
            'id' => [
                'asc' => ['id' => SORT_ASC],
                'desc' => ['id' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'date' => [
                'asc' => ['date' => SORT_ASC],
                'desc' => ['date' => SORT_DESC],
                'default' => SORT_ASC,
            ],
        ],
        'defaultOrder' => [
            'id' => SORT_DESC
        ]
    ]);
          
        return $this->render('registry', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider  
        ]);
    }
    
    
    public function actionDetail($id, $advanced = false)
{
    $model = $this->findModel($id);

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->events,
    ]);

    return $this->renderAjax('_detail', [
        'dataProvider' => $dataProvider,
        'advanced' => $advanced,
        'id' => $id,
    ]);
}
    

    /**
     * Displays a single Dashboard model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dashboard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dashboard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Dashboard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    
     /**
     * Change an existing IncomingFiles status.
     * If update is successful, the browser will be redirected to the 'index' page and a new entry will be added in the database.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate1($id)
    {
        
        $model = $this->findModel($id);
        $incoming = new IncomingUpdate;
        
        $model->received_by = Yii::$app->user->id; 
         date_default_timezone_set("Africa/Dar_es_Salaam");
        $thisTime = date("h:i:sa");
        $todayDate = date('y-m-d');

        if ($model->load(Yii::$app->request->post()) && $incoming->load(Yii::$app->request->post()) ) {
            
            $user_ids = (new \yii\db\Query())
            ->select('user_id')
            ->distinct()
            ->from('positions')
            ->where(['id' => $incoming->forwarded_to])
            ->one();

            foreach ($user_ids as $user_id){}
    
            Yii::$app->db->createCommand()
            ->update('dashboard',[
                    'date'=> $todayDate,
                    'file_id' => $model->file_id,
                    'subject'=> $model->subject,
                    'from_who'=>$incoming->from_who,
                    'forwarded_to'=>$incoming->forwarded_to,
                    'delivered_by'=>$incoming->delivered_by,
                    'deadline' => NULL,
                    'messenger_time'=>NULL,
                    'recipient_time'=>NULL,
                    'courier' =>NULL,
                    'action' =>$incoming->action,
                    'action_number' =>$incoming->action_number,
                    'received_by' => $model->received_by,
                    'sender' => $model->received_by,
                    'recipient_id' =>$user_id,
                    'time'=>  $thisTime,
                    'file_status' => 1,
                            ],
                    ['id' =>$id]
                    )->execute();
            
            Yii::$app->db->createCommand()
            ->insert('incoming_files', [
                    'date'=> $todayDate ,
                    'file_id' => $model->file_id,
                    'subject'=> $model->subject,
                    'from_who'=>$incoming->from_who,
                    'forwarded_to'=>$incoming->forwarded_to,
                    'delivered_by'=>$incoming->delivered_by,
                    'action' =>$incoming->action,
                    'action_number' =>$incoming->action_number,
                    'received_by' => $model->received_by,
                    'sender' => $model->received_by,
                    'recipient_id' =>$user_id,
                    'time'=> $thisTime,
                    'file_status' => 1,
            ])->execute();
   
            return $this->redirect(['index']);
        } else {
            return $this->render('update1', [
                'model' => $model,
                'incoming' => $incoming,
            ]);
        }
    }
    
    
    public function actionUpdate2($id)
    {
        
        $model = $this->findModel($id);
        $internal = new InternalUpdate;
//        $ccfiles = [new CopiedFiles];
        $ccfiles = new CopiedFiles;
        
        $model->sender = Yii::$app->user->id; 
         date_default_timezone_set("Africa/Dar_es_Salaam");
        $thisTime = date("h:i:sa");
        $todayDate = date('y-m-d');
        $finishTime = date('Y-m-d H:i:s');
        if ($model->load(Yii::$app->request->post()) && $internal->load(Yii::$app->request->post()) && $ccfiles->load(Yii::$app->request->post()) ) {
        
       // if ($model->load(Yii::$app->request->post()) && $internal->load(Yii::$app->request->post()) && Model::loadMultiple($ccfiles, Yii::$app->request->post()) ) {    
           
            $user_ids = (new \yii\db\Query())
            ->select('user_id')
            ->distinct()
            ->from('positions')
            ->where(['id' => $internal->forwarded_to])
            ->one();

            foreach ($user_ids as $user_id){}
             
            Yii::$app->db->createCommand()
            ->update('dashboard',[
                    'date'=> $todayDate ,
                    'file_id' => $model->file_id,
                    'subject'=> $model->subject,
                    'from_who'=>NULL,
                    'sender'=> $model->sender,
                    'forwarded_to'=>$internal->forwarded_to,
                    'recipient_id' =>$user_id,
                    'deadline'=>$internal->deadline,
                    'action' =>$internal->action,
                    'action_number' =>$internal->action_number,
                    'messenger_time'=>NULL,
                    'recipient_time'=>NULL,
                    'courier' =>NULL,
                    'delivered_by' =>NULL,
                    'received_by' => NULL,
                    'time'=> $thisTime,
                    'file_status' => 2,
                            ],
                    ['id' =>$id]
                    )->execute();
            
            
            Yii::$app->db->createCommand()
            ->insert('incoming_files', [
                    'date'=> $todayDate ,
                    'file_id' => $model->file_id,
                    'subject'=> $model->subject,
                    'sender'=> $model->sender,
                    'forwarded_to'=>$internal->forwarded_to,
                    'recipient_id' =>$user_id,
                    'deadline'=>$internal->deadline,
                    'action' =>$internal->action,
                    'action_number' =>$internal->action_number,
                    'time'=> $thisTime,
                    'file_status' => 2,
            ])->execute();
            
            Yii::$app->db->createCommand()
                    ->update('dashboard', 
                            ['finish_time' => $finishTime],['id' =>$id]
                    )->execute();
            
   
            if ($ccfiles->forward_to != NULL) 
            { 
                 foreach ($ccfiles->forward_to as $value) 
                {
                     $cc_users = (new \yii\db\Query())
                    ->select('user_id')
                    ->distinct()
                    ->from('positions')
                    ->where(['id' => $value])
                    ->one();
                    foreach ($cc_users as $cc_user){
                    
                            Yii::$app->db->createCommand()
                            ->insert('copied_files', [
                                'sender'=> $model->sender ,
                                'forward_to'=>$value,
                                'recipient_id'=>$cc_user,
                                'title'=> $model->file_id,
                                'message'=>$internal->action,
                                'date'=> $todayDate,
                                'time'=> $thisTime,
                                'status' => 6,
                         ])->execute();
                    }
                }

            }
                                    
            
            return $this->redirect(['index']);
        } else {
            return $this->render('update2', [
                'model' => $model,
                'internal' => $internal,
                'ccfiles' => (empty($ccfiles)) ? [new CopiedFiles] : $ccfiles
            ]);
        }
    }
    
    


        public function actionUpdate3($id)
    {
        
        $model = $this->findModel($id);
        $outgoing = new OutgoingUpdate;
        
        $model->sender = Yii::$app->user->id; 
         date_default_timezone_set("Africa/Dar_es_Salaam");
        $thisTime = date("h:i:sa");
        $todayDate = date('y-m-d');

        if ($model->load(Yii::$app->request->post()) && $outgoing->load(Yii::$app->request->post()) ) {
            
            $user_ids = (new \yii\db\Query())
            ->select('user_id')
            ->distinct()
            ->from('positions')
            ->where(['id' => $outgoing->forwarded_to])
            ->one();
            foreach ($user_ids as $user_id){}
            
            Yii::$app->db->createCommand()
            ->update('dashboard',[
                    'date'=> $todayDate,
                    'file_id' => $model->file_id,
                    'subject'=> $model->subject,
                    'from_who'=>$outgoing->from_who,
                    'forwarded_to' => $outgoing->forwarded_to,
                    'recipient_id' =>$user_id,
                    'deadline' => NULL,
                    'messenger_time'=>NULL,
                    'recipient_time'=>NULL,
                    'delivered_by' =>NULL,
                    'received_by' => NULL,
                    'sender'=>$model->sender,
                    'action' =>$outgoing->action,
                    'action_number' =>$outgoing->action_number,
                    'courier' =>$outgoing->courier,
                    'time'=> $thisTime,
                    'file_status' => 3,
                            ],
                    ['id' =>$id]
                    )->execute();
            
            Yii::$app->db->createCommand()
            ->insert('incoming_files', [
                    'date'=> $todayDate,
                    'file_id' => $model->file_id,
                    'subject'=> $model->subject,
                    'from_who'=>$outgoing->from_who,
                    'forwarded_to' => $outgoing->forwarded_to,
                    'recipient_id' =>$user_id,
                    'sender'=>$model->sender,
                    'action' =>$outgoing->action,
                    'action_number' =>$outgoing->action_number,
                    'courier' =>$outgoing->courier,
                    'time'=> $thisTime,
                    'file_status' => 3,
            ])->execute();
   
            return $this->redirect(['index']);
        } else {
            return $this->render('update3', [
                'model' => $model,
                'outgoing' => $outgoing,
            ]);
        }
    }  
                  

    /**
     * Deletes an existing Dashboard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
     

    /**
     * Finds the Dashboard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dashboard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dashboard::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
