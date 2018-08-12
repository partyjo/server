<?php
namespace app\weiquan\controller;
use think\Db;

class Forms extends Base
{
    public function before()
	{
		$this->db = Db::name('forms');
    }
    
    public function add()
    {   
        $params = input('');

        if (!isset($params['pid']) || !isset($params['cid'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '缺失类别';
            return $this->ajax($this->data);
        }
        if (!isset($params['name'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '姓名不能为空';
            return $this->ajax($this->data);
        }
        if (!isset($params['mobile']) || strlen($params['mobile']) !== 11) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '手机号格式不正确';
            return $this->ajax($this->data);
        }
        if (!isset($params['needs'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '诉求不能为空';
            return $this->ajax($this->data);
        }

        $params['categorys'] = $params['pid'].','.$params['cid'];
        $params['create_time'] = $this->now();
        $params['update_time'] = $this->now();

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