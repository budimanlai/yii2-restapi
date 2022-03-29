<?php
namespace budimanlai\restapi\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;

class MyUserModel extends ActiveRecord {
    
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token_string, $type = null)
    {
        $jwt = new \sizeg\jwt\Jwt();
        $token = $jwt->getParser()->parse((string) $token_string);
        $data = $jwt->getValidationData();
        $data->setCurrentTime(time());
        
        // validate token data
        if (!$token->validate($data)) { throw new \yii\web\BadRequestHttpException("Token expired"); }
       
        $claims = $token->getClaims();
       
        // validate API Key
        Yii::$app->request->app = \budimanlai\restapi\models\App::find()
            ->where([
                'api_key' => $claims['iss'],
                'status' => 'active'
            ])
            ->one();
        
        if (Yii::$app->request->app == null) { throw new \yii\web\BadRequestHttpException("Invalid API Key. Please contact your administrator"); }
        
        $s = Yii::$app->request->app->auth_key . $claims['iat'];
        if (!empty($claims['sid'])) {
            //$s.= $claims['sid'];
        }
        if ($type) {
            if (!isset($claims['sid'])) { throw new \yii\web\BadRequestHttpException("Invalid user session or session not found"); }
            
            // check user session
            $rs = Yii::$app->db->createCommand("select * from user_access
                where app_id = :AID and BINARY tokens = :TOKEN and remove_on is null", [
                    ':AID' => Yii::$app->request->app->id,
                    ':TOKEN' => $claims['sid']
                ])->queryOne();
            
            if ($rs == null) { throw new \yii\web\BadRequestHttpException("Invalid user session or session not found"); }
            
            Yii::$app->request->session = $rs;
        }
        
        if (!empty($claims['sid'])) { $s.= $claims['sid']; }
        
        $key_string = base64_encode(hash('sha256', $s));
        
        $signer = $jwt->getSigner('HS256');
        $key = new \Lcobucci\JWT\Signer\Key($key_string);
       
        if (!$token->verify($signer, $key)) { throw new \yii\web\BadRequestHttpException("Invalid signature"); }
       
        if ($type == true) {
            $model = self::findOne($rs['user_id']);
            
            Yii::$app->db->createCommand()->update('user_access', 
                [
                    'last_access_on' => date("Y-m-d H:i:s"),
                    'from_ip' => Yii::$app->request->getUserIP(),
                    'user_agent' => Yii::$app->request->getUserAgent()
                ], 
                'id = :ID', [':ID' => $rs['id']])->execute();
        } else {
            $model = new User();
        }
        
        Yii::$app->request->app->last_access_at = date("Y-m-d H:i:s");
        Yii::$app->request->app->save();
        
        return new User();
    }
    
}