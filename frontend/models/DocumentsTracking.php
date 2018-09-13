<?php

namespace frontend\models;


use Yii;
use backend\models\FileStatus;

/**
 * This is the model class for table "documents_tracking".
 *
 * @property integer $docId
 * @property string $date
 * @property string $title
 * @property string $subject
 * @property string $from_who
 * @property string $to_who
 * @property integer $sender
 * @property string $delivered_by
 * @property string $received_by
 * @property string $forwarded_to
 * @property string $deadline
 * @property string $time
 * @property string $action
 * @property string $action_number
 * @property string $courier
 * @property integer $file_status
 * @property string $messenger_time
 * @property string $recipient_time
 */
class DocumentsTracking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documents_tracking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'subject', 'time', 'action_number', 'file_status'], 'required'],
            [['date', 'deadline', 'time', 'messenger_time', 'recipient_time'], 'safe'],
            [['subject', 'action'], 'string'],
            [['sender', 'file_status'], 'integer'],
            [['title', 'forwarded_to', 'courier'], 'string', 'max' => 25],
            [['from_who', 'received_by'], 'string', 'max' => 255],
            [['to_who'], 'string', 'max' => 225],
            [['delivered_by'], 'string', 'max' => 50],
            [['action_number'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'docId' => 'Doc ID',
            'date' => 'Date',
            'title' => 'Title',
            'subject' => 'Subject',
            'from_who' => 'From Who',
            'to_who' => 'To Who',
            'sender' => 'Sender',
            'delivered_by' => 'Delivered By',
            'received_by' => 'Received By',
            'forwarded_to' => 'Forwarded To',
            'deadline' => 'Deadline',
            'time' => 'Time',
            'action' => 'Action',
            'action_number' => 'Action Number',
            'courier' => 'Courier',
            'file_status' => 'File Status',
            'messenger_time' => 'Messenger Time',
            'recipient_time' => 'Recipient Time',
        ];
    }
    
   
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'from_who']);
        
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getTo()
    {
       return $this->hasOne(User::className(), ['id' => 'to_who']);
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
   public function getReceiver()
    {
        return $this->hasOne(User::className(), ['id' => 'received_by']);
        
    }

      /**
     * @return \yii\db\ActiveQuery
     */
   public function getForward()
    {
        return $this->hasOne(User::className(), ['id' => 'forwarded_to']);
        
    }

      /**
     * @return \yii\db\ActiveQuery
     */
   public function getSend()
    {
        return $this->hasOne(User::className(), ['id' => 'sender']);
        
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getFileStatus()
    {
        return $this->hasOne(FileStatus::className(), ['status_id' => 'file_status']);
    }
}
