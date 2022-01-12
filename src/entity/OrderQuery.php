<?php

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * FileName: OrderQuery.php
 * Description: 订单查询类
 * ---------------------------------------------------------------------------------------------------------------------
 * Author: lineryz <lineryz@126.com>
 * Date:    2022/1/11
 * Version: 1.0
 */
namespace joinpay\entity;

use joinpay\JoinPayClient;
use joinpay\service\JoinPayRequest;

class OrderQuery extends JoinPayRequest
{
    protected $uri = 'https://www.joinpay.com/trade/queryOrder.action';

    protected $method = 'POST';

    public function __construct($data=[])
    {
        parent::__construct($data);
        $this->params['p1_MerchantNo'] = JoinPayClient::getInstance()->app_id;
    }

    /**
     * 商户的唯一单号
     * @param $val
     * @return $this
     */
    public function setOrderNo($val){
        $this->params['p2_OrderNo'] = $val;
        return $this;
    }
}