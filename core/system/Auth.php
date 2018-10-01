<?php
/**
 * Created by PhpStorm.
 * User: viktor
 * Date: 27.09.18
 * Time: 19:32
 */

namespace core\system;


use core\system\hasher\PassHasher;
use core\system\models\User;
use core\system\Session as Session;

class Auth
{
    private $user = NULL;
    private static $instance = NULL;

    public static function instance():self{
        return self::$instance === NULL ? self::$instance = new self() : self::$instance;
    }
    private function __construct(){}

    public function login(string $login, string $pass, $save = false){
        $user = User::where("login","?")->first([$login]);
        if($user->isEmpty()) return false;
        if(!PassHasher::instance()->validateHash($pass,$user->pass)) return false;
        Session::instance()->createUserSession($user->id,$save);
        return true;
    }
    public function logout($deep=false){
        Session::instance()->destroy($deep);
    }

    public function isAuth(){
        return Session::instance()->validateSession();
    }

    public function getCurrentUser(){
        if(!$this->isAuth()) return NULL;
        if($this->user===NULL)
            $this->user = User::where("id",Session::instance()->getUserId())->first();
        return $this->user;
    }
}