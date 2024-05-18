<?php
namespace Config;
use AnserGateway\Router\RouteCollector;
use Workerman\Protocols\Http\Response;
return function (RouteCollector $route) {
    /**
     * system default route
     */
    $route->get('/',[\App\Controllers\HeartBeat::class, 'index']);
    $route->get('/zerotrust',[\App\Controllers\ZeroTrustController::class, 'index']);
    $route->get('/ztAPI',[\App\Controllers\ZeroTrustController::class, 'ztAPI']);
    $route->post('/ztAdmin',[\App\Controllers\ZeroTrustController::class, 'ztAdmin']);
}

?>