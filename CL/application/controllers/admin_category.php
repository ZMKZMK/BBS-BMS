<?php if( ! defined('BASEPATH')) exit('No direct script access allowed!')?>
<?php
/**
 * 后台版块管理
 * User: ming
 * Date: 2017/6/5
 * Time: 21:41
 */
class admin_category extends CI_Controller
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
     * 后台版块加载与添加
     */
    public function category_show_add(){
        $data['category'] = $this->category_model->category_show();////找到所有帖吧

        $this->load->view("admin/category_manage.html",$data);
    }

    /*
     * 后台版块删除
     */
    public function category_delete(){
        $sid = $_POST["btn_value"];
        $data = $this->category_model->category_post($sid);//查询贴吧所有的帖子信息

        foreach ($data as $v):
             $this->category_model->delete_post_reply($v['id']);//通过帖子id值删除帖子的评论
        endforeach;

        $this->category_model->delete_cate_post($sid);//删除贴吧下面所有的帖子
        $this->category_model->delete_category($sid);//删除贴吧
    }

    /*
     * 后台版块添加
     */
    public function category_add(){
        $data = array(
            'name' => $this->input->post('name')
        );
        $this->category_model->add_category($data);
        error("添加成功");
    }

    /*
     * 后台版块编辑
     */
    public function category_change(){
        $sid = $_POST['sid'];
        $content = $_POST['content'];
        $data = array(
            'name '=>$content
        );
        $this->category_model->change_category($sid,$data);
        echo "aa";
    }

}