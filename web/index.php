<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$env = getenv('APP_ENV') ?: 'dev';
$config = __DIR__.'/../config/'.$env.'.php';
if (!file_exists($config))
    throw new ErrorException('Invalid app environment '.$env);
require $config;

$app->error(function (Twig_Error_Loader $e) {
    $message = $e->getMessage();
    if (strpos($message, 'navig.twig'))
        throw new ErrorException($message . ' (Check if you have successfully compiled \'php_ui\' target; php_ui sources are located in \'Generated-PHP-UI\' folder)');
});

$app->run();
