<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\View;
use think\Request;

class Login extends Controller
{
    private $cModel;   //当前控制器关联模型

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 登录页面
     * @access public
     * @return void
     */
    public function index()
    {
        $userId = session('userId');
        if (!empty($userId)){
            $this->redirect(url('Index/index'));
        }else{
            // 载入登录页面，渲染模板输出
            $remember = 0;
            if(cookie('remember')) {
                $remember = 1;
            }
            $this->assign('remember', $remember);
            return $this->fetch();
        }
    }

    /**
     * 登录判断
     * @access public
     * @return void
     */
    public function checkLogin()
    {
        if(request()->isPost()){
            $data = input('post.');
            if(!$data['username']) {
                return json_encode(['status'=>0,'msg'=>'用户名错误']);
            }
            if(!$data['password']) {
                return json_encode(['status'=>0, 'msg'=>'密码错误']);
            }
            $user = Db::table('user')->where('name', $data['username'])->find();
            if(!$user) {
                return json_encode(['status'=>0, 'msg'=>'用户不存在']);
            }else{
                $json = [];
                if($user['passwd'] != md5($data['password'])){
                    return json_encode(['status'=>0, 'msg'=>'密码错误']);
                }else{
                    $json = ['status'=>1, 'msg'=>'登录成功', 'url'=>url('Index/index')];
                }
                //设置session,cookie
                session('userId', $user['id']);
                cookie('uname', $user['name']);
                cookie('uid', $user['id']);
                if(isset($data['remember'])) {
                    cookie('remember', 1);
                }else {
                    cookie('remember', 0);
                }
                return json_encode($json);
            }
        }
    }

    public function checkRegister()
    {
        if(Request::instance()->isPost()) {
            if( !Request::instance()->has('username') || !Request::instance()->has('password') || !Request::instance()->has('rpassword')) {
                return json_encode(['code'=>400,'msg'=>'参数错误','data'=> new \stdClass]);
            }
        }
    }

    public function loginOut($params='')
    {
        session('userId', null);
        session('user_token', null);
        cookie('name', null);
        cookie('uname', null);
        cookie('uid', null);
        cookie('avatar', null);
        $this->redirect('Login/index', $params);
    }

    public function restLogin(){
        return $this->fetch();
    }
}
