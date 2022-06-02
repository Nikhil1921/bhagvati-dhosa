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
                    'role'      => 'Admin',
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
            ] */
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
}