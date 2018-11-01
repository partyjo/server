<?php
namespace app\index\controller;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
	{
        $this->db = Db::name('nq_guess');
		dump($this->db->select());
    }

}