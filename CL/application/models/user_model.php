<?php if( ! defined('BASEPATH')) exit('No direct script access allowed!')?>
<?php
/**
 * Created by PhpStorm.
 * User: Ming
 * Date: 2017/6/9
 * Time: 1:00
 */
class user_model extends CI_Model
{
    /*
     * 获取所有用户信息
     */
    public function get_user_info(){
        $data = $this->db->get('user')->result_array();
        return $data;
    }
    /*
     * 获取单独用户信息
     */
    public function get_a_user_info($uid){
        $data = $this->db->where(array('uid'=>$uid))->get('user')->result_array();
        return $data;
    }

    /*
     * 删除用户信息
     */
    public function delete_user_info($uid){
        $this->db->where('uid',$uid)->delete('user');

    }

    /*
     * 修改用户信息
     */
    public function change_user_info($uid,$data){
        $this->db->where('uid',$uid)->update('user', $data);

    }

}