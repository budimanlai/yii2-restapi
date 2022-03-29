<?php
namespace budimanlai\restapi\models;

use Yii;

/**
 * This is the model class for table "app".
 *
 * @property int $id
 * @property string $name
 * @property string $app_key
 * @property string $auth_key
 * @property string $status
 */
class App extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'app';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'api_key', 'auth_key', 'status', 'created_at'], 'required'],
            [['created_at', 'last_access_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['api_key'], 'string', 'max' => 32],
            [['auth_key'], 'string', 'max' => 64],
            [['status'], 'string', 'max' => 15],
            [['api_key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'api_key' => 'API Key',
            'auth_key' => 'Auth Key',
            'status' => 'Status',
            'created_at' => 'Created At',
            'last_access_at' => 'Last Access At',
        ];
    }

    /**
     * Gets query for [[UserSessions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserSessions() {
        return $this->hasMany(UserSession::className(), ['app_id' => 'id']);
    }
    
    /**
     * Generate new app
     * 
     * @param string $name app name
     * @return App
     */
    public static function generateApp($name) {
        $model = new App();
        $model->name = $name;
        $model->api_key = Yii::$app->security->generateRandomString();
        $model->auth_key = Yii::$app->security->generateRandomString(64);
        $model->status = 'active';
        $model->created_at = date('Y-m-d H:i:s');
        
        if (!$model->save()) { return null; }
        
        return $model;
    }
}
