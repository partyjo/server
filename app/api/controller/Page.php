<?php
namespace app\index\controller;
use think\Db;

class Page extends Base
{

	protected function before() 
	{

		$this->db = Db::name('page_view');

	}


	public function index()
	{
		$data = input();
		$data['create_time'] = $this->create_time;
		if (empty($data['pathname'])) {
			$this->success = false;
			$this->msg = 'pathname不能为空';
		} else if (!$this->db->insert($data)) {
			$this->success = false;
			$this->msg = '写入失败';
		} else {
			$this->msg = '访问量+1';
		}
		return $this->ajaxReturn();
	}

	public function getPv()
	{
		$data = input();
		if (empty($data['pathname'])) {
			$this->success = false;
			$this->msg = 'pathname不能为空';
			return $this->ajaxReturn();
		}

		$db = $this->db->where('pathname',$data['pathname']);
		$pv = $db->count();
		$pvToday = $db->whereTime('create_time', 'today')->count();

		$this->data['pathname'] = $data['pathname'];
		$this->data['pv'] = $pv;
		$this->data['pvToday'] = $pvToday;

		return $this->ajaxReturn();
	}


}