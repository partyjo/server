<?php
namespace app\wx\controller;
use think\Db;

class Article extends Base
{
    public function before()
	{
		$this->db = Db::name('article');
    }
    
    public function add()
    {   
        $params = input('');

        if (!isset($params['cid']) || empty($params['cid'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '缺失类别';
            return $this->ajax($this->data);
        }
        if (!isset($params['title']) || empty($params['title'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '标题不能为空';
            return $this->ajax($this->data);
        }
        if (!isset($params['content']) || empty($params['content'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '诉求不能为空';
            return $this->ajax($this->data);
        }
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
        $params = input('');

        if (!isset($params['id']) || empty($params['id'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '对象不存在';
            return $this->ajax($this->data);
        }

        $map = [
            'id' => $params['id'],
            'status' => 1
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

        if (!isset($params['cid']) || empty($params['cid'])) {
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
        $map['cid'] = $params['cid'];
        if (isset($params['title']) && !empty($params['title'])) {
            $map['title'] = ['like','%'.$params['title'].'%'];
        }
        if (isset($params['author']) && !empty($params['author'])) {
            $map['author'] = ['like','%'.$params['author'].'%'];
        }
        
        $db = $this->db;
        $this->data['count'] = $db->where($map)->count();
        $this->data['data'] = $db->where($map)->order($params['order'])->page($params['pageIndex'],$params['pageSize'])->select();
        return $this->ajax($this->data);
    }

    public function all()
    {
        $params = input('');

        if (!isset($params['cid']) || empty($params['cid'])) {
            $this->data['code'] = 1001;
            $this->data['msg'] = '缺失类别';
            return $this->ajax($this->data);
        }
        $map['cid'] = $params['cid'];

        if (!isset($params['order']) || empty($params['order'])) {
            $params['order'] = 'create_time desc';
        }

        $map['status'] = 1;

        if (isset($params['title']) && !empty($params['title'])) {
            $map['title'] = ['like','%'.$params['title'].'%'];
        }
        if (isset($params['author']) && !empty($params['author'])) {
            $map['author'] = ['like','%'.$params['author'].'%'];
        }

        $db = $this->db;
        $this->data['count'] = $db->where($map)->count();
        $this->data['data'] = $db->where($map)->order($params['order'])->select();
        return $this->ajax($this->data);
    }
}