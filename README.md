# joinpay

汇聚支付类库插件

### 声明

这个是个人集成的汇聚支付PHP dome请注意：

- 1.非官方提供，非官方提供，非官方提供
- 2.如有不可请参照汇聚支付官网dome进行修改
- 3.如有问题可向 [lineryz@126.com](mailto:lineryz@126.com) 发送邮件提出问题
- 4.代码仅作参考，使用请谨慎，出问题本人不负责

### 安装

```
composer require lineryz/joinpay
```

### 用法

参数格式以官方为准：https://www.joinpay.com/open-platform/pages/document.html?apiName=%E8%81%9A%E5%90%88%E6%94%AF%E4%BB%98&id=6

##### 汇聚支付实例化

```
use joinpay\JoinPayClient;
$config = [
	// 商户ID
    'app_id'            => '',
    // 商户加密密钥
    'app_secret'        => '',
    // 商户私钥
    'private_key'       => '',
    // 报备商户号
    'trade_merchantNo'  => '',
];
$joinPayClient = JoinPayClient::getInstance($config);
```

##### 订单支付

```
$joinPayClient = $joinPayClient->driver('UniPay');// 使用驱动方式重新构造订单支付

  $joinPayClient->setVerison('1.0')// 版本号
                ->setMerchantNo('')// 商户号 === 商户ID
                ->setOrderNo('')// 
                ->setAmount()
                ->setProductName()
                ->setProductDesc()
                ->setMp()
                ->setNotifyUrl()
                ->setFrpCode()
                ->setMerchantBankCode()
                ->setIsShowPic()
                ->setOpenId()
                ->setAuthCode()
                ->setAppId()
                ->setTerminalNo()
                ->setTransactionModel()
                ->setTradeMerchantNo()
                ->setBuyerId()
                ->setDisablePayModel()
                ->send();
```

##### 订单查询

```
$joinPayClient = $joinPayClient->driver('OrderQuery');// 使用驱动方式重新构造订单查询

  $joinPayClient->setOrderNo() // 订单号
                ->send();
```

##### 退款

```
$joinPayClient = $joinPayClient->driver('Refund');// 使用驱动方式重新构造退款

  $joinPayClient->setVerison('1.0')// 版本号
                ->setMerchantNo('')// 商户号 === 商户ID
                ->setOrderNo('') // 原支付订单号
                ->setRefundOrderNo() // 退款订单号
                ->setRefundAmount() // 退款金额
                ->setRefundReason() // 退款原因
                ->setNotifyUrl() // 服务器异步通知地址
                ->send();
```

##### 退款查询

```
$joinPayClient = $joinPayClient->driver('RefundQuery');// 使用驱动方式重新构造退款查询

  $joinPayClient->setVerison('1.0')// 版本号
  				->setRefundOrderNo() // 退款订单号
                ->send();
```



### 特别鸣谢

排名不分先后，感谢这些插件的开发者： @jackven <jackven@qq.com>    @yijin <uyijin@gmail.com>** 等，如有遗漏请联系我！