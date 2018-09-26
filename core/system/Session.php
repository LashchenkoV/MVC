<?php
/**
 * Created by PhpStorm.
 * User: viktor
 * Date: 25.09.18
 * Time: 20:12
 */

namespace core\system;


use app\configuration\SessionConfigurator;
use \core\system\models\Session as ModelSession;
class Session
{
    //TODO: очищать старые сессии в БД
    //При повторном вызове переменная сохраняет предидущее своё значение
    private static $inst = NULL;
    private $session=NULL;
    public static function instance():self{
        return self::$inst === NULL ? self::$inst = new self() : self::$inst;
    }
    private function __construct(){}

    private static function getIp(){return md5($_SERVER['REMOTE_ADDR']);}
    private static function getAgent(){return md5($_SERVER['HTTP_USER_AGENT']);}
    private static function getToken(){
        $data = md5(self::getAgent().self::getIp().time());
        return $data;
    }

    /**
     * @param int $id
     * @param bool $long - длительность сессии
     */
    public function createUserSession(int $id, $long = false){
        $time = $long?0:SessionConfigurator::SESSION_TIME;
        $session = new ModelSession();
        $session->user_agent = self::getAgent();
        $session->user_ip = self::getIp();
        $session->token = self::getToken();
        $session->user_id = $id;
        $session->expires = $long?0:time()+$time;
        $session->created = time();
        $session->save();

        $ctime =  $long?3600*24*365:time()+$time;
        setcookie(SessionConfigurator::COOKIE_KEY,$session->token,$ctime,"/");
    }

    public function validateSession():bool {
        if($this->session!==NULL) return true;
        if(empty($_COOKIE[SessionConfigurator::COOKIE_KEY])) return false;
        $session = ModelSession::where("token",":token")->first(["token"=>$_COOKIE[SessionConfigurator::COOKIE_KEY]]);
        if($session->isEmpty()) return false;
        if($session->user_ip!==self::getIp()) return false;
        if($session->user_agent!==self::getAgent()) return false;
        $this->continueSession();
        $this->session = $session;
        return true;
    }

    public function getUserId(){
        if(!$this->validateSession()) throw new \Exception("Session invalid");
        return (int) $this->session->user_id;
    }

    /**
     * @param bool $deep - выходить со всех сессий или только с одной
     */
    public function destroy($deep=false){
        if(!$this->validateSession()) return;
        if($deep)
            ModelSession::where("user_id",$this->session->user_id)->delete();
        else
            $this->session->delete();
        setcookie(SessionConfigurator::COOKIE_KEY,"",time()-1,"/");

    }
    private function continueSession(){
        //TODO:продление сессии
    }
}