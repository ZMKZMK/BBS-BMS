<?php if (!defined('BASEPATH')) exit('No direct script access allowed!') ?>
<?php

/**
 * 登陆模型
 * User: lenovo
 * Date: 2017/6/4
 * Time: 17:40
 */
class login_model extends CI_Model
{
    /*
     * 前台登陆账号密码验证
     */
    public function check_user($username, $password){
        $q = $this->db
            ->where(array(
                'username'=>$username,
                'password'=>$password,
                'state'=>1
                ))->get('user')->result_array();
        if(isset($q[0])){
            return true;
        }
        return false;
    }
    /*
     * 前台通过当前用户查找用户的id
     */
    public function find_uid($username){
        $data = $this->db->where(array('username'=>$username))->get('user')->result_array();
        return $data[0]['uid'];
    }
    /*
     * 前台密码账户注册
     */
    public function register($username, $password){
        $q = $this->db
            ->where(array(
                'username'=>$username,
            ))->get('user')->result_array();
        if(isset($q[0])){
            return false;//已被注册，返回flase
        }else{
            $data = array(
                'username'=>$username,
                'password'=>$password,
                'state'=>1,
                'createtime'=>date("Y-m-d H:i:s")
            );
            $this->db->insert('user',$data);
            return true;
        }
    }



    /*
     * 后台登陆账号密码验证
     */
    public function admin_check_user($admin_username, $admin_password){
        $q = $this->db
            ->where(array(
                'admin_username'=>$admin_username,
                'admin_password'=>$admin_password
            ))->get('admin_user')->result_array();
        if(isset($q[0])){
            return true;
        }
        return false;
    }
}