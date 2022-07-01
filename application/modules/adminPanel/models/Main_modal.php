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
        $orders = $this->db->select("SUM(io.qty) AS items_sold, COUNT(DISTINCT o.id) AS orders")
                      ->from('item_orders io')
                      ->join('orders o', 'io.or_id = o.id')
                      ->where(['io.status' => 'Delivered'])
                      ->where(['o.status' => 'Completed', 'o.pay_status' => 'Paid'])
                      ->get()->row_array();

        $revenue = $this->db->select("SUM(o.final_total) AS revenue")
                      ->from('orders o')
                      ->where(['o.status' => 'Completed', 'o.pay_status' => 'Paid'])
                      ->get()->row_array();

        return array_merge($revenue, $orders);
    }

    public function daily_totals($date)
    {
        $revenue = $this->db->select("SUM(o.final_total) AS revenue")
                            ->from('orders o')
                            ->where(['o.status' => 'Completed', 'o.pay_status' => 'Paid'])
                            ->where('created_date', $date)
                            ->get()->row_array();

        $expense = $this->db->select("SUM(price) AS expense")
                            ->from('expenses')
                            ->where(['is_deleted' => 0])
                            ->where(['created_date' => $date])
                            ->get()->row_array();
        
        return $revenue['revenue'] - $expense['expense'];
    }
}