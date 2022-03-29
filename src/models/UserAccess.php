<?php

namespace budimanlai\restapi\models;

use Yii;

/**
 * This is the model class for table "user_access".
 *
 * @property int $id ID
 * @property int $app_id APP ID
 * @property int $user_id User ID
 * @property string $tokens Token
 * @property string $create_on Create On
 * @property string|null $last_access_on
 * @property string|null $remove_on Remove On
 * @property string $from_ip IP
 * @property string|null $user_agent User Agent
 */
class UserAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['app_id', 'user_id'], 'required'],
            [['app_id', 'user_id'], 'integer'],
            [['create_on', 'last_access_on', 'remove_on'], 'safe'],
            [['tokens'], 'string', 'max' => 32],
            [['from_ip'], 'string', 'max' => 15],
            [['user_agent'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_id' => 'App ID',
            'user_id' => 'User ID',
            'tokens' => 'Tokens',
            'create_on' => 'Create On',
            'last_access_on' => 'Last Access On',
            'remove_on' => 'Remove On',
            'from_ip' => 'From Ip',
            'user_agent' => 'User Agent',
        ];
    }
}
