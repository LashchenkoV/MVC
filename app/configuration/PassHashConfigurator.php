<?php
/**
 * Created by PhpStorm.
 * User: viktor
 * Date: 27.09.18
 * Time: 18:54
 */

namespace app\configuration;


class PassHashConfigurator
{
    const ALGORITHM = 'sha256';
    const SALT_POS = 4;
    const SALT_LEN = 7;
}