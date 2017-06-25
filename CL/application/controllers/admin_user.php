<?php if( ! defined('BASEPATH')) exit('No direct script access allowed!')?>
<?php
/**
 * Created by PhpStorm.
 * User: Ming
 * Date: 2017/6/9
 * Time: 0:58
 */
class admin_user extends CI_Controller
{
    /*
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('send_model');//发帖--模型
        $this->load->model('category_model');//帖子操作--模型
        $this->load->model('login_model');//帖子操作--模型
        $this->load->model('user_model');//用户操作--模型
    }

    /*
     * 用户信息显示
     */
    public function user_info_show(){
        $data['user_info'] = $this->user_model->get_user_info();
        $this->load->view("admin/user.html",$data);
    }

    /*
     * 单独的用户信息获取（用来修改）
     */
    public function get_user_info(){
        $uid = $_POST["uid"];
        $data['special_user'] = $this->user_model->get_a_user_info($uid);
        $data = json_encode($data);
        echo $data;
    }

    /*
     * 用户信息删除
     */
    public function user_delete(){
        $uid = $_POST['uid'];
        $this->user_model->delete_user_info($uid);
        $data['user_info'] = $this->user_model->get_user_info();//删除之后获取最新用户信息
        $data = json_encode($data);
        echo $data;
    }

    /*
     * 用户信息修改
     */
    public function user_change(){
        $uid = $_POST['uid'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $select = $_POST['select'];
        $data = array(
            'username' => $username,
            'password' => $password,
            'state' => $select
    );
        $this->user_model->change_user_info($uid,$data);
        $data['special_user'] = $this->user_model->get_a_user_info($uid);
        $data = json_encode($data);
        echo $data;
    }

}