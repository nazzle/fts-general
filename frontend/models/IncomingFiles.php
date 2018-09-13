<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\FileStatus;
use frontend\models\Positions;
//use common\models\User;

/**
 * This is the model class for table "incoming_files".
 *
 * @property integer $incId
 * @property string $date
 * @property integer $file_id
 * @property string $subject
 * @property string $from_who
 * @property string $to_whom
 * @property string $delivered_by
 * @property string $received_by
 * @property string $time
 * @property string $file_status
 *
 * @property Files $file
 */
class IncomingFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'incoming_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'subject', 'time', 'action_number', 'file_status'], 'required'],
            [['date', 'deadline', 'time', 'messenger_time','finish_time', 'recipient_time'], 'safe'],
            [['subject', 'action'], 'string'],
            [['sender', 'file_status','recipient_id'], 'integer'],
            [['file_id', 'forwarded_to', 'courier'], 'string', 'max' => 25],
            [['from_who', 'received_by'], 'string', 'max' => 255],
            [['to_who'], 'string', 'max' => 225],
            [['delivered_by'], 'string', 'max' => 50],
            [['action_number'], 'string', 'max' => 15],
        ];
    }
    
    /**
     * CODE TO SET THE SYSTEM TO AUTO PICK THE CURRENT DATE
     * 
     */

    
    public function behaviors()
         {
             return [
                
                 'timestamp' => [
                     'class' => 'yii\behaviors\TimestampBehavior',
                     'attributes' =>   [
                                        ActiveRecord::EVENT_AFTER_INSERT =>'time'
                                      ]
                 ],
             ];
         }
    
    
    
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'incId' => 'Inc ID',
            'date' => 'Date',
            'file_id' => 'Title',
            'subject' => 'Subject',
            'from_who' => 'From',
            'delivered_by' => 'Delivered By',
            'received_by' => 'Received By',
            'forwarded_to' => 'Forwarded To',
            'time' => 'Time',
            'action' => 'Action',
            'action_number' => 'Action Number',
            'file_status' => 'File status',
            'messenger_time' => 'Messenger (PS) Time',
            'recipient_time' => 'Recipient Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(Files::className(), ['file_id' => 'file_id']);
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom()
    {
        return $this->hasOne(Positions::className(), ['id' => 'from_who']);
        
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getTo()
    {
       return $this->hasOne(Positions::className(), ['id' => 'to_who']);
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
   public function getReceiver()
    {
        return $this->hasOne(Positions::className(), ['id' => 'received_by']);
        
    }

      /**
     * @return \yii\db\ActiveQuery
     */
   public function getForward()
    {
        return $this->hasOne(Positions::className(), ['id' => 'forwarded_to']);
        
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
