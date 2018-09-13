<?php

namespace backend\models;

use frontend\models\User;
use backend\models\FileStatus;
use frontend\models\Files;

use Yii;

/**
 * This is the model class for table "mailbox".
 *
 * @property int $id
 * @property int $sender
 * @property string $message
 * @property string $date
 * @property string $time
 * @property int $status
 */
class OwnersMailbox extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'owners_mailbox';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender', 'message', 'date', 'time', 'status'], 'required'],
            [['sender', 'status','forward_to'], 'integer'],
            [['title'], 'string'],
            [['date', 'time'], 'safe'],
            [['message'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender' => 'From',
            'forward_to' => 'Recipient',
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
