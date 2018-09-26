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
        Router::instance()->addRoute(new Route("test","main","test"));
        Router::instance()->addRoute(new Route("addTodo","main","addTodo"));
        Router::instance()->addRoute(new Route("getTableNotes","main","getTableNotes"));
        Router::instance()->addRoute(new Route("delNote","main","delNote"));
        Router::instance()->addRoute(new Route("editNote","main","editNote"));
        Router::instance()->addRoute(new Route("getEditForm","main","getEditForm"));
        Router::instance()->addRoute(new Route("test","main","test"));
        Router::instance()->addRoute(new Route("404","c404","index"));
    }

    public static function onRouterError(RouterException $e){
        //echo $e->getMessage();
        Url::redirect("/404");
    }
}