<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;

/**
 * 文件上传控制器
 */
class Upload extends Controller
{
	public $file_move_path;   //上传文件移动服务器位置
    public $file_back_path;   //上传文件返回文件地址
    private $adminid;

	public function _initialize()
    {
        parent::_initialize();
        $this->adminid = session('userId');
        if (!$this->adminid){
            exit();
        }
        $upload_path = config('upload_path');
        $this->file_move_path = ROOT_PATH . 'public' . DS . $upload_path;
        $this->file_back_path = config('base_url') . $upload_path;
    }

    /**
     * 文件上传方法
     */
    public function upload()
    {
        // 获取表单上传文件
	    $file = request()->file('file');
	    // 移动文件到站点根目录/uploads/ 目录下
	    if($file){
	    	$size = (int)config('upload_max_filesize')*1048576;
	    	$info = $file->validate(['size'=>$size])->move($this->file_move_path,md5(microtime(true)));
	        if($info){
	            // 成功上传后 获取上传信息
	            // 写入upload数据表  aid,md5,name,file,size,createtime
	            $data = [
					'name'       => $info->getFilename(),
					'file'	     => $info->getSaveName(),
					'size'       => $info->getSize()/1024,
					'createtime' => time()
	            ];
	            $file_id = Db::table('upload')->insertGetId($data);
	            $json = [
					'status'   => 1,
					'msg'      => '上传成功',
					'fileurl'  => "http://47.90.51.126" . DS . 'public' . DS . config('upload_path') . $info->getSaveName(),
					'file'     => $info->getSaveName(),
					'name'     => $info->getFilename(),
					'file_id'  => $file_id
	            ];
	            return json_encode($json);
	        }else{
	            // 上传失败获取错误信息
	            return json_encode(['status'=>0, 'msg'=>"上传失败!" . $file->getError()]);
	        }
	    }else {
	    	return json_encode(['status'=>0, 'msg'=>'请选择文件']);
	    }
    }
}