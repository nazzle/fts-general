<?php

namespace frontend\models;
use common\models\User;

use Yii;
use yii\db\ActiveRecord;
use backend\models\FileStatus;

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
class InternalDocuments extends \yii\db\ActiveRecord
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
            [['docId','title', 'subject', 'from_who', 'forwarded_to', 'delivered_by','action_number'], 'required'],
            [['date', 'time','messenger_time','recipient_time'], 'safe'],
            [['received_by','file_status','sender'], 'integer'],
            [['subject'], 'string'],
            [['forwarded_to','action'], 'string'],
            [['from_who', 'received_by'], 'string', 'max' => 255],
            [['delivered_by'], 'string', 'max' => 50],
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
            'docId' => 'Doc ID',
            'date' => 'Date',
            'title' => 'Title',
            'subject' => 'Subject',
            'from_who' => 'From Who',
            'forwarded_to' => 'Forwarded To',
            'sender' => 'sender',
            'deadline' => 'Deadline',
            'time' => 'Time',
            'action' => 'Action',
            'action_number' => 'Action Number',
            'file_status' => 'File status',
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
    public function getOwner()
    {
        return $this->hasOne(Owners::className(), ['owner_id' => 'from_who']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_whom']);
        
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
   public function getSender()
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
