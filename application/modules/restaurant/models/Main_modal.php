<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Main_modal extends Admin_model
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
            // $status = ['Ongoing'];
            $status = ['Running', 'Ongoing'];
        /* elseif($this->user->role === 'Accountant')
            $status = ['Completed']; */
        else
            $status = ['Running', 'Ongoing'];

        $this->db->select('o.id, o.or_id, o.status, o.pay_status, o.created_date, o.created_time, SUM(IF(io.status = "Pending", 1, 0)) AS count')
                 ->where_in('o.status', $status)
                 ->where(['o.is_deleted' => 0])
                 ->join('item_orders io', 'io.or_id = o.id')
                 ->group_by('o.id');

        if($this->user->role === '') $this->db->where(['io.status' => 'Pending']);

        $orders = $this->db->order_by('o.status '.($this->user->role === 'Shef' ? 'ASC' : 'DESC'))->get('orders o')->result();
        
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

    public function getOrder($id)
    {
        return $this->db->select('o.or_id, o.pay_status, SUM(io.price * io.qty) as total, o.pay_type')
                        ->where(['o.is_deleted' => 0, 'o.id' => $id])
                        ->join('item_orders io', 'io.or_id = o.id')
                        ->group_by('o.id')
                        ->get('orders o')->row();
    }
}