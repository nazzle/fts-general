<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use backend\models\FileStatus;
use frontend\models\Positions;

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
class OutgoingUpdate extends \yii\db\ActiveRecord
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
            [['file_id', 'subject', 'from_who', 'courier','action','action_number','sender'], 'required'],
            [['date', 'time'], 'safe'],
            [['file_id','received_by','file_status'], 'integer'],
            [['subject','forwarded_to'], 'string'],
            [['from_who'], 'string', 'max' => 255],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => Files::className(), 'targetAttribute' => ['file_id' => 'file_id']],
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
            'id' => 'Dashboard ID',
            'date' => 'Date',
            'file_id' => 'File Number',
            'subject' => 'Title',
            'from_who' => 'From',
            'forwarded_to' => 'Forwarded To',
            'sender' => 'Sender',
            'time' => 'Time',
            'action' => 'Action',
            'action_number' => 'Action Number',
            'courier' => 'Courier',
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
        return $this->hasOne(Positions::className(), ['id' => 'to_whom']);
        
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
    public function getFileStatus()
    {
        return $this->hasOne(FileStatus::className(), ['status_id' => 'file_status']);
    }
}
