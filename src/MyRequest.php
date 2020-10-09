<?php
namespace budimanlai\restapi;

use yii\web\Request;

class MyRequest extends Request {
    
    public $apiKey;
    public $session;
   
}