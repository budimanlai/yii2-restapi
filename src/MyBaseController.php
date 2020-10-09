<?php
namespace budimanlai\restapi;

use Yii;
use yii\rest\Controller;

class MyBaseController extends Controller {
    
    public $jsonData;
    
    public function beforeAction($action) {
        
        $this->jsonData = null;
        $stringJson = Yii::$app->request->getRawBody();
        try {
            if (!empty($stringJson)) { $this->jsonData = \yii\helpers\Json::decode($stringJson, true); }
        } catch (yii\base\Exception $e) {
            
        }
        
        return parent::beforeAction($action);
    }
}