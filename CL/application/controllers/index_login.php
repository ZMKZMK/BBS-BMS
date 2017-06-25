<?php if (!defined('BASEPATH')) exit('No direct script access allowed!') ?>
<?php

/*
 * 论坛登陆页面控制器
 */

class index_login extends CI_Controller
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
     * 前台登陆功能
     */
    public function index()
    {
        $this->load->view('index/login.html');
    }
    /*
     * 前台退出功能
     */
    public function exit_forum(){
        $array_items = array('username', 'password');
        $this->session->unset_userdata($array_items);
        error('退出成功');
    }

    /*
     * 账号注册页面跳转
     */
    public function sign_up()
    {
        $this->load->view("index/login_sign_up.html");
    }
    /*
     * 账号注册动作
     */
    public function sign_up_motion()
    {
        $username = $this->input->post('username');//用户名
        $password = $this->input->post('password');//密码
        if($this->login_model->register($username, $password)){
            success("index_login/index","注册成功");
        }else{
            error("用户名重复！！！");
        };
    }

    /*
     * 忘记密码
     */
    public function forget()
    {
        $this->load->view("index/login_forget.html");
    }

    /*
     * 登陆进去操作（表单验证）
     */
    public function send()
    {
        //载入表单验证类
        $this->load->library('form_validation');///表单确认
        //设置规则
        $this->form_validation->set_rules('username', '帖子标题', 'required');
        $this->form_validation->set_rules('password', '帖子内容', 'required');
        //执行验证
        $status = $this->form_validation->run();
        if ($status) {
            $username = $this->input->post('username');//用户名
            $password = $this->input->post('password');//密码
            if($this->login_model->check_user($username, $password)){//验证密码是否正确
                $user_data = array(
                    'username' => $username,
                    'password' => $password
                );
                $this->session->set_userdata($user_data);//Session
                success('', '登陆成功！');//自定义成功跳转函数
            }else{
                error('账号密码错误');
            }
        } else {
            error('账号密码为空');
        }
    }

}