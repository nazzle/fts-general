<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "files".
 *
 * @property integer $file_id
 * @property integer $owner_id
 * @property string $file_number
 * @property string $file_name
 *
 * @property Owners $owner
 * @property IncomingFiles[] $incomingFiles
 * @property InternalFiles[] $internalFiles
 * @property OutgoingFiles[] $outgoingFiles
 */
class Files extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'file_number', 'file_name'], 'required'],
            [['created_date'], 'safe'],
            [['file_number'], 'unique'],
            [['owner_id','status'], 'integer'],
            [['file_name','created_by'], 'string'],
            [['file_number','created_by'], 'string', 'max' => 25],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Owners::className(), 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file_id' => 'File ID',
            'owner_id' => 'Owner',
            'file_number' => 'File Number',
            'file_name' => 'File Name',
            'created_date' => 'Date Created',
            'creted_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Owners::className(), ['id' => 'owner_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncomingFiles()
    {
        return $this->hasMany(IncomingFiles::className(), ['file_id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInternalFiles()
    {
        return $this->hasMany(InternalFiles::className(), ['file_id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutgoingFiles()
    {
        return $this->hasMany(OutgoingFiles::className(), ['file_id' => 'file_id']);
    }
}
