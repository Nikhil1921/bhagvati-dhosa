<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Api_model extends MY_Model
{
    protected $table = 'employees';

    public function getProfile($where)
    {
        return $this->db->select('id, name, email, mobile, res_id')
                        ->from($this->table)
                        ->where($where)
                        ->where(['is_deleted' => 0])
                        ->where(['role' => 'Captain'])
                        ->get()
                        ->row_array();
    }

    public function getCats($res_id)
    {
        return $this->db->select('id, c_name')
                        ->from('categories')
                        ->where(['res_id' => $res_id])
                        ->where(['is_deleted' => 0])
                        ->get()
                        ->result();
    }

    public function getItems($where)
    {
        return $this->db->select('id, i_name, i_price, description')
                        ->from('food_items')
                        ->where($where)
                        ->where(['is_deleted' => 0])
                        ->get()
                        ->result();
    }
}