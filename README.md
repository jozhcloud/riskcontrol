## 调用

```php
// 设置项
// 方式一、批量设置
\RiskControl\Handler::set([
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
\RiskControl\Handler::setDbWrite(new ICWebCH_Riskcontrol())
    ->setDbRead(new ICWebCH_Riskcontrol_R())
    ->setAccountId('账户唯一ID');

// 运行风控
\RiskControl\Handler::run();
```

> 数据存储方案：
> <br> 1、文件读、写: 名单固定，不灵活；
> <br> 2、Redis缓存：Redis缓存，灵活，但无法持久化；
> <br> 3、database存储：灵活，且持久化【默认】。

## 数据表
```mysql
-- 客户端统计表
CREATE TABLE `t_riskcontrol_clients`
(
    `F_Id`        int(11)     NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
    `F_Member`    varchar(32) NOT NULL DEFAULT '' COMMENT 'IP或账户ID',
    `F_Factor`    varchar(32) NOT NULL DEFAULT '' COMMENT '名单因素：IP Account',
    `F_Client`    varchar(32) NOT NULL DEFAULT '' COMMENT '客户端唯一标识UA',
    `F_DropFlag`  tinyint(4)  NOT NULL DEFAULT 0 COMMENT '是否删除: 0-正常 1-删除',
    `F_InputDate` datetime    NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '统计时间',
    PRIMARY KEY (`F_Id`) USING BTREE,
    UNIQUE KEY `IX_Riskcontrol_Client_Unique` (`F_Member`, `F_Client`, `F_InputDate`) USING BTREE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  ROW_FORMAT = DYNAMIC COMMENT ='【风控】客户端统计表';

-- IP账户ID统计表
CREATE TABLE `t_riskcontrol_ip_accountid`
(
    `F_Id`        int(11)     NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
    `F_Ip`        varchar(32) NOT NULL DEFAULT '' COMMENT 'IP',
    `F_AccountId` varchar(32) NOT NULL DEFAULT '' COMMENT '账户ID',
    `F_DropFlag`  tinyint(4)  NOT NULL DEFAULT 0 COMMENT '是否删除: 0-正常 1-删除',
    `F_InputDate` datetime             DEFAULT current_timestamp() COMMENT '添加时间',
    PRIMARY KEY (`F_Id`) USING BTREE,
    UNIQUE KEY `IX_Riskcontrol_Ip_AccountId_Unique` (`F_Ip`,`F_AccountId`) USING BTREE,
    KEY `IX_Riskcontrol_Ip_AccountId_AccountId` (`F_AccountId`) USING BTREE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  ROW_FORMAT = DYNAMIC COMMENT ='【风控】IP账户ID统计表';

-- 达标统计表
CREATE TABLE `t_riskcontrol_limits`
(
    `F_Id`         int(11)     NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
    `F_Member`     varchar(32) NOT NULL DEFAULT '' COMMENT 'IP或账户ID对应值',
    `F_Factor`     varchar(32) NOT NULL DEFAULT '' COMMENT '名单因素：IP Account',
    `F_Dimension`  varchar(10) NOT NULL DEFAULT '' COMMENT '统计维度',
    `F_Limit`      int(11)     NOT NULL DEFAULT 0 COMMENT '计数',
    `F_DropFlag`   tinyint(4)  NOT NULL DEFAULT 0 COMMENT '是否删除: 0-正常 1-删除',
    `F_InputDate`  datetime             DEFAULT current_timestamp() COMMENT '添加时间',
    `F_UpdateDate` datetime    NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp() COMMENT '修改时间',
    PRIMARY KEY (`F_Id`) USING BTREE,
    UNIQUE KEY `IX_Riskcontrol_Limits_Unique` (`F_Member`, `F_Dimension`) USING BTREE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  ROW_FORMAT = DYNAMIC COMMENT ='【风控】达标统计表';

-- 名单表
CREATE TABLE `t_riskcontrol_namelist`
(
    `F_Id`         int(11)      NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
    `F_Type`       tinyint(4)   NOT NULL DEFAULT 0 COMMENT '名单类型：1-黑名单 2-灰名单 3-白名单 4-红名单',
    `F_Member`     varchar(32)  NOT NULL DEFAULT '' COMMENT '成员值',
    `F_Factor`     varchar(32)  NOT NULL DEFAULT '' COMMENT '名单因素：IP Account',
    `F_Reason`     varchar(255) NOT NULL DEFAULT '' COMMENT '进入名单原因',
    `F_Dimension`  varchar(30)  NOT NULL DEFAULT '' COMMENT '触发维度',
    `F_Operator`   varchar(10)  NOT NULL DEFAULT 'system' COMMENT '操作人员',
    `F_DropFlag`   tinyint(4)   NOT NULL DEFAULT 0 COMMENT '是否删除: 0-正常 1-删除',
    `F_InputDate`  datetime              DEFAULT current_timestamp() COMMENT '添加时间',
    `F_ExpireDate` datetime              DEFAULT NULL COMMENT '名单过期时间',
    PRIMARY KEY (`F_Id`) USING BTREE,
    KEY `IX_Riskcontrol_Namelist_Type` (`F_Type`,`F_Member`) USING BTREE,
    KEY `IX_Riskcontrol_Namelist_Factor` (`F_Factor`) USING BTREE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  ROW_FORMAT = DYNAMIC COMMENT ='【风控】名单表';

-- 脚本统计表
CREATE TABLE `t_riskcontrol_scripts`
(
    `F_Id`        int(11)     NOT NULL AUTO_INCREMENT COMMENT '主键自增ID',
    `F_Type`      varchar(10) NOT NULL DEFAULT '' COMMENT '受访页面类型：Category List',
    `F_Member`    varchar(32) NOT NULL DEFAULT '' COMMENT 'IP或账户ID对应值',
    `F_Factor`    varchar(32) NOT NULL DEFAULT '' COMMENT '名单因素：IP Account',
    `F_Count`     int(11)     NOT NULL DEFAULT 0 COMMENT '计数',
    `F_DropFlag`  tinyint(4)  NOT NULL DEFAULT 0 COMMENT '是否删除: 0-正常 1-删除',
    `F_InputDate` datetime    NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '统计时间',
    PRIMARY KEY (`F_Id`) USING BTREE,
    UNIQUE KEY `IX_Riskcontrol_Script_Unique` (`F_Type`, `F_Member`, `F_InputDate`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  ROW_FORMAT = DYNAMIC COMMENT ='【风控】脚本统计表';
```
