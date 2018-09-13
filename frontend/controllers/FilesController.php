<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Files;
use frontend\models\FilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * FilesController implements the CRUD actions for Files model.
 */
class FilesController extends Controller
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
     * Lists all Files models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['status'=>5]); 
        $dataProvider->pagination = ['pageSize' => 12];
        $dataProvider->setSort([
        'attributes' => [
            'file_id' => [
                'asc' => ['file_id' => SORT_ASC],
                'desc' => ['file_id' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'date_created' => [
                'asc' => ['date_created' => SORT_ASC],
                'desc' => ['date_created' => SORT_DESC],
                'default' => SORT_ASC,
            ],
        ],
        'defaultOrder' => [
            'file_id' => SORT_DESC
        ]
    ]);
        
        
        $pendingFiles = new FilesSearch();
        $pendingGrid = $pendingFiles->search(Yii::$app->request->queryParams);
        $pendingGrid->query->andFilterWhere(['status'=>4]); 
        $pendingGrid->pagination = ['pageSize' => 5];
        $pendingGrid->setSort([
        'attributes' => [
            'file_id' => [
                'asc' => ['file_id' => SORT_ASC],
                'desc' => ['file_id' => SORT_DESC],
                'default' => SORT_ASC
            ],
            'date_created' => [
                'asc' => ['date_created' => SORT_ASC],
                'desc' => ['date_created' => SORT_DESC],
                'default' => SORT_ASC,
            ],
        ],
        'defaultOrder' => [
            'file_id' => SORT_DESC
        ]
    ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pendingFiles' => $pendingFiles,
            'pendingGrid' => $pendingGrid
        ]);
    }

    /**
     * Displays a single Files model.
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
     * Displays a single Files model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewpending($id)
    {
        if(Yii::$app->user->can('HEAD')) 
     {
        return $this->render('viewpending', [
            'model' => $this->findModel($id),
        ]);
        
        }else {
             throw new ForbiddenHttpException(Yii::t('yii', 'You do not have privileges to perfom this action.Contact Admin.'));
        }  
    }

    /**
     * Creates a new Files model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('CREATE-FILES'))
        {
        $model = new Files();
        $model->created_date = date('y-m-d');
        $model->status = 4;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }  
    }
    
    
    /**
     * 
     * Here is the action that handles uploading of excel sheet files list.
     */
    
    public function actionImportExcel(){
        
        $inputFile = 'upload/file_list.xls';
        
        try{            
            $inputFileType = \PHPExcel_IOFactory::identify($inputFile);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFile);            
        } catch (Exception $ex) {   
            die('Error');
        }
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        
        for($row = 1; $row <= $highestRow; $row++){
            
            $rowData = $sheet->rangeToArray('A'.$row.$highestColumn.$row,NULL,TRUE,FALSE);
            
            if($row == 1){
                continue;
            }
            
            $file = new Files();
            $file->owner_id = $rowData[0][0];
            $file->file_number= $rowData[0][1];
            $file->file_name= $rowData[0][2];
            $file->created_date= $rowData[0][3];
            $file->created_by= $rowData[0][4];
            $file->status = 6;
            $file->save();
            
            print_r($file->getErrors());
        }
        die('Okay');
    }

    /**
     * Updates an existing Files model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * This action is for approving the new files created by users that have no Head privileges.
     */
    
    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        
        if(Yii::$app->user->can('HEAD')) 
     {   
            Yii::$app->db->createCommand()
            ->insert('dashboard', [
                    'date'=> $model->created_date ,
                    'file_id' => $id,
                    'subject'=> $id,
                    'file_status' => 2,
            ])->execute();
            
            Yii::$app->db->createCommand()
                    ->update('files', 
                            ['status' => 5,],['file_id' =>$id]
                    )->execute();
            return $this->redirect(['index']);
            
      } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }        
    
    }

    /**
     * Deletes an existing Files model.
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
     * 
     * This action is to find all the the file subjects associating
     * with the given file number.
     */
    public function actionFilelist($id)
    {
    
        $countFilesnames = Files::find()
                ->where(['file_id'=>$id])
                ->count();
        
        $filesnames = Files::find()
                ->where(['file_id'=> $id])
                ->all();
        
        if ($countFilesnames > 0)
        {
            foreach($filesnames as $filename) {
                echo "<option value='".$filename->file_id."'>".$filename->file_name."</option>";
            } 
        }else {
                echo "<option>-</option>";
            
            }
        
    }
    
    

    /**
     * Finds the Files model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Files the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Files::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
