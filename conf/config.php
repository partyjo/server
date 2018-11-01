<?php
$debug = \think\Env::get('debug');

return [
	// 应用调试模式
    'app_debug'              => $debug,

    // 应用Trace
    'app_trace'              => $debug,

    // 开启路由
    'url_route_on'           => false,

    // 视图输出字符串内容替换
    'view_replace_str' => [
    	'__PUBLIC__' => '/public'
	],
];