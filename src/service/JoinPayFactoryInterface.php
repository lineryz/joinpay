<?php
/**
 * ---------------------------------------------------------------------------------------------------------------------
 * FileName: FactoryInterface.php
 * Description:
 * ---------------------------------------------------------------------------------------------------------------------
 * Author: lineryz <lineryz@126.com>
 * Date:    2022/1/11
 * Version: 1.0
 */

namespace joinpay\service;


interface JoinPayFactoryInterface
{
    /**
     * @param $driver
     * @return mixed
     */
    public function driver($driver);
}