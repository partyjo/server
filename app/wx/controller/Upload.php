<?php
namespace app\wx\controller;
use think\Db;

class Upload extends Base
{

  public function img()
  {   
    $file = request()->file('postFile');
    $params = input('');
    // 处理文件对象
    $path = ROOT_PATH . 'public' . DS . 'upload'; // 文件保存的文件夹
    $info = $file->move($path); // 移动文件到目录下
    if ($info) {
      $date = substr($info->getPath(),-8); // 获取当前日期
      $filename= $info->getFilename(); // 获取文件名
      $filepath= $this->request['host'].'/public/upload/'.$date.'/'.$info->getFilename(); // 获取文件有效访问地址
      $size= $info->getSize(); // 获取文件大小
      $filetype= $info->getExtension(); // 获取文件类型
      // 数据处理
      $data = [];
      $data['id'] = $this->createGuid();
      $data['file_name'] = $filename;
      $data['file_path'] = $filepath;
      $data['file_size'] = $size;
      $data['file_type'] = $filetype;
      $data['create_time'] = $this->now();
      $data['update_time'] = $this->now();

      $this->data['data'] = $data;
    } else {
      // 上传失败获取错误信息
      $this->data['code'] = 1001;
      $this->data['msg'] = $file->getError();
    }

    return $this->ajax($this->data);
  }
}