<?php if( ! defined('BASEPATH')) exit('No direct script access allowed!')?>
<?php
/*
 * 帖子发表与帖子编辑控制器
 */
class index_post extends CI_Controller
{
    /*
     * 构造函数
     */
    public function __construct(){
        parent::__construct();
        $this->load->model('send_model');//发帖--模型
        $this->load->model('category_model');//帖子操作--模型
        $this->load->model('login_model');//登陆操作模型
    }

    /*
     * 前台发帖模板显示
     */
    public function send_post(){
        $data['category'] = $this->category_model->category_show();//获取分类导航信息
        $this->load->helper('form');
        $this->load->view('index/post.html',$data);
    }
    /*
     * 前台发帖动作
     */
    public function send(){
        //载入表单验证类
        $this->load->library('form_validation');///表单确认
        //设置规则
//        $this->form_validation->set_rules('title','帖子标题','required|min_length[5]');
        //执行验证
        $status = $this->form_validation->run('post');
        if (isset($this->session->username)){//判断当前是否有登陆,没有登陆怎么跳转至登陆界面
            $username =$this->session->username;
            if($status){
                $data = array(
                    'title' => $this->input->post('title'),
                    'sid' => $this->input->post('sid'),
                    'content' => $this->input->post('content'),
                    'isTrue' => 1,
                    'updatetime' => date("Y-m-d H:i:s"),
                    'uname' => $username//------------------------------------
                );
                $this->send_model->add($data);//插入
                $id = $this->category_model->post_content_tofind_id($this->input->post('content'));
                success('index_category/read_post/'.$id,'添加成功！');//自定义成功跳转函数//跳转到发布的帖子页面
            }else{
                $data['category'] = $this->category_model->category_show();//获取分类导航信息
                $this->load->helper('form');
                $this->load->view('index/post.html',$data);
            }
        }else{
            $this->load->view('index/login.html');
        }

    }
    /*
     * 前台帖子编辑
     */
    public function edit_post(){
        $this->load->helper('form');
        $this->load->view('index/edit_post.html');
    }

    /*
     * 前台帖子编辑动作
     */
    public function edit(){
        $this->load->library('form_validation');
        $status = $this->form_validation->run('post');
        if($status){
            echo '数据库操作';
        }else{
            $this->load->helper('form');
            $this->load->view('index/edit_post.html');
        }
    }

}