<?php
/**
 * ---------------------------------------------------------------------------------------------------------------------
 * FileName: JoinPayClient.php
 * Description: 汇聚支付客户端类
 * ---------------------------------------------------------------------------------------------------------------------
 * Author: lineryz <lineryz@126.com>
 * Date:    2022/1/11
 * Version: 1.0
 */

namespace joinpay;

use GuzzleHttp\Exception\InvalidArgumentException;
use joinpay\service\JoinPayFactoryInterface;
use joinpay\util\RSAUtil;

class JoinPayClient implements JoinPayFactoryInterface
{
    public $app_id;
    public $app_trade_merchantNo;
    protected $app_private_key;
    protected $app_secret;
    private static $instance;
    private $signType = 'MD5';
    private $signFiled= 'hmac';
    // The array of created "entity".
    protected $requests = [];

    /**
     * 默认封装提供的接口封装
     * @var string[]
     */
    protected $defaultDriver = [
        'unipay'                   => 'UniPay',
        'orderquery'               => 'OrderQuery',
        'refund'                   => 'Refund',
        'refundquery'              => 'RefundQuery'
    ];

    private function __construct(array $config = []){
        $this->setConfig($config);
    }

    /**
     * 获取实例
     * @param array $config
     * @return JoinPayClient
     */
    public static function getInstance( $config = [])
    {
        if(is_null(self::$instance)){
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    /**
     * 实体类驱动
     * @param $driver
     * @return mixed
     */
    public function driver($driver)
    {
        $driver = strtolower($driver);
        if (!isset($this->requests[$driver])) {
            $this->requests[$driver] = $this->createRequest($driver);
        }
        return $this->requests[$driver];
    }

    /**
     * 创建请求对象
     * @param $driver
     * @return mixed
     */
    private function createRequest($driver){

        if(!isset($this->defaultDriver[$driver])){
            throw new InvalidArgumentException("Driver [$driver] not supported.");
        }

        $request = $this->defaultDriver[$driver];
        $request = __NAMESPACE__.'\\entity\\'.$request;
        return new $request();
    }

    /**
     * 设置签名类型
     * @param string $val
     * @return $this
     */
    public function setSignType(string $val){
        $this->signType = $val;
        return $this;
    }

    /**
     * 设置签名字段
     * @param string $val
     * @return $this
     */
    public function setSignField(string $val){
        $this->signFiled = $val;
        return $this;
    }

    /**
     * build request sign
     * @param $params
     * @param string $signType
     * @return bool|string
     */
    function buildSign($params,$signType='MD5'){
        ksort($params,2);
        if(strtoupper($signType) == 'MD5'){
            return md5(implode("",$params).$this->app_secret);
        }else{
            return RSAUtil::sign(implode("",$params),$this->app_private_key);
        }
    }

    /**
     * @param $uri
     * @param $param
     * @param $method
     * @param false $isJsonRequest
     * @param false $is_form_request
     * @return mixed|string
     * @throws \HttpException
     */
    public function send($uri,$param,$method,$isJsonRequest=false,$is_form_request=false){
        $param[$this->signFiled] = $this->buildSign($param,$this->signType);
        if($is_form_request){
            return $this->HttpFormRequest($uri,$param,$method);
        }else{
            return $this->requestGateway($uri,$param,$method,$isJsonRequest);
        }
    }

    /**
     * Encapsulate requests based on GuzzleHttp
     * @param $uri
     * @param $params
     * @param string $method
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \HttpException
     */
    private function requestGateway($uri,$params,$method='GET',$isJsonRequest=false){

        $client = new \GuzzleHttp\Client();
        switch ($method){
            case 'POST':
                $respone = $isJsonRequest ? $client->post($uri,['headers'=>[
                    'Content-type'  => "application/json;charset='utf-8'",
                    'Accept'        => 'application/json'
                ],'form_params'=>$params]) : $client->post($uri,['form_params'=>$params]);
                break;
            default:
                $respone = $client->get($uri,['query'=>$params]);
        }

        try {
            $respone = $respone->getBody();
            $jsonReq = json_decode($respone,true);
            return (!is_null($jsonReq) && !empty($jsonReq)) ? $jsonReq : $respone;
        }catch (\Exception $e){
            throw new \HttpException($e->getMessage(),$e->getCode());
        }
    }

    /**
     * 构建FORM表单提交数据跳转
     * @param $uri
     * @param $params
     * @param string $method
     * @return string
     */
    private function HttpFormRequest($uri,$params,$method="GET")
    {
        $html = "<form style='display:none' name='toPay' action='" . $uri. "' method='".$method."'>\r";
        foreach ($params as $key => $val){
            $html .= "<input type='hidden' name='".$key."' value='" . $val. "'>\r";
        }
        $html .= "</form>";
        $html .= "<script>document.forms['toPay'].submit();</script>";
        return $html;
    }

    /**
     * 设置接口请求配置信息
     * @param $config
     */
    private function setConfig($config){
        $joinpayConfig = require_once __DIR__.'/config/config.php';
        $config = (is_array($config) && !empty($config)) ? array_merge($joinpayConfig,$config) : $joinpayConfig;
        $this->app_id               = $config['app_id'] ?? '';
        $this->app_secret           = $config['app_secret'] ?? '';
        $this->app_trade_merchantNo = $config['trade_merchantNo'] ?? '';
        $this->app_private_key      = $config['private_key'] ?? '';
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

}