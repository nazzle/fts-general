<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\FileStatus;
use frontend\models\Positions;
use common\models\User;
use frontend\models\Files;

/**
 * This is the model class for table "dashboard".
 *
 * @property int $id
 * @property string $date
 * @property string $file_id
 * @property string $subject
 * @property string $from_who
 * @property string $to_who
 * @property int $sender
 * @property string $delivered_by
 * @property string $received_by
 * @property string $forwarded_to
 * @property string $deadline
 * @property string $time
 * @property string $action
 * @property string $action_number
 * @property string $courier
 * @property int $file_status
 * @property string $messenger_time
 * @property string $recipient_time
 * @property string $finish_time
 */
class Dashboard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dashboard';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date', 'deadline', 'time', 'messenger_time', 'recipient_time', 'finish_time'], 'safe'],
            [['subject', 'action'], 'string'],
            [['sender', 'file_status','recipient_id'], 'integer'],
            [['file_id', 'forwarded_to', 'courier'], 'string', 'max' => 25],
            [['from_who', 'to_who', 'received_by'], 'string', 'max' => 225],
            [['delivered_by'], 'string', 'max' => 50],
            [['action_number'], 'string', 'max' => 15],
        ];
    }
    
    
    /**
     * Model instance to save tags arrays
     * selected in internal movement 
     * 
     */
    
 
    
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
            'id' => 'ID',
            'date' => 'Date',
            'file_id' => 'Title',
            'subject' => 'File Name',
            'from_who' => 'From',
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
            'file_status' => 'Status',
            'messenger_time' => 'Messenger Time',
            'recipient_time' => 'Recipient Time',
            'finish_time' => 'Finish Time',
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
   public function getForward()
    {
        return $this->hasOne(Positions::className(), ['id' => 'forwarded_to']);
        
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
   public function getReceivername()
    {
        return $this->hasOne(User::className(), ['id' => 'recipient_id']);
        
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
