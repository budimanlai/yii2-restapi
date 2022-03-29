<?php
namespace budimanlai\restapi;

use yii\web\Response;

class MyResponse extends Response {
    public $modelErrors;
    
    public function init() {
        parent::init();
        
        $this->format = Response::FORMAT_JSON;
        $this->charset = 'UTF-8';
        $this->on(Response::EVENT_BEFORE_SEND, function ($event) {
            $response = $event->sender;
            if ($this->isSuccessful) {
                $response->data = [
                    'success' => $response->isSuccessful,
                    'data' => $response->data
                ];
            } else {
                $debug = $response->data;
                $response->data = [
                    'success' => false,
                    'message' => $response->data['message'],
                ];
                
                if (YII_DEBUG) {
                    $response->data['debug'] = $debug;
                }
                if (!empty($this->modelErrors)) {
                    $response->data['error'] = $this->modelErrors;
                }
                unset($response->data['type']);
            } 
        });
    }
}