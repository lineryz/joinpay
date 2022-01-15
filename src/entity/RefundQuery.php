<?php


namespace joinpay\entity;


use joinpay\JoinPayClient;
use joinpay\service\JoinPayRequest;

class RefundQuery extends JoinPayRequest
{
    protected $uri = 'https://www.joinpay.com/trade/queryRefund.action';

    protected $method = 'POST';

    public function __construct($data=[])
    {
        parent::__construct($data);
        $this->params['p1_MerchantNo'] = JoinPayClient::getInstance()->app_id;
    }

    /**
     * 设置当前版本号
     * @param $val
     * @return $this
     */
    public function setVerison($val)
    {
        $this->params['p3_Version'] = $val;
        return $this;
    }

    /**
     * 设置商户退款订单号
     * @param $val
     * @return $this
     */
    public function setRefundOrderNo($val)
    {
        $this->params['p2_RefundOrderNo'] = $val;
        return $this;
    }
}