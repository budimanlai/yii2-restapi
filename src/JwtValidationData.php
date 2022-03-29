<?php
namespace budimanlai\restapi;

use yii\filters\auth\AuthMethod;

class JwtValidationData extends AuthMethod {
    
    public $check_user_session = false;
    
    public function authenticate($user, $request, $response) {
        $authHeader = $request->getHeaders()->get('Authorization');
        if ($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            
            $identity = $user->loginByAccessToken($matches[1], $this->check_user_session);
            
            if ($identity === null) {
                $this->handleFailure($response);
            }
            
            return $identity;
        } else {
            return null;
        }
    }
}