<?php
/**
 * Created by PhpStorm.
 * User: viktor
 * Date: 25.09.18
 * Time: 21:03
 */
namespace core\system\hasher;
use app\configuration\PassHashConfigurator;

class PassHasher
{
    //При повторном вызове переменная сохраняет предидущее своё значение
    private static $instance = NULL;
    //Позиция соли
    private $_pos;
    //Длинна соли
    private $_len;
    //Алгоритм
    private $_alg;

    public static function instance():self{
        return self::$instance === NULL ? self::$instance = new self() : self::$instance;
    }

    private function __construct(){
        $this->_pos = PassHashConfigurator::SALT_POS;
        $this->_len = PassHashConfigurator::SALT_LEN;
        $this->_alg = PassHashConfigurator::ALGORITHM;
    }

    private function generateSalt(){
        $h1 = hash('sha256',time());
        $h2 = hash('sha256',rand(0,PHP_INT_MAX));
        $h3 = hash('sha256',$_SERVER["REMOTE_ADDR"]);

        $hd = $h1.$h2.$h3.$h2.$h1;
        $base_salt = hash('sha256',$hd);
        return substr($base_salt,0,$this->_len);

    }

    private function _hash(string $data, string $salt){
        $d = hash($this->_alg,$data);
        $s = hash($this->_alg,$salt);
        $hd = $d.$s.md5($d).$s;
        $h = hash($this->_alg,$hd);
        return substr_replace($h,$salt,$this->_pos,$this->_len);
    }

    public function hash(string $data){
        return $this->_hash($data,$this->generateSalt());
    }

    public function validateHash(string $data, string $hash):bool {
        $salt = substr($hash,$this->_pos,$this->_len);
        $hash2 = $this->_hash($data,$salt);
        return $hash===$hash2;
    }

}