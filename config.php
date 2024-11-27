<?php

// 脚本聚类规则

// ['聚类名称' => ['script' => ['脚本名称'], 'route' => ['路由标识']], ...]*/
// 1、脚本匹配到多组聚类规则时，采用最先原则
// 2、聚类规则，route与script至少设置一个组，同时存在时，script优先级高于route。
// 3、路由标识，比如：/mall/-商城 /shop/-店铺。
// 4、脚本名称，比如：index.php-首页 list.php-列表页。
$args_script_cluster_config = [ // 默认 Normal
	'List' => [
		'script' => [
			'products.php', // 产品列表
			'samples.php', // 样品列表
			'search.php', // 搜索产品
			'shop_index.php', // 店铺首页
			'shop_products.php', // 店铺产品列表
			'supplier.php', // 供应商列表
			'tickets.php', // 优惠券列表
			'selection.php', // 器件选型列表
		],
	],
	'Category' => [
		'script' => [
			'category.php' => 'Category', // 产品分类
		]
	],
	'Api' => [
		'match' => [
			'/async/'
		]
	]
];

// 脚本风控维度
$args_script_dimension_config = [
	'Account' => [
		'Category' => [ // 账户访问聚合页脚本数量（频繁请求脚本）
			'Minute' => [
				'period' => '1分钟', // 周期
				'expire' => 60, // 计时 1分钟
				'count' => 30, // 数量 >=30个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => -5, // 灰名单自动恢复的计时（负数时，将成{limit}倍增长。）
				'limit' => 5 // 计数 满足时则进入黑名单
			],
			'15Minute' => [
				'period' => '15分钟', // 周期
				'expire' => 900, // 计时 15分钟
				'count' => 400, // 数量 ≈26个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => 3600, // 灰名单自动恢复的计时（1小时）
				'limit' => 3 // 计数 满足时则进入黑名单
			],
			'Hour' => [
				'period' => '1小时', // 周期
				'expire' => 3600, // 计时 1小时
				'count' => 1500, // 数量 ≈25个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => 18000, // 灰名单自动恢复的计时（5个小时）
				'limit' => 2 // 计数 满足时则进入黑名单
			],
			'24Hour' => [
				'period' => '24小时', // 周期
				'expire' => 86400, // 计时 24小时
				'count' => 35000, // 数量 ≈24个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => 0, // 灰名单自动恢复的计时（不恢复）
				'limit' => 1 // 计数 满足时则进入黑名单
			]
		],
		'List' => [ // 账户访问列表页脚本数量（频繁请求脚本）
			'Minute' => [
				'period' => '1分钟', // 周期
				'expire' => 60, // 计时 1分钟
				'count' => 30, // 数量 >=30个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => -5, // 灰名单自动恢复的计时（负数时，将成{limit}倍增长。）
				'limit' => 5 // 计数 满足时则进入黑名单
			],
			'15Minute' => [
				'period' => '15分钟', // 周期
				'expire' => 900, // 计时 15分钟
				'count' => 400, // 数量 ≈26个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => 3600, // 灰名单自动恢复的计时（1小时）
				'limit' => 3 // 计数 满足时则进入黑名单
			],
			'Hour' => [
				'period' => '1小时', // 周期
				'expire' => 3600, // 计时 1小时
				'count' => 1500, // 数量 ≈25个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => 18000, // 灰名单自动恢复的计时（5个小时）
				'limit' => 2 // 计数 满足时则进入黑名单
			],
			'24Hour' => [
				'period' => '24小时', // 周期
				'expire' => 86400, // 计时 24小时
				'count' => 35000, // 数量 ≈24个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => 0, // 灰名单自动恢复的计时（不恢复）
				'limit' => 1 // 计数 满足时则进入黑名单
			]
		]
	], // 自定义账号账户访问脚本统计
	'IP' => [
		'Category' => [ // IP访问聚合页脚本数量（频繁请求脚本）
			'Minute' => [
				'period' => '1分钟', // 周期
				'expire' => 60, // 计时 1分钟
				'count' => 30, // 数量 >=30个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => -5, // 灰名单自动恢复的计时（负数时，将成{limit}倍增长。）
				'limit' => 5 // 计数 满足时则进入黑名单
			],
			'15Minute' => [
				'period' => '15分钟', // 周期
				'expire' => 900, // 计时 15分钟
				'count' => 400, // 数量 ≈26个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => 3600, // 灰名单自动恢复的计时（1小时）
				'limit' => 3 // 计数 满足时则进入黑名单
			],
			'Hour' => [
				'period' => '1小时', // 周期
				'expire' => 3600, // 计时 1小时
				'count' => 1500, // 数量 ≈25个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => 18000, // 灰名单自动恢复的计时（5个小时）
				'limit' => 2 // 计数 满足时则进入黑名单
			],
			'24Hour' => [
				'period' => '24小时', // 周期
				'expire' => 86400, // 计时 24小时
				'count' => 35000, // 数量 ≈24个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => 0, // 灰名单自动恢复的计时（不恢复）
				'limit' => 1 // 计数 满足时则进入黑名单
			]
		],
		'List' => [ // IP访问列表页脚本数量（频繁请求脚本）
			'Minute' => [
				'period' => '1分钟', // 周期
				'expire' => 60, // 计时 1分钟
				'count' => 30, // 数量 >=30个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => -5, // 灰名单自动恢复的计时（负数时，将成{limit}倍增长。）
				'limit' => 5 // 计数 满足时则进入黑名单
			],
			'15Minute' => [
				'period' => '15分钟', // 周期
				'expire' => 900, // 计时 15分钟
				'count' => 400, // 数量 ≈26个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => 3600, // 灰名单自动恢复的计时（1小时）
				'limit' => 3 // 计数 满足时则进入黑名单
			],
			'Hour' => [
				'period' => '1小时', // 周期
				'expire' => 3600, // 计时 1小时
				'count' => 1500, // 数量 ≈25个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => 18000, // 灰名单自动恢复的计时（5个小时）
				'limit' => 2 // 计数 满足时则进入黑名单
			],
			'24Hour' => [
				'period' => '24小时', // 周期
				'expire' => 86400, // 计时 24小时
				'count' => 35000, // 数量 ≈24个/分钟 满足时进入灰名单，周期结束重新统计
				'restore' => 0, // 灰名单自动恢复的计时（不恢复）
				'limit' => 1 // 计数 满足时则进入黑名单
			]
		]
	] // 自定义IP访问脚本统计
];

