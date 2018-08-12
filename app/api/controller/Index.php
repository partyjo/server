<?php
namespace app\api\controller;
use think\Controller;
use think\Request;
use think\Db;

class Index extends Controller
{
    public function index()
	{
        $request = Request::instance();
        dump($request->domain());
		echo '<h1>hello world</h1>';
    }

}