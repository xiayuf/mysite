<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use app\admin\controller\Login;

/**
 * admin基础控制器
 */
class Common extends Controller
{
    /**
     * 基础控制器初始化
     * @author duqiu
     */
    public function _initialize()
    {
        $this->restLogin();
        $userId = session('userId');
        define('UID', $userId);   //设置登陆用户ID常量
        $user = Db::table('user')->where('id', $userId)->find();
        $this->ADMIN = $user;
        $this->assign('ADMIN', $user);
    }

    //  生成图片全路径
    public function thumb_url($thumb='')
    {
        $path = $url = '';
        if($thumb) {
            $path = str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace("\\", "/", getcwd())) . DS . 'public' . DS . config('upload_path');
            $url = $path . $thumb;
        }
        return $url;
    }

     /**
     * 校验登录状态
     */
    private function restLogin()
    {
        $login = new Login();
        $userId = session('userId');
        if (empty($userId)){   //未登录
            $login->loginOut();
        }
        return;
    }

    private function loginBox($info='')
    {
        if (request()->isGet()){
            $rest_login = 1;
            $this->assign('rest_login_info', $info);
            $this->assign('rest_login', $rest_login);
        }else{
            ajaxReturn($info, '', 2);
        }
    }
}