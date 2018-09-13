<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $privileges
 * @property string $type
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'created_at', 'updated_at', 'type'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['privileges', 'type'], 'string'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'id' => 'ID',
            'username' => 'Username',
           // 'auth_key' => 'Auth Key',
           // 'password_hash' => 'Password Hash',
           // 'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            //'created_at' => 'Created At',
            //'updated_at' => 'Updated At',
            'privileges' => 'Privileges',
            'type' => 'Type',
        ];
    }
}
