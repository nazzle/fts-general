<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "file_status".
 *
 * @property integer $status_id
 * @property string $status
 *
 * @property IncomingFiles[] $incomingFiles
 * @property InternalFiles[] $internalFiles
 * @property OutgoingFiles[] $outgoingFiles
 */
class FileStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'status_id' => 'Status ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncomingFiles()
    {
        return $this->hasMany(IncomingFiles::className(), ['file_status' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInternalFiles()
    {
        return $this->hasMany(InternalFiles::className(), ['file_status' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutgoingFiles()
    {
        return $this->hasMany(OutgoingFiles::className(), ['file_status' => 'status_id']);
    }
}
