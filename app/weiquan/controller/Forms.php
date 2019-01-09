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
        if (!isset($params['name']) || empty($params['name'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '姓名不能为空';
            return $this->ajax($this->data);
        }
        if (!isset($params['mobile']) || strlen($params['mobile']) !== 11) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '手机号格式不正确';
            return $this->ajax($this->data);
        }
        if (!isset($params['needs']) || empty($params['name'])) {
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
        $this->db->update(input());
        return $this->ajax($this->data);
    }

    public function delete()
    {
        $params = input('');
        $params['delete_time'] = $this->now();
        $params['status'] = 0;

        if (!isset($params['id']) || empty($params['id'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '删除对象不存在';
            return $this->ajax($this->data);
        }

        $this->data['data'] = $this->db->update($params);
        return $this->ajax($this->data);
    }

    public function get()
    {
        return $this->ajax($this->data);
    }

    public function page()
    {
        $params = input('');

        if (!isset($params['pid']) || empty($params['pid'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '缺失类别';
            return $this->ajax($this->data);
        }
        if (!isset($params['pageIndex']) || empty($params['pageIndex'])) {
            $params['pageIndex'] = 1;
        }
        if (!isset($params['pageSize']) || empty($params['pageSize'])) {
            $params['pageSize'] = 10;
        }
        if (!isset($params['order']) || empty($params['order'])) {
            $params['order'] = 'create_time desc';
        }

        $map['status'] = 1;
        $map['pid'] = $params['pid'];
        
        $db = $this->db;
        $this->data['count'] = $db->where($map)->count();
        $this->data['data'] = $db->where($map)->order($params['order'])->page($params['pageIndex'],$params['pageSize'])->select();
        return $this->ajax($this->data);
    }

    public function all()
    {
        return $this->ajax($this->data);
    }
}