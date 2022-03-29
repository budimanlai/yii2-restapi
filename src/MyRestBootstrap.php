<?php
namespace budimanlai\restapi;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

class MyRestBootstrap implements BootstrapInterface {
    public $cookieValidationKey;
    
    /**
    * Bootstrap method to be called during application bootstrap stage.
    * @param Application $app the application currently running
    */
    public function bootstrap($app) {
        $app->set('response', [
            'class' => 'budimanlai\restapi\MyResponse'
        ]);
        $app->set('request', [
            'class' => 'budimanlai\restapi\MyRequest',
            'cookieValidationKey' => $this->cookieValidationKey
        ]);
        $app->set('jwt', [
            'class' => \sizeg\jwt\Jwt::class
        ]);
    }
}