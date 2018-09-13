<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\DocumentsTracking;

/**
 * DocumentsTrackingSearch represents the model behind the search form about `frontend\models\DocumentsTracking`.
 */
class DocumentsTrackingSearch extends DocumentsTracking
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['docId', 'sender', 'file_status'], 'integer'],
            [['date', 'title', 'subject', 'from_who', 'to_who', 'delivered_by', 'received_by', 'forwarded_to', 'deadline', 'time', 'action', 'action_number', 'courier', 'messenger_time', 'recipient_time'], 'safe'],
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
        $query = DocumentsTracking::find();

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
        $query->andFilterWhere([
            'docId' => $this->docId,
            'date' => $this->date,
            'sender' => $this->sender,
            'deadline' => $this->deadline,
            'time' => $this->time,
            'file_status' => $this->file_status,
            'messenger_time' => $this->messenger_time,
            'recipient_time' => $this->recipient_time,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'from_who', $this->from_who])
            ->andFilterWhere(['like', 'to_who', $this->to_who])
            ->andFilterWhere(['like', 'delivered_by', $this->delivered_by])
            ->andFilterWhere(['like', 'received_by', $this->received_by])
            ->andFilterWhere(['like', 'forwarded_to', $this->forwarded_to])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'action_number', $this->action_number])
            ->andFilterWhere(['like', 'courier', $this->courier]);

        return $dataProvider;
    }
}
