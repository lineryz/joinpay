<?php

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * FileName: Refund.php
 * Description: 订单退款类
 * ---------------------------------------------------------------------------------------------------------------------
 * Author: lineryz <lineryz@126.com>
 * Date:    2022/1/11
 * Version: 1.0
 */
namespace joinpay\entity;


use joinpay\JoinPayClient;
use joinpay\service\JoinPayRequest;

class Refund extends JoinPayRequest
{
    protected $uri = 'https://www.joinpay.com/trade/refund.action';

    protected $method = "POST";

    function __construct($data=[])
    {
        parent::__construct($data);

        $this->params['q1_version']         = '1.0';
        $this->params['p1_MerchantNo']      = JoinPayClient::getInstance()->app_id;
    }

    /**
     * 设置当前版本号
     * @param $val
     * @return $this
     */
    public function setVerison($val){
        $this->params['q1_version'] = $val;
        return $this;
    }

    /**
     * 设置商户ID
     * @param $val
     * @return $this
     */
    public function setMerchantNo($val){
        $this->params['p1_MerchantNo'] = $val;
        return $this;
    }

    /**
     * 设置商户原支付订单号
     * @param $val
     * @return $this
     */
    public function setOrderNo($val){
        $this->params['p2_OrderNo'] = $val;
        return $this;
    }

    /**
     * 设置商户退款订单号
     * @param $val
     * @return $this
     */
    public function setRefundOrderNo($val){
        $this->params['p3_RefundOrderNo'] = $val;
        return $this;
    }

    /**
     * 设置退款金额
     * @param $val
     * @return $this
     */
    public function setRefundAmount($val){
        $this->params['p4_RefundAmount'] = $val;
        return $this;
    }

    /**
     * 设置退款原因描述
     * @param $val
     * @return $this
     */
    public function setRefundReason($val){
        $this->params['p5_RefundReason'] = $val;
        return $this;
    }

    /**
     * 设置服务器异步通知地址
     * @param $val
     * @return $this
     */
    public function setNotifyUrl($val){
        $this->params['p6_NotifyUrl'] = $val;
        return $this;
    }

}