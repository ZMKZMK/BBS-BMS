<?php if( ! defined('BASEPATH')) exit('No direct script access allowed!')?>
<?php
/**
 * 帖子插入、删除与编辑模型
 */
class send_model extends CI_Model
{
    /*
     * 添加
     */
    public function add($data){
        $this->db->insert('news',$data);
    }

    /*
     * 删除
     */
    public function delete($id){
        $this->db->where('id', $id)->delete('news');//删除帖子
        $this->db->where('id',$id)->delete('comments');//删除评论
    }

    /*
     * 帖子修改（更新）
     */
    public function change($data){
        $this->db->where('id', $data['id'])->update('news', $data);
    }


}