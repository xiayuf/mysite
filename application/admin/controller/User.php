<?php
namespace app\admin\controller;

use think\Db;


/**
 * 后台-管理员管理
 */
class User extends Common
{
	/**
     * 管理员列表
     * @access public
     * @return void
     */
    public function index()
    {
        $items = [];
        $items = Db::table('user')
            ->field('id,name,phone,level,closed,createtime')
            ->order('id asc')
            ->select();
        $this->assign('list', $items);
        $this->assign('menu', 'userlist');
        return $this->fetch();
    }

    /**
     * 创建管理员
     * @access public
     * @return void
     */
    public function create()
    {
        if (request()->isPost()){
            try{
                $data = input('post.');
                $allow_fields = 'name,passwd,phone,level';
                if(!$data = check_fields($data,$allow_fields)) {
                    $this->error('非法的数据提交');
                }else if(!$data['name']) {
                    $this->error('用户名不正确');
                }else if(!$data['passwd']) {
                    $this->error('密码不正确');
                }else if(!$data['phone']) {
                    $this->error('手机号不正确');
                }else {
                    $data['passwd']     = md5($data['passwd']);
                    $data['createtime'] = time();
                    $data['closed']     = 0;
                    // 非超级管理员没有权限创建其他管理员
                    if($this->ADMIN['level'] != 1) {
                        return json_encode(['status'=>0,'msg'=>'非法操作']);
                    }
                    $result = Db::table('user')->insert($data);
                    if ($result){
                        return json_encode(['status'=>1,'msg'=>'创建成功']);
                    }else{
                        return json_encode(['status'=>0,'msg'=>'创建失败']);
                    }
                }
            } catch (\Exception $e) {
                return json_encode(['status'=>0,'msg'=>$e->getMessage()]);
            }
        }else{
            return $this->fetch('create');
        }
    }

    /**
     * 编辑管理员
     * @access public
     * @return void
     */
    public function edit()
    {
        if (request()->isPost()){
            try{
                $data = input('post.');
                if($data['passwd'] == '******') {
                    unset($data['passwd']);
                }else {
                    $data['passwd'] = md5($data['passwd']);
                }
                // 非超级管理员没有权限编辑其他管理员
                if($this->ADMIN['level'] != 1) {
                    return json_encode(['status'=>0,'msg'=>'非法操作']);
                }
                $result = Db::table('user')->where('id', $data['id'])->update($data);
                if ($result){
                    return json_encode(['status'=>1,'msg'=>'操作成功']);
                }else{
                    return json_encode(['status'=>0,'msg'=>'操作失败']);
                }
            } catch (\Exception $e) {
                return json_encode(['status'=>0,'msg'=>$e->getMessage()]);
            }
        }else{
            $id = (int)input('id');
            $detail = Db::table('user')->where('id', $id)->find();
            $this->assign('detail', $detail);
            return $this->fetch('edit');
        }
    }

    /**
     * 删除管理员
     * @access public
     * @return void
     */
    public function delete()
    {
        if (request()->isPost()){
            try{
                $data = input('post.');
                $result = Db::table('user')->where('id',$data['id'])->delete();
                if ($result){
                    return json_encode(['status'=>1, 'msg'=>'操作成功']);
                }else{
                    return json_encode(['status'=>0, 'msg'=>'操作失败']);
                }
            } catch (\Exception $e) {
                return json_encode(['status'=>0, 'msg'=>$e->getMessage()]);
            }
        }
    }


     /**
     * 修改密码
     * @access public
     * @return void
     */
    public function editpwd()
    {
        if (request()->isPost()){
            try{
                $data = input('post.');
                if($data['passwd'] == '******') {
                    unset($data['passwd']);
                }else {
                    $data['passwd'] = md5($data['passwd']);
                }
                $detail =  Db::table('user')->where('id', $data['id'])->find();
                if($this->ADMIN['id'] != $detail['id']) {
                    return json_encode(['status'=>0,'msg'=>'非法操作']);
                }
                $result = Db::table('user')->where('id', $data['id'])->update($data);
                if ($result){
                    session('userId', null);
                    cookie('uname', null);
                    cookie('uid', null);
                    return json_encode(['status'=>1,'msg'=>'操作成功','url'=>url('Login/index')]);
                }else{
                    return json_encode(['status'=>0,'msg'=>'操作失败']);
                }
            } catch (\Exception $e) {
                return json_encode(['status'=>0,'msg'=>$e->getMessage()]);
            }
        }else{
            $id = (int)input('id');
            $detail = Db::table('user')->where('id', $id)->find();
            $this->assign('detail', $detail);
            return $this->fetch('public/editpwd');
        }
    }

    /**
     * 设置管理员状态(启用|禁用)
     * @access public
     * @return void
     */
    public function status()
    {
        if (request()->isPost()){
            try{
                $data = input('post.');
                $result = Db::table('user')->where('id', $data['id'])->update($data);
                // 提交事务
                if ($result){
                    Db::commit();
                    $this->success('操作成功');
                }else{
                    $this->success('操作失败');
                }
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        }
    }
}
