<?php

namespace frontend\controllers;

use Yii;
use frontend\models\DocumentsTracking;
use frontend\models\DocumentsTrackingSearch;
use frontend\models\InternalDocuments;
use frontend\models\OutgoingDocuments;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * DocumentsTrackingController implements the CRUD actions for DocumentsTracking model.
 */
class DocumentsTrackingController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all DocumentsTracking models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentsTrackingSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = new ActiveDataProvider([
        'query' => DocumentsTracking::find()->
                  where(['recipient_id' => Yii::$app->user->identity->id ])
                ]);
        $dataProvider->setSort([
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
        ]);
    }

    /**
     * Displays a single DocumentsTracking model.
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
     * Creates a new DocumentsTracking model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DocumentsTracking();
         date_default_timezone_set("Africa/Dar_es_Salaam");
        $model->time = date("h:i:sa");
        $model->date = date('y-m-d');
        $model->sender = Yii::$app->user->id; 
        $model->file_status = 1;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DocumentsTracking model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->docId]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    
    public function actionUpdate2($id)
    {
        
        $model = $this->findModel($id);
        $internal = new InternalDocuments;
        
        $model->sender = Yii::$app->user->id; 
         date_default_timezone_set("Africa/Dar_es_Salaam");
        $thisTime = date("h:i:sa");
        $todayDate = date('y-m-d');

        if ($model->load(Yii::$app->request->post()) && $internal->load(Yii::$app->request->post()) ) {
            
            $user_ids = (new \yii\db\Query())
            ->select('user_id')
            ->distinct()
            ->from('positions')
            ->where(['id' => $internal->forwarded_to])
            ->one();

            foreach ($user_ids as $user_id){}
            
            Yii::$app->db->createCommand()
            ->insert('documents_tracking', [
                    'date'=> $todayDate,
                    'title' => $model->title,
                    'subject'=> $model->subject,
                    'from_who' => $model->from_who,
                    'sender'=> $model->sender,
                    'forwarded_to'=>$internal->forwarded_to,
                    'recipient_id' =>$user_id,
                    'deadline'=>$internal->deadline,
                    'action' =>$internal->action,
                    'action_number' =>$internal->action_number,
                    'time'=> $thisTime,
                    'file_status' => 2,
            ])->execute();
   
            return $this->redirect(['/dashboard/index']);
        } else {
            return $this->render('update2', [
                'model' => $model,
                'internal' => $internal,
            ]);
        }
    }
    
    
    public function actionUpdate3($id)
    {
        
        $model = $this->findModel($id);
        $outgoing = new OutgoingDocuments;
        
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
            ->insert('documents_tracking', [
                    'date'=> $todayDate,
                    'title' => $model->title,
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
   
            return $this->redirect(['/dashboard/index']);
        } else {
            return $this->render('update3', [
                'model' => $model,
                'outgoing' => $outgoing,
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
                $mesengerTime= date('Y-m-d h:i:s');
                 Yii::$app->db->createCommand()
                    ->update('documents_tracking', 
                            ['messenger_time' => $model->messenger_time= $mesengerTime,],['docId' =>$id]
                    )->execute();
                return $this->redirect(['view', 'id' => $model->docId]); 
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
    public function actionRecipient($id)
    {
        $model = $this->findModel($id);
        if(Yii::$app->user->id == $model->forwarded_to)
        {
                
                date_default_timezone_set("Africa/Dar_es_Salaam");
                $recipientTime= date("Y-m-d h:i:s");
                 Yii::$app->db->createCommand()
                    ->update('documents_tracking', 
                            ['recipient_time' => $model->recipient_time= $recipientTime,],['docId' =>$id]
                    )->execute();
                return $this->redirect(['index']);
        } else {
             throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }        
    } 
    
    

    /**
     * Deletes an existing DocumentsTracking model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DocumentsTracking model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DocumentsTracking the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DocumentsTracking::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
