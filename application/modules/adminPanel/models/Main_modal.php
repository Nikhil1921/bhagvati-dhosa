<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Main_modal extends MY_Model
{
    public function bulk_upload($post, $table)
    {
        return $this->db->insert_batch($table, $post);
    }

    public function totals()
    {
        return $this->db->select("COUNT(o.id) AS orders, SUM(io.qty) AS items_sold, SUM(o.final_total) AS revenue")
                        ->from('orders o')
                        ->join('item_orders io', 'io.or_id = o.id')
                        ->where(['io.status' => 'Delivered'])
                        ->where(['o.status' => 'Completed', 'o.pay_status' => 'Paid'])
                        ->group_by('o.id')
                        ->get()->row_array();
    }
}