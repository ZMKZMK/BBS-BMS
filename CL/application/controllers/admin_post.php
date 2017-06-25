<?php if( ! defined('BASEPATH')) exit('No direct script access allowed!')?>
<?php

/**
 * 后台帖子管理控制器
 * User: lenovo
 * Date: 2017/6/4
 * Time: 21:20
 */
class admin_post extends CI_Controller
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
     * 所有帖吧分类展示
     */
    public function post_top_del()
    {
        $data['category'] = $this->category_model->category_show();////找到所有帖吧

        $sid = $data['category'][0]['sid'];//取---->获得的分类中的第一个作为初展示
        foreach ($data['category'] as $v => $value):
            $temp_data = $this->category_model->category_post($data['category'][$v]['sid']);//获取每一个贴吧的帖子总数
            $count = 0;
            foreach ($temp_data as $v1):
                $count++;
            endforeach;
            $data['category'][$v]['count'] = $count;
        endforeach;

        $data['category_content'] = $this->category_model->category_post($sid);////找到分类下的所有帖子
        foreach ($data['category_content'] as $v => $value)://///////二维数组foreach赋值！！！！！
            $data['category_content'][$v]['content'] = trimall($data['category_content'][$v]['content']);
            $data['category_content'][$v]['content'] = mb_substr($data['category_content'][$v]['content'], 0, 40, 'utf-8');
            $count++;
        endforeach;

        $this->load->view('admin/post_delete.html', $data);
    }

    /*
     * 后台分类选择AJAX
     */
    public function choose_category(){
        $sid = $_POST["btn_value"];
        $data['new_category_content'] = $this->category_model->category_post($sid);////找到分类下的所有帖子
        foreach ($data['new_category_content'] as $v => $value)://///////二维数组foreach赋值！！！！！
            $data['new_category_content'][$v]['content'] = trimall($data['new_category_content'][$v]['content']);
            $data['new_category_content'][$v]['content'] = mb_substr($data['new_category_content'][$v]['content'], 0, 40, 'utf-8');
        endforeach;
        $data = json_encode($data);
        echo($data);
    }

    /*
     * 后台删除帖子操作
     */
    public function delete_post(){
        $id = $_POST["id"];
        $sid = $_POST["sid"];
        $this->send_model->delete($id);

        $count = $this->category_model->category_count($sid);//获取每一个贴吧的帖子总数

        echo $count;
    }


    /*
     * 后台帖子编辑
     */
    public function edit_post(){
        $id = $this->uri->segment(3);//第三个片段//去uri片段
        $this->category_model->read_post($id);
        $data['post_content'] = $this->category_model->read_post($id);//获取帖子信息
        $data['category'] = $this->category_model->category_show();//获取分类导航信息
        $this->load->view('admin/post_edit.html',$data);
    }

    /*
     * 后台帖子修改动作
     */
    public function change(){
                $data = array(
                    'title ' => $this->input->post('title'),
                    'content' => $this->input->post('content'),
                    'sid' => $this->input->post('sid'),
                    'id' => $this->input->post('id')
                );
                $this->send_model->change($data);
                success('admin_post/post_top_del/','修改成功！');//自定义成功跳转函数//跳转到发布的帖子页面


    }

}