<?php
namespace app\index\controller;
use think\Controller;

class Index extends Controller
{
    public function index()
	{
		echo '<h1>hello world</h1>';
    }

    public function test()
	{
		echo '<h1>hello test</h1>';
    }

}