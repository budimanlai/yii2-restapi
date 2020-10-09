<?php
namespace budimanlai\restapi;

use Yii;
use yii\helpers\Json;
use yii\web\JsonResponseFormatter as YiiJson;

class JsonResponseFormatter extends YiiJson {
    
    protected function formatJson($response) {
        if ($response->data !== null) {
            $options = $this->encodeOptions;
            if ($this->prettyPrint) {
                $options |= JSON_PRETTY_PRINT;
            }
            
            if ($response->statusCode == 200) {
                $data = [
                    'success' => true,
                    'data' => null
                ];
                
                if (isset($response->data['data'])) { 
                    $data['data'] = $response->data['data']; 
                } else { 
                    $data['data'] = $response->data; 
                }
                if (isset($response->data['_links'])) { $data['_links'] = $response->data['_links']; }
                if (isset($response->data['_meta'])) { $data['_meta'] = $response->data['_meta']; }
                
                $response->data = $data;
            } else {
                $response->data = [
                    'success' => false,
                    'message' => $response->data['message']
                ];
                
                if (isset($response->modelError)) {
                    $response->data['errors'] = $response->modelError->getErrors();
                }
            }
            
            $response->content = Json::encode($response->data, $options);
        } elseif ($response->content === null) {
            $response->content = 'null';
        }
    }
}