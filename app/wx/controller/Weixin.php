<?php
namespace app\wx\controller;
//use think\Controller;
use wechatsdk\wechat;
use wechatsdk\wechatjs;

class Weixin extends Base
{
    protected $wxconfig;

    protected function before()
    {
        $this->wxconfig = config('wxconfig_nanhu');
    }


    // 清理授权缓存
    public function clear()
    {
        dump($this->url['HTTP_HOST'].$this->url['ROOT']);
        session('ZM_USER_INFO',null);
        session('ZM_WX_OAUTH_INFO',null);
    }

    // 微信授权地址
    public function getOauthUrl($url){

        $weObj = new Wechat($this->wxconfig);
        $wxOauthUrl = 'http://'.$this->url['HTTP_HOST'].$this->url['ROOT'].'/weixin/wxoauthback?url='.$url;
        return $weObj->getOauthRedirect($wxOauthUrl,'zhangmin');
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
        $WechatJs = new Wechatjs($this->wxconfig['appid'],$this->wxconfig['appsecret'],$url);
        //获取注册信息
        $json = $WechatJs->getSignPackage();
        if ($json !== false){
            return $json;
        }
        return false;
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
        return session('ZM_WX_OAUTH_INFO',$token);
    }

}
