<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Main_modal extends Admin_model
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
                            ->order_by('o.status ASC')
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
}