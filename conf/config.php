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
    
    'nqxt' => [
        'token'=>'djgrpqgxoev4kenryql2xnalpj31xwbe', //填写你设定的key
        'encodingaeskey'=>'kNGLqvw7lAckfUsVSkvJBlmXcSYDNLILOlPtRdDg4VC', //填写加密用的EncodingAESKey
        'appid' => 'wxa9b18677de60a048',
        'appsecret' => 'acb26db5498cefae8932d8f5925f7626'
    ],

    'nqds' => [
        'token'=>'djgrpqgxoev4kenryql2xnalpj31xwbe', //填写你设定的key
        'encodingaeskey'=>'kNGLqvw7lAckfUsVSkvJBlmXcSYDNLILOlPtRdDg4VC', //填写加密用的EncodingAESKey
        'appid'=>'wxe2e80045b50b330b', //填写高级调用功能的app id
        'appsecret'=>'66731dceab7e363c43057d31123428c4'
    ]
];