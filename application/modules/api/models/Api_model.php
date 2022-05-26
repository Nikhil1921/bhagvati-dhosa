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

    public function getTables($where)
    {
        $return = array_map(function($book) use ($where) {
            return $this->db->select('id, t_name')
                                        ->from('tables')
                                        ->where($where)
                                        ->where(['is_deleted' => 0])
                                        ->where(['is_booked' => $book])
                                        ->get()
                                        ->result();
        }, ['booked' => 1, 'unbooked' => 0]);

        return $return;
    }
    
    public function addOrder($post)
    {
        $or_id = $this->db->select('(count(id) + 1) AS total')
                 ->from('orders')
                 ->where(['is_deleted' => 0])
                 ->where('created_date', date('Y-m-d'))
                 ->get()
                 ->row();
        
        $order = [
            't_id'       => $post['t_id'],
            'or_id'      => date('dmY').$or_id->total,
            'created_date' => date('Y-m-d'),
            'created_time' => date('H:i:s')
        ];
        
        $this->db->trans_start();

        $this->db->insert('orders', $order);
        $or = $this->db->insert_id();

        $i_o = [
            'or_id'  => $or,
            'i_id'  => $post['i_id'],
            'qty'  => $post['qty'],
            'price'  => $post['price'],
            'e_id'  => $this->api
        ];

        $this->db->insert('item_orders', $i_o);

        $this->db->update('tables', ['is_booked' => 1], ['id' => $post['t_id']]);

        $this->db->trans_complete();
		
		return $this->db->trans_status();
    }

    public function ordersList($get)
    {
        return $this->db->select('*')
                        ->from('orders')
                        /* ->where(['is_deleted' => 0])
                        ->where('created_date', $get['date']) */
                        ->get()
                        ->result();
    }
}