<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\IncomingFiles;

/**
 * IncomingFilesSearch represents the model behind the search form about `frontend\models\IncomingFiles`.
 */
class IncomingFilesSearch extends IncomingFiles
{
    /**
     * @inheritdoc
     */
    public $globalSearch;
    
    public function rules()
    {
        return [
            [['incId', 'file_id'], 'integer'],
            [['date', 'subject','globalSearch', 'from_who', 'to_who', 'delivered_by', 'received_by', 'time'], 'safe'],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['file_id' => 'file_id']],
            [['file_status'], 'exist', 'skipOnError' => true, 'targetClass' => \backend\models\FileStatus::className(), 'targetAttribute' => ['status_id' => 'file_status']],
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
        $query = IncomingFiles::find();
        $query -> joinWith(['file','fileStatus']);
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
        

//        // grid filtering conditions
//        $query->orFilterWhere([
//            'incId' => $this->incId,
//            'file.file_name' => $this->file_id,
//            'file_id' => $this->file_id,
//            'time' => $this->time,
//        ]);

        $query->orFilterWhere(['like', 'file_number', $this->globalSearch])
            ->orFilterWhere(['like', 'subject', $this->globalSearch])    
            ->orFilterWhere(['like', 'from_who', $this->globalSearch])
            ->orFilterWhere(['like', 'to_who', $this->globalSearch])
            ->orFilterWhere(['like', 'delivered_by', $this->globalSearch])
            ->orFilterWhere(['like', 'received_by', $this->globalSearch])
            ->orFilterWhere(['like', 'file_status', $this->globalSearch]);

        return $dataProvider;
    }
}
