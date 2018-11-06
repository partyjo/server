<?php
namespace app\dingding\controller;
use think\Controller;

class Base extends Controller
{
    protected $robots = [
        'test' => 'https://oapi.dingtalk.com/robot/send?access_token=414a12eedc560c85d1dccb21e359a138d9ca6398b79f3ff5efd2bcc2452c75ac'
    ];

    protected function _initialize()
    {
        $this->before();
    }

    /**
     * 前置操作
     */
    protected function before()
    {

    }

    /**
     * ajax返回
     */
    protected function ajax($data) 
    {
        if ($data['code'] == 1001) {
            $data['msg'] = '参数异常';
        }
        if ($data['code'] == 2001) {
            $data['msg'] = '服务器异常';
        }
        if ($data['code'] == 3001) {
            $data['msg'] = '不存在的资源';
        }
        if ($data['code'] == 9999) {
            $data['msg'] = '没有登陆';
        }
        return json($data);
    }

    /**
     * 当前时间
     */
    protected function now() 
    {
        return date('Y-m-d h:i:s', time());
    }

    /**
     * 创建guid
     */
    protected function createGuid() 
    {
        return guid();
    }

    protected function http_curl($url, $data)
    {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)'); // 模拟用户使用的浏览器
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        //curl_setopt($curl, CURLOPT_AUTOREFERER, 1);    // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1);             // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);   // Post提交的数据包x
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);         // 设置超时限制 防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0);           // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   // 获取的信息以文件流的形式返回

        $tmpInfo = curl_exec($curl); // 执行操作
        if(curl_errno($curl)) {
            $tmpInfo = 'Errno'.curl_error($curl);
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }
}