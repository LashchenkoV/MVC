<?php
/**
 * Created by PhpStorm.
 * Note: mamedov
 * Date: 13.09.2018
 * Time: 19:09
 */

namespace app\configuration;


use core\system\exceptions\RouterException;
use core\system\Route;
use core\system\Router;
use core\system\Url;

class RouteConfigurator
{
    public static function routerConfigure(){
        Router::instance()->addRoute(new Route("","main","index"));
        Router::instance()->addRoute(new Route("404","c404","index"));

        Router::instance()->addRoute(new Route("register","auth","register"));
        Router::instance()->addRoute(new Route("login","auth","login"));
        Router::instance()->addRoute(new Route("logout","auth","logout"));
    }

    public static function onRouterError(RouterException $e){
        //echo $e->getMessage();
        Url::redirect("/404");
    }
}