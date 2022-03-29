<?php
namespace budimanlai\restapi;

use yii\web\Response;
use common\models\User;

class MyResponse extends Response {
    public $modelError;
    
    public function init() {
        parent::init();
        
        $this->modelError = new User();
        $this->modelError->addError('id', "Invalid ID");
        $this->modelError->validate();
    }
}