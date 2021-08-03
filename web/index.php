<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
defined('YII_LOCAL') or define('YII_LOCAL', true);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

if (!YII_LOCAL)
    $config = require __DIR__ . '/../config/web.php';
else
    $config = require __DIR__ . '/../config/web-local.php';

(new yii\web\Application($config))->run();
