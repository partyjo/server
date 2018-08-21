<?php
namespace app\wx\controller;
use think\Db;
/**
*
*/
class User extends Base
{


	protected function before() {

		$this->db = Db::name('user');

	}

	// 用户注册
	public function register()
	{
		$data = input();

		if (empty($data['name']) || empty($data['mobile'])) {
			$this->success = false;
			$this->msg = '姓名或手机号必须填写';
			return $this->ajaxReturn();
		}

		$userOauthInfo = $this->userOauthInfo;
		if (!is_null($userOauthInfo)) {
			$data['openid'] = $userOauthInfo['openid'];
			$data['nickname'] = $userOauthInfo['nickname'];
			$data['headimgurl'] = $userOauthInfo['headimgurl'];
			$data['sex'] = $userOauthInfo['sex'];
		}
		$data['guid'] = $this->createGuid();
		$data['create_time'] = $this->create_time;

		if ($this->db->insert($data)) {
			$this->msg = '注册成功';
			$this->data = $this->db->where('guid',$data['guid'])->find();
		} else {
			$this->success = false;
			$this->msg = '服务器异常，注册失败';
		}

		return $this->ajaxReturn();
	}

	// 是否注册
	protected function isRegister($user)
	{

	}

}