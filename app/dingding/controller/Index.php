<?php
namespace app\dingding\controller;

class Index extends Base
{
    public function index($msg = '我就是我，不一样的烟火')
    { 
      $msg = [
        'msgtype' => 'text',
        'text' => [
          'content' => $msg
        ],
        'at' => [
          'atMobiles' => [],
          'isAtAll' => false
        ]
      ];
      $res = $this->send('test', $msg);
    }

    public function send($robotName, $data)
    {
      $testTobot = $this->robots[$robotName];
      return $this->http_curl($testTobot, json_encode($data));
    }
}