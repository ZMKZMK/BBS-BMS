<?php if( ! defined('BASEPATH')) exit('No direct script access allowed!')?>
<?php

/**
 * 后台帖子评论管理系统
 * User: ming
 * Date: 2017/6/9
 * Time: 20:10
 */
class admin_comment extends CI_Controller
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
     * 帖子留言展示
     */
    public function post_comment_show(){
        $id = $this->uri->segment(3);//第三个片段//去uri片段
        $data['comment_content'] = $this->category_model->read_comment($id);
        $this->load->view("admin/comment.html",$data);
    }

    /*
     * 帖子留言修改
     */
    public function post_comment_change(){
        $id = $_POST['id'];
        $fid = $_POST['fid'];
        $commentcontent = $_POST['commentcontent'];
        $data = array(
            'commentcontent' => $commentcontent
        );
        $this->category_model->change_comment($fid,$id,$data);
        echo "ok";
    }


    /*
     * 帖子留言删除
     */
    public function post_comment_delete(){
        $id = $_POST['id'];
        $fid = $_POST['fid'];
        $data['comment'] = $this->category_model->read_comment($id);
        $max_floor = $this->category_model->read_comment_floor($id);//楼层数目
        $this->category_model->delete_comment($fid,$id);


        foreach ($data['comment'] as $v => $value):
            if ($data['comment'][$v]['fid']>$fid){
                $new_fid = $data['comment'][$v]['fid']-1;
                $new_data = array(
                    'fid' => $new_fid
                );
                $this->category_model->update_floor($data['comment'][$v]['fid'],$id,$new_data);//楼层数目
            }
        endforeach;


    }


}