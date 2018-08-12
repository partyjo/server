<?php
namespace app\api\controller;
use think\Db;

class Demo extends Base
{
    public function before()
	{
		//$this->db = Db::name('category');
    }
    
    public function add()
    {   
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