// 客户端风控维度
$args_client_dimension_config = [
	'IP' => [
		'Minute' => [
			'period' => '1分钟', // 周期
			'expire' => 60, // 计时 1分钟
			'count' => 30, // 数量 >=30个/分钟 满足时进入灰名单，周期结束重新统计
			'restore' => -5, // 灰名单自动恢复的计时（负数时，将成{limit}倍增长。）
			'limit' => 5 // 计数 满足时则进入黑名单
		],
		'15Minute' => [
			'period' => '15分钟', // 周期
			'expire' => 900, // 计时 15分钟
			'count' => 400, // 数量 ≈26个/分钟 满足时进入灰名单，周期结束重新统计
			'restore' => 3600, // 灰名单自动恢复的计时（1小时）
			'limit' => 3 // 计数 满足时则进入黑名单
		],
		'Hour' => [
			'period' => '1小时', // 周期
			'expire' => 3600, // 计时 1小时
			'count' => 1500, // 数量 ≈25个/分钟 满足时进入灰名单，周期结束重新统计
			'restore' => 18000, // 灰名单自动恢复的计时（5个小时）
			'limit' => 2 // 计数 满足时则进入黑名单
		],
		'24Hour' => [
			'period' => '24小时', // 周期
			'expire' => 86400, // 计时 24小时
			'count' => 35000, // 数量 ≈24个/分钟 满足时进入灰名单，周期结束重新统计
			'restore' => 0, // 灰名单自动恢复的计时（不恢复）
			'limit' => 1 // 计数 满足时则进入黑名单
		]
	]
];

// 忽略脚本列表
$args_script_ignore_list = [
	// page
	'GET /test.php',
	'GET /index.php',
	'GET /mall/login.php',
	
	// api
	'POST /async/mall/accounts.asy.php?ICWebCH_Method=login',
	'POST /async/mall/accounts.asy.php?ICWebCH_Method=loginOut',
	'POST /async/mall/accounts.asy.php?ICWebCH_Method=authsBinding',
];