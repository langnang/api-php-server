<?php
// TODO
global $_SWAGGER, $rewrite;
$module = "toolkit";
array_push($_SWAGGER, ["name" => "{$module}", "url" => "{$rewrite}/swagger/{$module}", "path" => __DIR__]);
/**
 * @OA\Info(title="Toolkit")
 */
$router->addGroup("/toolkit", function (FastRoute\RouteCollector $router) {
});
