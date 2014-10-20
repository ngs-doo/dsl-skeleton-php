<?php
// router for PHP built-in web server, replaces rewrite rules

$staticAlias = realpath(__DIR__.'/../vendor/dsl-platform/admin/public');

if (isset($_SERVER['REQUEST_URI']))
    $uri = $_SERVER['REQUEST_URI'];

if (strpos($uri, '/static') === 0) {
    $path = realpath($staticAlias . $uri);
    if ($path === false || strpos($path, $staticAlias) !== 0)
        return http_response_code(404);

    $ext = substr($path, strrpos($path, '.'));
    if ($ext === '.css')
        $mime = 'text/css';
    else if ($ext === '.js')
        $mime = 'text/javascript';
    if (isset($mime))
        header('Content-Type: '.$mime);

    if (@readfile($path) === false)
        return http_response_code(404);
}
else
    require __DIR__.'/index.php';
