<?php

use Silex\Provider\MonologServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;

\Symfony\Component\Debug\Debug::enable();

require __DIR__ . '/common.php';

$client = new \NGS\Client\RestHttp('http://localhost:9123/', 'revenj', 'revenj');
\NGS\Client\RestHttp::instance($client);
$app['dsl.client'] = $app->share(function() use ($client) {
    return $client;
});
$app['dsl'] = $app->share(function() { return new \PhpDslAdmin\DomainService(); });

$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/silex_prod.log',
));

$app->register($p = new WebProfilerServiceProvider(), array(
    'profiler.cache_dir' => __DIR__.'/../var/cache/profiler',
));
$app->mount('/_profiler', $p);
