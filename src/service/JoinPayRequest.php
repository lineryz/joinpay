<?php
/**
 * ---------------------------------------------------------------------------------------------------------------------
 * FileName: JoinPayRequest.php
 * Description:
 * ---------------------------------------------------------------------------------------------------------------------
 * Author: lineryz <lineryz@126.com>
 * Date:    2022/1/11
 * Version: 1.0
 */

namespace joinpay\service;


use joinpay\JoinPayClient;

abstract class JoinPayRequest
{

    protected $params   = [];
    protected $method   = '';
    protected $uri      = '';
    protected $signType = 'MD5';
    protected $signFiled= 'hmac';

    public function __construct($data=[])
    {
        $this->params = $data;
    }

    /**
     * 设置单个参数
     * @param $field
     * @param $value
     * @return $this
     */
    public function setParam($field,$value): JoinPayRequest
    {
        $this->params[$field] = $value;
        return $this;
    }

    /**
     * 设置多个参数
     * @param $data
     * @return $this
     */
    public function setParams($data){
        $this->params = $data;
        return $this;
    }

    /**
     * 获取单个参数
     * @param $field
     * @return mixed
     */
    public function getParam($field){
        return $this->params[$field];
    }

    /**
     * 获取多个参数
     * @return array|mixed
     */
    public function getParams(){
        return $this->params;
    }

    /**
     * 发送
     * @param false $isJsonRequest 是否http body Json请求
     * @param false $is_form_request 是否表单提交跳转
     * @return mixed|string
     */
    public function send($isJsonRequest=false,$is_form_request=false){
        return JoinPayClient::getInstance()->setSignType($this->signType)->setSignField($this->signFiled)->send($this->uri,$this->params,$this->method,$isJsonRequest,$is_form_request);
    }
}
