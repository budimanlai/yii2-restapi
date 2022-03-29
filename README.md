# How To Use
**1. Run database migration**
./yii migrate --migrationPath=@vendor/budimanlai/yii2-restapi/migrations

**2. Configuration in config/main.php**
```
<?php
return [
    'bootstrap' => [
        [
            'class' => 'budimanlai\restapi\MyRestBootstrap',
            'cookieValidationKey' => '<uniqe_random_string>'
        ]
    ]
];
?>
```

**3. Update findIdentityByAccessToken**
```
public static function findIdentityByAccessToken($token, $type = null)
{
    return MyUserModel::findIdentityByAccessToken($token, $type);
}
```

**4. Update controller**
```
use budimanlai\restapi\JwtHttpBearerAuth;

public function behaviors() {
    // remove rateLimiter which requires an authenticated user to work
    $behaviors = parent::behaviors();
    $behaviors['authenticator'] = [
        'class' => JwtHttpBearerAuth::class,
        'check_session' => false,   // true: check app key + user session
                                    // false: check app key only
    ];
    
    return $behaviors;
}
```

**4. Register application**
```
$model = \budimanlai\restapi\models\App::generateApp("Android");
```

**5. Generate JWT token**
You can see file pre-script.txt