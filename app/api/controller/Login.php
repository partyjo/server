<?php
namespace app\index\controller;
use think\Db;

class Login extends Base
{

	public function before()
	{
		//$this->db = Db::name('user');
	}

	public function index()
	{
		echo 'login';exit;
	}

	protected function getInfo($token)
	{

	}

	protected function register($user)
	{
		$data = input();

		$userInfo = $this->getUserInfo();
		if (empty($userInfo)){
			$token = $this->getToken();
			$userInfo = $this->db->where('openid',$token['openid'])->find();
			if ($userInfo) {
				$this->setUserInfo($userInfo);
                $res = $userInfo;
            } else {
				$data['openid'] = $token['openid'];
				$data['nickname'] = $token['nickname'];
				$data['headimgurl'] = $token['headimgurl'];
				$data['sex'] = $token['sex'];
				$data['create_time'] = date('Y-m-d h:i:s', time());

				$data['name'] = $user['username'];
				$data['mobile'] = $user['mobile'];
				$data['code'] = $user['idnum'];

				$this->db->insert($data);
				$userInfo = $this->db->where('openid',$token['openid'])->find();
				$this->setUserInfo($userInfo);
				$res = $userInfo;
            }
        } else {
			$res = $userInfo;
			return $res;
		}

		return $userInfo;
	}

}