<?php
/* @var \Silex\Application $app */

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    "twig.path" => __DIR__ . "/../templates/"
));

$app->register(new Silex\Provider\HttpCacheServiceProvider(), array(
    'http_cache.cache_dir'  => __DIR__ . "/../var/cache/",
    'http_cache.esi'        => null
));

if (isset($app['debug']) && $app['debug']) {
    $app->register(new Silex\Provider\MonologServiceProvider(), array(
        'monolog.level' => \Monolog\Logger::DEBUG,
        'monolog.logfile' =>  __DIR__ . "/../var/logs/dev.log",
    ));
}

$folder = __DIR__ . "/../config/";
$file = file_exists($folder . "parameters.json") ? "parameters.json" : "parameters.dist.json";
$app->register(new Igorw\Silex\ConfigServiceProvider($folder . $file), array());
