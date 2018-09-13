<?php

namespace backend\controllers;

use Yii;
use backend\models\OwnersDashboard;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * IncomingFilesController implements the CRUD actions for IncomingFiles model.
 */
class OwnersDashboardUpdateController extends Controller
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
     * Change an existing IncomingFiles status.
     * If update is successful, the browser will be redirected to the 'index' page and a new entry will be added in the database.
     * @param integer $id
     * @return mixed
     */
     public function actionUpdate1($id)
    {
      
        $model = $this->findModel($id);
     if(Yii::$app->user->id == $model->sender || Yii::$app->user->can('HEAD')) 
     {
        //if ($model->load(Yii::$app->request->post()) && $outgoing->load(Yii::$app->request->post()) ) {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {    
  
            return $this->redirect(['/owners-dashboard/index']);
        } else {
            return $this->render('update1', [
                'model' => $model,
               // 'outgoing' => $outgoing,
            ]);
        }
     }else {
             throw new ForbiddenHttpException(Yii::t('yii', 'You can only edit the files that you sent.'));
        }  
    }  
    
    
    public function actionUpdate2($id)
    {
        
        $model = $this->findModel($id);
        if(Yii::$app->user->id == $model->sender || Yii::$app->user->can('HEAD')) 
     {
       // if ($model->load(Yii::$app->request->post()) && $internal->load(Yii::$app->request->post()) ) {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {    
  
            return $this->redirect(['/owners-dashboard/index']);
        } else {
            return $this->render('update2', [
                'model' => $model,
            ]);
        }
        }else {
             throw new ForbiddenHttpException(Yii::t('yii', 'You can only edit the files that you sent.'));
        }  
    }  
    
    
  public function actionUpdate3($id)
    {
        
        $model = $this->findModel($id);
         if(Yii::$app->user->id == $model->sender || Yii::$app->user->can('HEAD')) 
     {
        //if ($model->load(Yii::$app->request->post()) && $outgoing->load(Yii::$app->request->post()) ) {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {    
  
            return $this->redirect(['/owners-dashboard/index']);
        } else {
            return $this->render('update3', [
                'model' => $model,
               // 'outgoing' => $outgoing,
            ]);
        }
        }else {
             throw new ForbiddenHttpException(Yii::t('yii', 'You can only edit the files that you sent.'));
        }  
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
        if (($model = OwnersDashboard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
