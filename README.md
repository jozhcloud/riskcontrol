## 调用

```php
// 设置项
// 方式一、批量设置
RiskControl::set([
    'ServiceFlag' => true, // 服务开关，true-开启 false-关闭【默认】
    'DebugFlag' => true, // 调试开关，true-开启 false-关闭【默认】
    'DbWrite' => new ICWebCH_Riskcontrol(), // 数据库写操作对象
    'DbRead' => new ICWebCH_Riskcontrol_R(), // 数据库读操作对象
    'AccountId' => '账户唯一ID', // 账户唯一ID值
    'DataSourceType' => '2', // 数据存储方案
    'RedisKeyPrefix' => 'ICWebCH:Riskcontrol:', // Redis存储方案时，指定KEY前缀，默认[RiskControl:]
    'AvoidRiskcontrolFlag' => true, // 避开风控开关，true-开启红名单 false-关闭【默认】
    'ForbiddenPage' => 'xx', // 风控异常页面，链接中需要包含‘forbidden’字符串，默认403错误页
]);

// 方式二、单项设置
RiskControl::setDbWrite(new ICWebCH_Riskcontrol())
    ->setDbRead(new ICWebCH_Riskcontrol_R())
    ->setAccountId('账户唯一ID');

// 运行风控
RiskControl::run();
```