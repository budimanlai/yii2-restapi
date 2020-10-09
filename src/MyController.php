<?php
namespace budimanlai\restapi;

use budimanlai\restapi\MyBaseController;

class MyController extends MyBaseController {
    
    public $check_user_session = false;
    
    public function behaviors() {
        $behaviors = parent::behaviors();
        
        $behaviors['basicAuth'] = [
            'class' => JwtValidationData::className(),
            'check_user_session' => $this->check_user_session
        ];
        
        return $behaviors;
    }
}