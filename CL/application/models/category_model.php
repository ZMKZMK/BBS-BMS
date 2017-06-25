<?php if( ! defined('BASEPATH')) exit('No direct script access allowed!')?>
<?php
/**
 * 前台分类帖子查看与回复模型
 * User: lenovo
 * Date: 2017/6/3
 * Time: 16:27
 */
class category_model extends CI_Model
{
    /*
     * 前台导航读取功能
     */
    public function category_show(){
        $data = $this->db->get('category')->result_array();//获取分类导航信息
        return $data;
    }

    /*
     * 所有帖子信息读取功能
     */
    public function check_post(){
        $data = $this->db->get('news')->result_array();
        return $data;
    }

    /*
     * 分类帖子信息读取功能
     */
    public function category_post($sid){
        $data = $this->db->where(array('sid'=>$sid))->get('news')->result_array();
        return $data;
    }

    /*
     * 各分类下帖子总数查询功能??????
     */
    public function category_count($sid){
        $this->db->like('sid', $sid)->from('news');
        return $this->db->count_all_results();
    }

    /*
     * 通过帖子所属sid查询哪个贴吧分类
     */
    public function check_category($sid){
        $data = $this->db->where(array('sid'=>$sid))->get('category')->result_array();
        return $data;
    }

    /*
     * 分类贴吧  删除
     */
    public function delete_category($sid){
        $this->db->where('sid',$sid)->delete('category');
    }
    /*
     * 删除帖子下所有的帖子
     */
    public function delete_cate_post($sid){
        $this->db->where('sid',$sid)->delete('news');//删除帖子
    }
    /*
     * 删除帖子下所有的回复
     */
    public function delete_post_reply($id){
        $this->db->where('id',$id)->delete('comments');//删除评论
    }

    /*
     * 添加分类
     */
    public function add_category($data){
        $this->db->insert('category',$data);
    }
    /*
     * 修改分类
     */
    public function change_category($sid,$data){
        $this->db->where(array('sid'=>$sid))->update('category', $data);
    }



    /*
     * 帖子具体信息读取功能
     */
    public function read_post($id){
        $data = $this->db->where(array('id'=>$id))->get('news')->result_array();
        return $data;
    }

    /*
     * 通过帖子内容查找帖子id
     */
    public function post_content_tofind_id($content){
        $data = $this->db->where(array('content'=>$content))->get('news')->result_array();
        return $data[0]['id'];
    }
    /*
     * 查询帖子评论的最大楼层数目
     */
    public function read_comment_floor($id){
        $this->db->select_max('fid');
        $data = $this->db->where(array('id'=>$id))->get('comments')->result_array();
        return $data[0];
    }
    /*
     * 帖子评论读取功能
     */
    public function read_comment($id){
        $data = $this->db->where(array('id'=>$id))->order_by('fid', 'ASC')->get('comments')->result_array();
        return $data;
    }

    /*
     * 帖子回复插入数据库
     */
    public function add_comment($data){
        $this->db->insert('comments',$data);

    }

    /*
     * 帖子评论修改
     */
    public function change_comment($fid,$id,$data){
        $this->db->where(array('id'=>$id, 'fid'=>$fid))->update('comments', $data);
    }

    /*
     * 帖子评论删除（更新楼层号！！！）
     */
    public function delete_comment($fid,$id){
        $this->db->where(array('id'=>$id, 'fid'=>$fid))->delete('comments');//删除帖子评论

    }
    public function update_floor($fid,$id,$data){
        $this->db->where(array('id'=>$id, 'fid'=>$fid))->update('comments', $data);
    }



}