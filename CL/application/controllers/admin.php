<?php if( ! defined('BASEPATH')) exit('No direct script access allowed!')?>
<?php
/*
 * 后台控制器
 */

class admin extends CI_Controller
{
    /*
     * 默认管理页面
     */
    public  function  index(){
        if (isset($this->session->admin_username)){//后台用户已经登陆
            $this->load->view("admin/index.html");
        }else{//后台用户还未登陆
            $this->load->view('admin/login.html');
        }
    }
    /*
     * 帖子置顶
     */
    public  function  post_stick(){
        $this->load->view('admin/post_stick.html');
    }
    /*
     * 帖子删除
     */
    public  function  post_delete(){
        $this->load->view('admin/post_delete.html');
    }
    /*
     * 帖子编辑
     */
    public  function  post_edit(){
        $this->load->view('admin/post_edit.html');
    }
}
?>
