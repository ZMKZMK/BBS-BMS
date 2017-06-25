<?php if( ! defined('BASEPATH')) exit('No direct script access allowed!')?>
<?php
/**
 * 前台控制器
 * User: lenovo
 * Date: 2017/5/31
 * Time: 16:10
 */
class home extends CI_Controller
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
     * 默认首页显示方式
     */
    public function index()
    {
        $data['category_content'] = $this->category_model->check_post();////找到所有帖子
        foreach ($data['category_content'] as $v => $value)://///////二维数组foreach赋值！！！！！
            $data['category_content'][$v]['content'] = trimall($data['category_content'][$v]['content']);
            $data['category_content'][$v]['content'] = mb_substr($data['category_content'][$v]['content'], 0, 40, 'utf-8');
        endforeach;
        $data['category'] = $this->category_model->category_show();//获取分类导航信息
        $this->load->view('index/index.html',$data);
    }

    /*
     * 发帖页显示方式
     */
    public function post()
    {
        $this->load->helper('form');
        $this->load->view('index/post.html');
    }

}
?>