<?php
namespace budimanlai\restapi;

use Yii;
use sizeg\jwt\JwtHttpBearerAuth as SizegJwt;
use common\models\User;

class JwtHttpBearerAuth extends SizegJwt {
    
    public $check_session;
    
    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response) {
        $authHeader = $request->getHeaders()->get('Authorization');
        if ($authHeader !== null && preg_match('/^' . $this->schema . '\s+(.*?)$/', $authHeader, $matches)) {
            
            $token = $this->loadToken($matches[1]);
            if ($token === null) { return null; }

            if (!$token->hasClaim('iss')) { return null; }
            if (!$token->hasClaim('iat')) { return null; }
            if (!$token->hasClaim('sid')) { return null; }
            
            if ($this->auth) {
                $identity = call_user_func($this->auth, $token, get_class($this));
            } else {
                $identity = $user->loginByAccessToken($token, $this->check_session);
            }
            
            return $identity;
        }

        return null;
    }
    
    public function loadToken($token) {
        try {
            $token = $this->jwt->getParser()->parse((string) $token);
        } catch (\RuntimeException $e) {
            Yii::warning('Invalid JWT provided: ' . $e->getMessage(), 'jwt');
            return null;
        } catch (\InvalidArgumentException $e) {
            Yii::warning('Invalid JWT provided: ' . $e->getMessage(), 'jwt');
            return null;
        }
        
        return $token;
    }
}