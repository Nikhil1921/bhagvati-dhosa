<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Main_modal extends MY_Model
{
    public function checkAccess($name, $operation)
    { 
        $access = [
            /* 'category' => [
                [
                    'role'      => 'Accountant',
                    'operation' => ['list', 'add_update', 'delete']
                ],
                [
                    'role'      => 'Accountant',
                    'operation' => ['list']
                ]
            ],
            'items' => [
                [
                    'role'      => 'Admin',
                    'operation' => ['list', 'add_update', 'delete']
                ]
            ], */
            'orders' => [
                [
                    'role'      => 'Accountant',
                    'operation' => ['list']
                ],
                [
                    'role'      => 'Shef',
                    'operation' => ['list']
                ]
            ],
        ];
        
        if(isset($access[$name]))
            return array_filter($access[$name], function($ac) use($operation) {
                return $ac['role'] === $this->user->role && in_array($operation, $ac['operation']) ? true : false;
            }) ? true : false;
        else
            return false;
    }

    public function getCurrentOrders($res_id)
    {
        if($this->input->get('status') && $this->input->get('status') === '1')
            $status = ['Running'];
        elseif($this->user->role === 'Shef')
            $status = ['Ongoing'];
        /* elseif($this->user->role === 'Accountant')
            $status = ['Completed']; */
        else
            $status = ['Running', 'Ongoing'];

        $this->db->select('o.id, o.or_id, o.status, o.pay_status, o.created_date, o.created_time')
                 ->where_in('o.status', $status)
                 ->where(['o.is_deleted' => 0]);

        if($this->user->role === '') $this->db->join('item_orders io', 'io.or_id = o.id')->where(['io.status' => 'Pending'])->group_by('o.id');

        $orders = $this->db->get('orders o')->result();
        
        $orders = array_map(function($order){
            $order->tables = $this->db->select('to.t_id, t.t_name')
                                        ->where(['to.o_id' => $order->id])
                                        ->join('tables t', 'to.t_id = t.id')
                                        ->get('table_orders to')
                                        ->result();

            $order->items = $this->db->select('io.id, io.i_id, i.i_name, io.qty, io.price, io.pending_qty, remarks')
                                        ->where(['io.or_id' => $order->id])
                                        ->where(['io.status != ' => 'Cancelled'])
                                        ->join('food_items i', 'io.i_id = i.id')
                                        ->get('item_orders io')
                                        ->result();

            return $order;
        }, $orders);

        return $orders;
    }

    public function deliverItem($id)
    {
        $item = $this->get('item_orders', 'qty, pending_qty, or_id', ['id' => $id]);
        
        if($item && $item['pending_qty'] > 0){
            $post['pending_qty'] = $item['pending_qty'] - 1;

            if($post['pending_qty'] === 0) $post['status'] = "Delivered";

            $u_id = $this->update(['id' => $id], $post, 'item_orders');
            
            if($u_id && ! $this->get('item_orders', 'or_id', ['or_id' => $item['or_id'], 'status' => 'Pending']))
                $this->update(['id' => $item['or_id']], ['status' => "Running"], 'orders');

            return $u_id;
        }else
            return false;
    }

    public function payOrder($id)
    {
        $tables = array_map(function($table){
            return [
                'id'        => $table['t_id'],
                'is_booked' => 0
            ];
        }, $this->getAll('table_orders', 't_id', ['o_id' => $id]));

        $this->db->trans_start();
        
        $this->db->update_batch('tables', $tables, 'id');
        $this->db->where(['id' => $id])->update('orders', ['pay_status' => 'Paid', 'status' => 'Completed']);

        $this->db->trans_complete();
		
		return $this->db->trans_status();
    }
}