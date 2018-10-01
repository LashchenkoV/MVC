<?php
/**
 * Created by PhpStorm.
 * User: viktor
 * Date: 27.09.18
 * Time: 20:32
 */

namespace app\controllers;


use core\base\Controller;
use core\system\models\User;
use core\system\Session;
use core\system\Url;
use \core\system\Auth as AuthBase;
class Auth extends Controller
{

    public function action_login(){
        try{
            if(empty($_POST["login"]) || empty($_POST["pass"])) throw new \Exception("Нету пароля или логина");
            if(!AuthBase::instance()->login($_POST['login'],$_POST['pass'])) throw new \Exception("Логин или пароль не верный");
            Url::redirect($_SERVER["HTTP_REFERER"]);
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    public function action_register(){
        try{
            if(empty($_POST["login"]) || empty($_POST["pass"])) throw new \Exception("Нету пароля или логина");
            $user = new User();
            $user->login = $_POST['login'];
            $user->pass = $_POST['pass'];
            try{
                $user->save();
            }catch (\Exception $e){
                throw new \Exception("Логин занят.");
            }
            echo "OK";
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    public function action_logout(bool $deep=false){
        Session::instance()->destroy($deep);
        Url::redirect("/");
    }
}