<?php if( ! defined('BASEPATH')) exit('No direct script access allowed!')?>
<?php
/*
 * 后台登陆页面控制器
 */
class admin_login extends CI_Controller
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

    }

    /*
     * 登陆默认方法
     */
    public function index(){
        $this->load->view('admin/login.html');
    }


    /*
     * 登陆进去操作（表单验证）
     */
    public function send()
    {
            $admin_username = $this->input->post('admin_username');//用户名
            $admin_password = $this->input->post('admin_password');//密码
            if($this->login_model->admin_check_user($admin_username, $admin_password)){//验证密码是否正确
                $admin_user_data = array(
                    'admin_username' => $admin_username,
                    'admin_password' => $admin_password
                );
                $this->session->set_userdata($admin_user_data);//Session
                success('admin/index', '登陆成功！');//自定义成功跳转函数
            }else{
                error('账号密码错误');
            }
    }

    /*
     * 后台退出功能
     */
    public function exit_forum(){
        $array_items = array('admin_username', 'admin_password');
        $this->session->unset_userdata($array_items);
        error('退出成功');
    }

}