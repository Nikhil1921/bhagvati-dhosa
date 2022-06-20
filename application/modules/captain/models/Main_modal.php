<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Main_modal extends MY_Model
{
    public function getCurrentOrders($res_id)
    {
        if($this->input->get('status') && $this->input->get('status') === '1')
            $status = ['Running'];
        else
            $status = ['Running', 'Ongoing'];
            
        $orders = $this->db->select('o.id, o.or_id, o.status, o.pay_status, o.created_date, o.created_time, SUM(IF(io.status = "Delivered", 1, 0)) AS count')
                            ->where_in('o.status', $status)
                            ->where(['o.is_deleted' => 0])
                            ->where(['o.res_id' => $res_id])
                            ->join('item_orders io', 'io.or_id = o.id')
                            ->group_by('o.id')
                            ->get('orders o')
                            ->result();
        
        $orders = array_map(function($order){
            $order->tables = $this->db->select('to.t_id, t.t_name')
                                        ->where(['to.o_id' => $order->id])
                                        ->join('tables t', 'to.t_id = t.id')
                                        ->get('table_orders to')
                                        ->result();

            $order->items = $this->db->select('io.id, io.i_id, i.i_name, io.qty, io.price, io.pending_qty, io.remarks')
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
        $cart = $this->getCart();

        if(!$cart) return false;

        $or_id = $this->db->select('(count(id) + 1) AS total')
                          ->from('orders')
                          ->where(['is_deleted' => 0])
                          ->where('created_date', date('Y-m-d'))
                          ->get()
                          ->row();

        $order = [
            'or_id'        => $or_id->total,
            'res_id'       => $this->user->res_id,
            'created_date' => date('Y-m-d'),
            'created_time' => date('H:i:s')
        ];
        
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

    public function addOrder($post)
    {
        $cart = $this->getCart();

        if(!$cart) return false;

        $i_o = array_map(function($t) use ($post) {
            return [
                        'or_id'  => d_id($post['id']),
                        'i_id'  => $t['id'],
                        'qty'  => $t['qty'],
                        'pending_qty' => $t['qty'],
                        'price'  => $t['i_price'],
                        'remarks'  => $t['remarks'],
                        'e_id'  => $this->session->auth
                    ];
        }, $cart);

        $this->db->trans_start();

        $this->db->insert_batch('item_orders', $i_o);

        $this->db->delete('cart', ['emp_id' => $this->session->auth]);

        $this->db->trans_complete();
		
		return $this->db->trans_status();
    }

    public function cancelItem($id)
    {
        $item = $this->get('item_orders', 'qty, pending_qty', ['id' => $id]);

        if($item && $item['qty'] > 0){
            $post['qty'] = $item['qty'] - 1;
            $post['pending_qty'] = $item['pending_qty'] - 1;

            if($post['pending_qty'] === 0 || $post['qty'] === 0) $post['status'] = "Cancelled";

            return $this->update(['id' => $id], $post, 'item_orders');
        }else
            return false;
    }

    public function cancelOrder($id)
    {
        $items = array_map(function($i) {
            return [
                'id'           => $i['id'],
                'qty'          => 0,
                'pending_qty'  => 0,
                'status'       => "Cancelled",
            ];
        }, $this->getAll('item_orders', 'id', ['or_id' => $id]));

        $tables = array_map(function($table){
            return [
                'id'        => $table['t_id'],
                'is_booked' => 0
            ];
        }, $this->getAll('table_orders', 't_id', ['o_id' => $id]));

        if(!$items) return false;

        $this->db->trans_start();
        
        $this->db->update_batch('item_orders', $items, 'id');
        $this->db->update_batch('tables', $tables, 'id');
        $this->db->where(['id' => $id])->update('orders', ['status' => 'Cancelled']);

        $this->db->trans_complete();
		
		return $this->db->trans_status();
    }

    public function changeTable($o_id)
    {
        $book = array_map(function($table) use ($o_id) {
            return [
                't_id'   => d_id($table),
                'o_id'   => $o_id
            ];
        }, $this->input->post('tables'));

        $tables = array_merge(array_map(function($table){
            return [
                'id'        => $table['t_id'],
                'is_booked' => 0
            ];
        }, $this->getAll('table_orders', 't_id', ['o_id' => $o_id])), array_map(function($table){
            return [
                'id'        => d_id($table),
                'is_booked' => 1
            ];
        }, $this->input->post('tables')));
        
        $this->db->trans_start();

        $this->db->update_batch('tables', $tables, 'id');
        
        $this->db->delete('table_orders', ['o_id' => $o_id]);

        $this->db->insert_batch('table_orders', $book);

        $this->db->trans_complete();
		
		return $this->db->trans_status();
    }
}