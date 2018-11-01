<?php
namespace app\niuqi\controller;
use think\Db;

class Guess extends Base
{
    public function before()
	{
		$this->db = Db::name('nq_guess');
    }
    
    public function add()
    {   
        $params = input('');

        if (!isset($params['openid']) || !isset($params['nickname']) || !isset($params['headimgurl'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '您还没有登录';
            return $this->ajax($this->data);
        }

        if (!isset($params['mobile']) || strlen($params['mobile']) !== 11) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '手机号格式不正确';
            return $this->ajax($this->data);
        }
        if (!isset($params['amount']) || empty($params['amount'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '竞猜金额不能为空';
            return $this->ajax($this->data);
        }

        $params['create_time'] = $this->now();

        $id = $this->db->insert($params);
        if (!$id) {
            $this->data['code'] = 2001;
            return $this->ajax($this->data);
        }
        
        $this->data['data'] = $this->db->where('id',$id)->find();
        return $this->ajax($this->data);
    }

    public function update()
    {
        return $this->ajax($this->data);
    }

    public function delete()
    {
        return $this->ajax($this->data);
    }

    public function get()
    {
        $params = input('');

        if (!isset($params['openid']) || empty($params['openid'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '用户不存在';
            return $this->ajax($this->data);
        }

        $map['openid'] = $params['openid'];
        
        $db = $this->db;
        $this->data['data'] = $db->where($map)->find();
        return $this->ajax($this->data);
    }

    public function page()
    {
        return $this->ajax($this->data);
    }

    public function all()
    {
        return $this->ajax($this->data);
    }
}