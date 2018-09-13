<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Dashboard;
use backend\models\FileStatus;
/**
 * DashboardSearch represents the model behind the search form of `frontend\models\Dashboard`.
 */
class DashboardSearch extends Dashboard
{
    /**
     * @inheritdoc
     */
    public $dashboardSearch;
    public function rules()
    {
        return [
            [['id', 'sender', 'file_status'], 'integer'],
            [['date', 'file_id','dashboardSearch', 'subject', 'from_who', 'to_who', 'delivered_by', 'received_by', 'forwarded_to', 'deadline', 'time', 'action', 'action_number', 'courier', 'messenger_time', 'recipient_time', 'finish_time'], 'safe'],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['file_id' => 'file_id']],
            [['file_status'], 'exist', 'skipOnError' => true, 'targetClass' => FileStatus::className(), 'targetAttribute' => ['status_id' => 'file_status']],
            [['forwarded_to'], 'exist', 'skipOnError' => true, 'targetClass' => Positions::className(), 'targetAttribute' => ['id' => 'forwarded_to']],
            [['from_who'], 'exist', 'skipOnError' => true, 'targetClass' => Positions::className(), 'targetAttribute' => ['id' => 'from_who']],
            [['subject'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['file_name' => 'subject']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Dashboard::find();
        $query -> joinWith(['file','fileStatus','forward',]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'date' => $this->date,
//            'sender' => $this->sender,
//            'deadline' => $this->deadline,
//            'time' => $this->time,
//            'file_status' => $this->file_status,
//            'messenger_time' => $this->messenger_time,
//            'recipient_time' => $this->recipient_time,
//            'finish_time' => $this->finish_time,
//        ]);

        $query->orFilterWhere(['like', 'file_number', $this->dashboardSearch])
            ->orFilterWhere(['like', 'file_name', $this->dashboardSearch])
            ->orFilterWhere(['like', 'position', $this->dashboardSearch])
            ->orFilterWhere(['like', 'action_number', $this->dashboardSearch])
            ->orFilterWhere(['like', 'file_status', $this->dashboardSearch]);

        return $dataProvider;
    }
}
