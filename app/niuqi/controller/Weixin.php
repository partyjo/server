<?php
namespace app\niuqi\controller;
use wechatsdk\wechat;
use wechatsdk\wechatjs;
use think\Db;

class Weixin extends Base
{
    protected $wxconfig;

    protected function before()
    {
        $this->wxconfig = config('nqxt');
    }

    public function index()
    {
        echo "hello weixin";
    }


    // 清理授权缓存
    public function clear()
    {
        $token = $this->getToken();
        if ($token) {
            $db = Db::name('nq_guess');
            $db->where(['openid' => $token['openid']])->delete();
        }
        session('NQ_OAUTH_INFO',null);
        $this->data['msg'] = '清除成功...';
        return $this->ajax($this->data);
    }

    public function isLoginTest($url) {
        //获取授权用户信息
        $token = [
            'openid' => '123456',
            'nickname' => 'zhangmin',
            'headimgurl' => 'http://cdn.duitang.com/uploads/item/201408/28/20140828142218_PS4fi.thumb.700_0.png'
        ];
        // $token = false;
        if ($token !== false) {
            $this->data['data'] = $token;
            return $this->ajax($this->data);
        }

        $this->data['code'] = 9999;
        $this->data['data'] = 'http://partyjo.nextdog.cc/server/niuqi/weixin/wxOauthBackTest?url='.$url;
        return $this->ajax($this->data);
    }

    // 微信授权回调地址
    public function wxOauthBackTest($url)
    {
        //获取授权用户信息
        $token = [
            'openid' => '123456',
            'nickname' => 'zhangmin',
            'headimgurl' => 'http://cdn.duitang.com/uploads/item/201408/28/20140828142218_PS4fi.thumb.700_0.png'
        ];
        //session用户信息
        if ($token !== false){
            $this->setToken($token);
        }

        return $this->redirect($url);
    }

    public function isLogin($url) {
        //获取授权用户信息
        $token = $this->getToken();
        if ($token) {
            $this->setToken($token);
            $this->data['data'] = $token;
            return $this->ajax($this->data);
        }

        $this->data['code'] = 9999;
        $this->data['data'] = $this->getOauthUrl($url);
        return $this->ajax($this->data);
    }

    // 微信授权地址
    public function getOauthUrl($url)
    {
        $weObj = new Wechat($this->wxconfig);
        $wxOauthUrl = 'http://partyjo.nextdog.cc/server/niuqi/weixin/wxoauthback?url='.$url;
        return $weObj->getOauthRedirect($wxOauthUrl,'niuqi');
    }

    // 微信授权回调地址
    public function wxOauthBack($url)
    {
        //获取授权用户信息
        $token = $this->getWxUserInfo($this->wxconfig);
        //session用户信息
        if ($token !== false){
            $this->setToken($token);
        }

        return $this->redirect($url);
    }

    // 注册微信jssdk
    public function getWxsdk($url)
    {
        //实例化微信sdk类
        $WechatJs = new Wechatjs($this->wxconfig['appid'],$this->wxconfig['appsecret'],$url, 'niu_');
        //获取注册信息
        $json = $WechatJs->getSignPackage();
        if ($json !== false){
            $this->data['data'] = $json;
            return $this->ajax($this->data);
        }
        $this->data['code'] = 1001;
        return $this->ajax($this->data);
    }

    // 获取授权用户信息
    protected function getWxUserInfo()
    {
        //1.实例化微信类

        $weObj = new Wechat($this->wxconfig);
        //2.获取access_token
        $json = $weObj->getOauthAccessToken();
        if ($json !== false){
            $accessToken = $json['access_token'];
            //3.获取用户openid
            $openid = $json['openid'];
            //4.获取用户信息
            $userinfo = $weObj->getOauthUserinfo($accessToken,$openid);
            if ($userinfo !== false){
                return $userinfo;
            }
        }
        return false;
    }

    // 缓存授权信息
    protected function setToken($token)
    {
        session('NQ_OAUTH_INFO',$token);
    }

    protected function getToken()
    {
        return session('NQ_OAUTH_INFO');
    }

}
