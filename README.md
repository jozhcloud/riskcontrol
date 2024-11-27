## 调用

```php
// 批量设置
RiskControl::set([
    'ServiceFlag' => true, // 服务开关，true-开启 false-关闭【默认】
    'DebugFlag' => true, // 调试开关，true-开启 false-关闭【默认】
    'DbWrite' => new RiskcontrolWriteModel(), // 数据库写操作对象
    'DbRead' => new RiskcontrolReadModel(), // 数据库读操作对象
    'AccountId' => '账户唯一ID', // 账户唯一ID值
    'DataSourceType' => '2', // 数据存储方案，可选值：1-文件，2-Redis缓存【默认】，3-Database存储
    'RedisKeyPrefix' => 'Riskcontrol:', // Redis存储方案时，指定KEY前缀，默认【RiskControl:】
    'AvoidRiskcontrolFlag' => true, // 避开风控开关，true-开启红名单 false-关闭【默认】
    'ForbiddenPage' => 'xx', // 风控跳转页面链接，缺省时403报错
])->run();

// 方式二、单项设置
RiskControl::setServiceFlag(true)
    ->setDbWrite(new RiskcontrolWriteModel())
    ->setDbRead(new RiskcontrolReadModel())
    ->setAccountId('账户唯一ID')
    ->run();
```