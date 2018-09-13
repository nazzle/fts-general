<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Mailbox;
use frontend\models\MailboxSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use frontend\models\CopiedFiles;

/**
 * MailboxController implements the CRUD actions for Mailbox model.
 */
class MailboxController extends Controller
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
     * Lists all Mailbox models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MailboxSearch();
        $dataProvider = new ActiveDataProvider([
        'query' => Mailbox::find()->
                  where(['recipient_id' =>  Yii::$app->user->identity->id ])
                ]);
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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
     /**
     * Lists all Mailbox models.
     * @return mixed
     */
    public function actionSentmails()
    {
        $searchModel = new MailboxSearch();
        $dataProvider = new ActiveDataProvider([
        'query' => Mailbox::find()->
                  where(['sender' =>  Yii::$app->user->identity->id ])
                ]);
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

        return $this->render('sentmails', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

  
    /**
     * Lists all copied files models.
     * @return mixed
     */
    public function actionCcfiles()
    {
        $searchModel = new CopiedFiles();
        $dataProvider = new ActiveDataProvider([
        'query' => CopiedFiles::find()->
                  where(['recipient_id' =>  Yii::$app->user->identity->id ])
                ]);
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

        return $this->render('copiedfiles', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    /**
     * Displays a single Mailbox model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewmailbox($id)
    {
        Yii::$app->db->createCommand()
                    ->update('mailbox', 
                            ['status' => 7],['id' =>$id]
                    )->execute();
        return $this->render('viewmailbox', [
            'model' => $this->findModel($id),
        ]);
    }
    
    
     /**
     * Displays a single Mailbox model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewmailsent($id)
    {
        return $this->render('viewmailsent', [
            'model' => $this->findModel($id),
        ]);
    }
    

    /**
     * Creates a new Mailbox model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mailbox();
        $model->sender = Yii::$app->user->id;
        date_default_timezone_set("Africa/Dar_es_Salaam");
        $model->time = date("h:i:sa");
        $model->date = date('y-m-d');
        $model->status = 6;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['sentmails']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Mailbox model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['sentmails']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Mailbox model.
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
     * Finds the Mailbox model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mailbox the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mailbox::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
