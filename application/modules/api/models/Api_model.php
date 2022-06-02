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
            'or_id'        => date('dmY').$or_id->total,
            'res_id'       => $post['res_id'],
            'created_date' => date('Y-m-d'),
            'created_time' => date('H:i:s')
        ];
        
        $this->db->trans_start();

        $this->db->insert('orders', $order);
        $or = $this->db->insert_id();

        $tabs = array_map(function($t) use ($or) {
            $this->db->update('tables', ['is_booked' => 1], ['id' => $t]);
            return ['t_id' => $t, 'o_id' => $or];
        }, $post['t_id']);

        $this->db->insert_batch('table_orders', $tabs);

        foreach ($post['i_id'] as $k => $i) {
            $i_o[] = [
                'or_id'  => $or,
                'i_id'  => $i,
                'qty'  => $post['qty'][$k],
                'pending_qty' => $post['qty'][$k],
                'price'  => $post['price'][$k],
                'e_id'  => $this->api
            ];
        }

        $this->db->insert_batch('item_orders', $i_o);

        $this->db->trans_complete();
		
		return $this->db->trans_status();
    }

    public function ordersList($get)
    {
        $orders = $this->db->select('to.o_id, o.or_id, o.status, o.pay_status, o.created_date, o.created_time')
                            ->from('table_orders to')
                            ->join('orders o', 'to.o_id = o.id')
                            ->group_by('to.o_id')
                            ->get()
                            ->result();
                            
        $orders = array_map(function($order){

            $order->items = $this->db->select('io.id, io.price, io.qty, io.i_id, io.status, i.i_name')
                                     ->from('item_orders io')
                                     ->where(['io.or_id' => $order->o_id])
                                     ->join('food_items i', 'i.id = io.i_id')
                                     ->get()
                                     ->result();

            $order->tables = $this->db->select('t_name')
                                     ->from('table_orders to')
                                     ->where(['to.o_id' => $order->o_id])
                                     ->join('tables t', 't.id = to.t_id')
                                     ->get()
                                     ->result();
            return $order;

        }, $orders);

        return $orders;
    }
}