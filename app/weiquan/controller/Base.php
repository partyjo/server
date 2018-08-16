<?php
namespace app\weiquan\controller;
use think\Controller;
use think\Request;
use think\Db;

class Base extends Controller
{
    protected $data = [
        'code' => 0,
        'msg' => '操作成功',
        'data' => null
    ];

    protected $user = [];

    protected function _initialize()
    {
        //$this->user['web_info'] = $this->getWebInfo();
        
        if ($this->auth()) {
            
        }
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
        if ($data['code'] == 2001) {
            $data['msg'] = '服务器异常';
        }
        if ($data['code'] == 3001) {
            $data['msg'] = '不存在的资源';
        }
        return json($data);
    }

    /**
     * 权限验证
     */
    protected function auth() 
    {
        $request = Request::instance();
        $this->request = [
            'host' => $request->domain().'/server',
            'pathname' => $request->module().'/'.$request->controller().'/'.$request->action()
        ];
        return false;
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

    protected function getLoginInfo()
    {
        return [
            'name' => 'zhangmin'
        ];
    }

    protected function getWebInfo()
    {
        return [
            'id' => 'C4C54850-46A1-BE67-14E5-79D1AF46FC48'
        ];
    }
}