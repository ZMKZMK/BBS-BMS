<?php if (!defined('BASEPATH')) exit('No direct script access allowed!') ?>
<?php

/**
 * 前台分类与帖子查看和回复控制器
 * User: lenovo
 * Date: 2017/6/2
 * Time: 18:47
 */
class index_category extends CI_Controller
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
     * 前看分类页面展示
     */
    public function show()
    {
        $sid = $this->uri->segment(3);
        $data['category_content'] = $this->category_model->category_post($sid);////找到分类下的所有帖子
        foreach ($data['category_content'] as $v => $value)://///////二维数组foreach赋值！！！！！
            $data['category_content'][$v]['content'] = trimall($data['category_content'][$v]['content']);
            $data['category_content'][$v]['content'] = mb_substr($data['category_content'][$v]['content'], 0, 40, 'utf-8');
        endforeach;
        $data['category_name'] = $this->category_model->check_category($sid)[0];//获取贴吧名称
        $data['category'] = $this->category_model->category_show();//获取分类导航信息
        $this->load->view('index/category.html', $data);
    }

    /*
     * 帖子查看
     */
    public function read_post()
    {
        $id = $this->uri->segment(3);//第三个片段//去uri片段
        $data['post_content'] = $this->category_model->read_post($id);//获取帖子信息
        $data['post_content'][0]['category_name'] = $this->category_model->check_category($data['post_content'][0]['sid'])[0]["name"];//获取贴吧名称
        $data['comment_content'] = $this->category_model->read_comment($id);//获取帖子对应评论信息
        $data['category'] = $this->category_model->category_show();//获取分类导航信息
        $this->load->view('index/article.html', $data);
//        $this->output->enable_profiler(TRUE);//调试模式
    }


    /*
     * 帖子评论回复动作
     */
    public function post_comment()
    {
        $id = $this->input->post('id');
        $fid = ++$this->category_model->read_comment_floor($id)['fid'];//获取楼层数目
        if ($fid==''){
            $fid = 1;
        }
        $this->load->library('form_validation');//载入表单验证类
        //执行验证
        $status = $this->form_validation->run('comment');

        if (isset($this->session->username)){//判断当前是否有登陆,没有登陆怎么跳转至登陆界面
            $username =$this->session->username;
            $uid = $this->login_model->find_uid($username);//查找当前用户对应的id
            if ($status) {
                $data = array(
                    'fid' => $fid,//回复对应楼层的id
                    'id' => $id,//帖子的id
                    'commentcontent' => $this->input->post('comment'),//文章回复内容
                    'uid' => $uid,//当前的用户的id//
                    'replydatetime' => date("Y-m-d H:i:s"),//回复时间
                    'uname' => $username//当前的用户的//
                );
                $this->category_model->add_comment($data);//插入
                success('index_category/read_post/'.$id, '添加成功！');//自定义成功跳转函数

            } else {
                $this->load->view('index/article.html');
            }
        }else{
            $this->load->view('index/login.html');
        }

    }
}