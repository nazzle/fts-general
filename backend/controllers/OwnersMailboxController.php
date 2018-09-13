<?php

namespace backend\controllers;

use Yii;
use backend\models\OwnersMailbox;
use backend\models\OwnersMailboxSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use backend\models\OwnersCcfiles;

/**
 * MailboxController implements the CRUD actions for Mailbox model.
 */
class OwnersMailboxController extends Controller
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
     * Lists all Mailbox models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OwnersMailboxSearch();
        $dataProvider = new ActiveDataProvider([
        'query' => OwnersMailbox::find()->
                  where(['forward_to' =>  Yii::$app->user->identity->id ])
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
        $searchModel = new OwnersMailboxSearch();
        $dataProvider = new ActiveDataProvider([
        'query' => OwnersMailbox::find()->
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
        $searchModel = new OwnersCcfiles();
        $dataProvider = new ActiveDataProvider([
        'query' => OwnersCcfiles::find()->
                  where(['forward_to' =>  Yii::$app->user->identity->id ])
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
                    ->update('owners_mailbox', 
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
        $model = new OwnersMailbox();
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
        if (($model = OwnersMailbox::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
