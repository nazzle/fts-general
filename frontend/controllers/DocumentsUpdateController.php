<?php

namespace frontend\controllers;

use Yii;
use frontend\models\DocumentsTracking;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * IncomingFilesController implements the CRUD actions for IncomingFiles model.
 */
class DocumentsUpdateController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                
                'class' => AccessControl::classname(),
                'only' => ['create', 'update', 'index', 'delete', 'view'],
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
     public function actionEditincomingdoc($id)
    {
      
        $model = $this->findModel($id);
     if(Yii::$app->user->id == $model->sender || Yii::$app->user->can('HEAD')) 
     {
        //if ($model->load(Yii::$app->request->post()) && $outgoing->load(Yii::$app->request->post()) ) {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {    
  
            return $this->redirect(['/incoming-files/index']);
        } else {
            return $this->render('editincoming', [
                'model' => $model,
               // 'outgoing' => $outgoing,
            ]);
        }
     }else {
             throw new ForbiddenHttpException(Yii::t('yii', 'You can only edit the files that you sent.'));
        }  
    }  
    
    
    public function actionEditinternaldoc($id)
    {
        
        $model = $this->findModel($id);
        if(Yii::$app->user->id == $model->sender || Yii::$app->user->can('HEAD')) 
     {
       // if ($model->load(Yii::$app->request->post()) && $internal->load(Yii::$app->request->post()) ) {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {    
  
            return $this->redirect(['/incoming-files/index']);
        } else {
            return $this->render('editinternal', [
                'model' => $model,
            ]);
        }
        }else {
             throw new ForbiddenHttpException(Yii::t('yii', 'You can only edit the files that you sent.'));
        }  
    }  
    
    
  public function actionEditoutgoingdoc($id)
    {
        
        $model = $this->findModel($id);
         if(Yii::$app->user->id == $model->sender || Yii::$app->user->can('HEAD')) 
     {
        //if ($model->load(Yii::$app->request->post()) && $outgoing->load(Yii::$app->request->post()) ) {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {    
  
            return $this->redirect(['/incoming-files/index']);
        } else {
            return $this->render('editoutgoing', [
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
        if (($model = DocumentsTracking::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
