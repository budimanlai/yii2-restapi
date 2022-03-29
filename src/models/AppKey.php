<?php

namespace budimanlai\restapi\models;

use Yii;

/**
 * This is the model class for table "api_key".
 *
 * @property int $id
 * @property string $name
 * @property string $skey
 * @property string $auth_key
 * @property string $status
 * @property string|null $last_access
 */
class AppKey extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_key';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['last_access'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['skey'], 'string', 'max' => 32],
            [['auth_key'], 'string', 'max' => 64],
            [['status'], 'string', 'max' => 15],
            [['skey'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'skey' => 'Skey',
            'auth_key' => 'Auth Key',
            'status' => 'Status',
            'last_access' => 'Last Access',
        ];
    }
}
