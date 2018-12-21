<?php
namespace app\weiquan\controller;
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

  public function base64()
  {   
    // $file = request()->file('postFile');
    $image = input('post.postFile');
    $imageName = "25220_".date("His",time())."_".rand(1111,9999).'.png';
    if (strstr($image,",")){
      $image = explode(',',$image);
      $image = $image[1];
    }
    $path = $this->request['host'].'/public/upload/'.date("Ymd",time());
    if (!is_dir($path)){ //判断目录是否存在 不存在就创建
      mkdir($path,0777,true);
    }
    $imageSrc= $path."/". $imageName; //图片名字
    $r = file_put_contents($imageSrc, base64_decode($image));//返回的是字节数
    if ($r){
      // 数据处理
      $data = [];
      $data['id'] = $this->createGuid();
      $data['file_name'] = $imageName;
      $data['file_path'] = $imageSrc;
      $data['file_size'] = $r;
      $data['file_type'] = 'png';
      $data['create_time'] = $this->now();
      $data['update_time'] = $this->now();

      $this->data['data'] = $data;
    } else {
      // 上传失败获取错误信息
      $this->data['code'] = 1001;
      $this->data['msg'] = '上传失败';
    }

    return $this->ajax($this->data);
  }
}