<?php
/**
 * Created by PhpStorm.
 * Note: mamedov
 * Date: 18.09.2018
 * Time: 18:43
 */

namespace app\configuration;


class DatabaseConfigurator
{
    const CONFIGURATION = [
        'default'=>[
            'host'=>'127.0.0.1',
            'port'=>3306,
            'dbname'=>'mydb',
            'user'=>'root',
            'pass'=>'root',
            'charset'=>'utf8'
        ],
        'custom1'=>[
            'host'=>'127.0.0.1',
            'port'=>3306,
            'dbname'=>'dbname2',
            'user'=>'vasia',
            'pass'=>'secret',
            'charset'=>'utf8'
        ]
    ];

    const DEFAULT_CONFIGURATION = 'default';

    public static function getConfiguration(string $configName=self::DEFAULT_CONFIGURATION){
        return (object)self::CONFIGURATION[$configName];
    }
}