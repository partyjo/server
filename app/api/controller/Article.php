<?php
namespace app\api\controller;
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
        $params['id'] = $this->createGuid();
        $params['web_id'] = $this->user['web_info']['id'];
        $params['create_time'] = $this->now();
        $params['update_time'] = $this->now();

        if (!isset($params['category_ids'])) {
            $this->data['success'] = false;
            $this->data['code'] = 1001;
            return $this->ajax($this->data);
        }

        if (!$this->db->insert($params)) {
            $this->data['success'] = false;
            $this->data['code'] = 2001;
            return $this->ajax($this->data);
        }
        
        $this->data['data'] = $this->db->where('id',$params['id'])->find();
        return $this->ajax($this->data);
    }

    public function update()
    {
        $params = input('');
        $params['update_time'] = $this->now();

        if (!isset($params['id'])) {
            $this->data['success'] = false;
            $this->data['code'] = 1001;
            return $this->ajax($this->data);
        }

        $this->data['data'] = $this->db->update($params);
        return $this->ajax($this->data);
    }

    public function delete()
    {
        $params = input('');
        $params['update_time'] = $this->now();
        $params['is_delete'] = 1;

        if (!isset($params['id'])) {
            $this->data['success'] = false;
            $this->data['code'] = 1001;
            return $this->ajax($this->data);
        }

        $this->data['data'] = $this->db->update($params);
        return $this->ajax($this->data);
    }

    public function get()
    {
        $params = input('');

        if (!isset($params['id'])) {
            $this->data['success'] = false;
            $this->data['code'] = 1001;
            return $this->ajax($this->data);
        }

        $map = [
            'id' => $params['id'],
            'is_delete' => 0
        ];

        $res = $this->db->where($map) ->find();
        if (!$res) {
            $this->data['code'] = 3001;
        } else {
            $this->data['data'] = $res;
        }
        
        return $this->ajax($this->data);
    }

    public function page()
    {
        $params = input('');

        if (!isset($params['pageIndex'])) {
            $params['pageIndex'] = 1;
        }
        if (!isset($params['pageSize'])) {
            $params['pageSize'] = 10;
        }
        if (!isset($params['order'])) {
            $params['order'] = 'create_time desc';
        }

        $map['is_delete'] = 0;
        if (isset($params['title'])) {
            $map['title'] = ['like','%'.$params['title'].'%'];
        }
        if (isset($params['author'])) {
            $map['author'] = ['like','%'.$params['author'].'%'];
        }
        if (isset($params['category_ids'])) {
            $map['category_ids'] = ['like','%'.$params['category_ids'].'%'];
        }

        $db = $this->db;
        $this->data['count'] = $this->data['total'] = $db->where($map)->count();
        $this->data['data'] = $db->where($map)->order($params['order'])->page($params['pageIndex'],$params['pageSize'])->select();
        return $this->ajax($this->data);
    }

    public function all()
    {
        $params = input('');

        if (!isset($params['order'])) {
            $params['order'] = 'create_time desc';
        }

        $map['is_delete'] = 0;

        if (isset($params['title'])) {
            $map['title'] = ['like','%'.$params['title'].'%'];
        }
        if (isset($params['author'])) {
            $map['author'] = ['like','%'.$params['author'].'%'];
        }
        if (isset($params['category_ids'])) {
            $map['category_ids'] = ['like','%'.$params['category_ids'].'%'];
        }

        $db = $this->db;
        $this->data['count'] = $this->data['total'] = $db->where($map)->count();
        $this->data['data'] = $db->where($map)->order($params['order'])->select();
        return $this->ajax($this->data);
    }
}