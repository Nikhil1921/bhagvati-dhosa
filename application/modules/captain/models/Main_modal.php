<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Main_modal extends MY_Model
{
    public function getCurrentOrders($res_id)
    {
        $orders = $this->db->select('id, or_id, status, pay_status, created_date, created_time')
                            ->where(['status' => 'Ongoing'])
                            ->where(['is_deleted' => 0])
                            ->where(['res_id' => $res_id])
                            ->get('orders')
                            ->result();

        $orders = array_map(function($order){
            $order->tables = $this->db->select('to.t_id, t.t_name')
                                        ->where(['to.o_id' => $order->id])
                                        ->join('tables t', 'to.t_id = t.id')
                                        ->get('table_orders to')
                                        ->result();

            $order->items = $this->db->select('io.id, io.i_id, i.i_name, io.qty, io.price, io.pending_qty')
                                        ->where(['io.or_id' => $order->id])
                                        ->join('food_items i', 'io.i_id = i.id')
                                        ->get('item_orders io')
                                        ->result();

            return $order;
        }, $orders);

        return $orders;
    }

    public function saveToCart($post)
    {
        $this->db->trans_start();

        $this->db->delete('cart', ['emp_id' => $this->session->auth]);

        if(isset($post['items'])){

            $cart = array_map(function($item){
                
                $item['item'] = d_id($item['item']);
                $item['emp_id'] = $this->session->auth;
                $item['remarks'] = isset($item['remarks']) ? $item['remarks'] : '';

                return $item;
            }, $post['items']);

            $this->db->insert_batch('cart', $cart);
        }
        
        $this->db->trans_complete();
		
		return $this->db->trans_status();
    }

    public function getCart()
    {
        return $this->db->select('c.qty, c.remarks, i.i_name, i.id, i.i_price, i.wait_time, i.description, IF(i.special_item = 0, "Normal", "Special") AS special_item')
                        ->from('cart c')
                        ->where('c.emp_id', $this->session->auth)
                        ->join('food_items i', 'i.id = c.item')
                        ->get()->result_array();
    }

    public function saveOrder()
    {
        $or_id = $this->db->select('(count(id) + 1) AS total')
                          ->from('orders')
                          ->where(['is_deleted' => 0])
                          ->where('created_date', date('Y-m-d'))
                          ->get()
                          ->row();

        $order = [
            'or_id'        => date('dmY').$or_id->total,
            'res_id'       => $this->user->res_id,
            'created_date' => date('Y-m-d'),
            'created_time' => date('H:i:s')
        ];

        $cart = $this->getCart();
        
        $this->db->trans_start();

        $this->db->insert('orders', $order);
        $or = $this->db->insert_id();
        
        $tabs = array_map(function($t) use ($or) {
            $this->db->update('tables', ['is_booked' => 1], ['id' => d_id($t)]);
            return ['t_id' => d_id($t), 'o_id' => $or];
        }, $this->input->post('tables'));

        $this->db->insert_batch('table_orders', $tabs);

        $i_o = array_map(function($t) use ($or) {
            return [
                        'or_id'  => $or,
                        'i_id'  => $t['id'],
                        'qty'  => $t['qty'],
                        'pending_qty' => $t['qty'],
                        'price'  => $t['i_price'],
                        'remarks'  => $t['remarks'],
                        'e_id'  => $this->session->auth
                    ];
        }, $cart);

        $this->db->insert_batch('item_orders', $i_o);

        $this->db->delete('cart', ['emp_id' => $this->session->auth]);

        $this->db->trans_complete();
		
		return $this->db->trans_status();
    }
}