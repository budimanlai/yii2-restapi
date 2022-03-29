<?php
namespace budimanlai\restapi;

use yii\rest\ActiveController;
use budimanlai\restapi\JwtValidationData;

class MyActiveController extends ActiveController {
    
    public $check_user_session = false;
    
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];
    
    public function behaviors() {
        $behaviors = parent::behaviors();
        
        $behaviors['basicAuth'] = [
            'class' => JwtValidationData::className(),
            'check_user_session' => $this->check_session
        ];
        
        return $behaviors;
    }
}