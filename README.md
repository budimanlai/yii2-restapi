# How To Use
**1. Run database migration**
./yii migrate --migrationPath=@vendor/budimanlai/yii2-restapi/migrations

**2. Configuration in config/main.php**
```<?php
    return [
        'components' => [
            'response' => [
                'class' => 'budimanlai\restapi\MyResponse'
            ]
        ]
    ];
?>```

**3. Add Authenticated filter**
How to use:
1. Migration table
$model = \budimanlai\restapi\models\App::generateApp("Android");


