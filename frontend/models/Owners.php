<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "owners".
 *
 * @property integer $owner_id
 * @property string $username
 * @property string $synonym
 *
 * @property Files[] $files
 */
class Owners extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'owners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'synonym'], 'required'],
            [['username'], 'string', 'max' => 225],
            [['synonym'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Owner Name',
            'synonym' => 'Synonym',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(Files::className(), ['owner_id' => 'id']);
    }
}
