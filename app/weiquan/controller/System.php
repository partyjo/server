<?php
namespace app\weiquan\controller;
use think\Db;

class System extends Base
{
    public function before()
	{
		$this->db = Db::name('system');
    }
    
    public function add()
    {   
        $params = input('');

        return $this->ajax($this->data);
    }

    public function update()
    {
        $params = input('');
        $params['update_time'] = $this->now();

        if (!isset($params['id']) || empty($params['id'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '对象不存在';
            return $this->ajax($this->data);
        }

        $this->data['data'] = $this->db->update($params);
        return $this->ajax($this->data);
    }

    public function delete()
    {
        $params = input('');
        
        return $this->ajax($this->data);
    }

    public function get()
    {
        $params = input('');

        if (!isset($params['id']) || empty($params['id'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '对象不存在';
            return $this->ajax($this->data);
        }

        $map = [
            'id' => $params['id']
        ];

        $res = $this->db->where($map) ->find();
        if (!$res) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '对象不存在';
        } else {
            $this->data['data'] = $res;
        }
        
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