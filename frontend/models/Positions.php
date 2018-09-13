<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "positions".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $position
 * @property string $user_type
 */
class Positions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'positions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'position', 'user_type'], 'required'],
            [['user_id'], 'integer'],
            [['user_type'], 'string'],
            [['position'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'position' => 'Position',
            'user_type' => 'User Type',
        ];
    }
}
