<?php

namespace backend\models;

use frontend\models\User;
use backend\models\FileStatus;
use frontend\models\Files;

use Yii;

/**
 * This is the model class for table "copied_files".
 *
 * @property int $id
 * @property int $sender
 * @property int $forward_to
 * @property string $title
 * @property string $message
 * @property string $date
 * @property string $time
 * @property int $status
 */
class OwnersCcfiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'owners_ccfiles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender', 'title', 'message', 'date', 'time', 'status'], 'required'],
            [['sender', 'forward_to'], 'integer'],
            [['date', 'time'], 'safe'],
            [['title'], 'string', 'max' => 50],
            [['message'], 'string', 'max' => 500],
            [['status'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender' => 'Sender',
            'forward_to' => 'Forward To',
            'title' => 'Title',
            'message' => 'Message',
            'date' => 'Date',
            'time' => 'Time',
            'status' => 'Status',
        ];
    }
    
      /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'sender']);
        
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getTo()
    {
        return $this->hasOne(User::className(), ['id' => 'forward_to']);
        
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getFileStatus()
    {
        return $this->hasOne(FileStatus::className(), ['status_id' => 'status']);
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(Files::className(), ['file_id' => 'title']);
    }
}
