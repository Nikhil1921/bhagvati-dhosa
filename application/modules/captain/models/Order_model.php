<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Order_model extends MY_Model
{
	public $table = "orders o";
	public $select_column = ['o.id', 'o.or_id', 'o.created_date', 'o.created_time', 'o.pay_status'];
	public $search_column = ['o.or_id', 'o.created_date', 'o.created_time', 'o.pay_status'];
    public $order_column = [null, 'o.or_id', 'o.created_date', 'o.pay_status', null];
	public $order = ['o.id' => 'DESC'];

	public function make_query()
	{
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where(['io.e_id' => $this->session->auth, 'o.status' => 'Completed'])
				 ->where(['io.status' => 'Delivered'])
				 ->join('item_orders io', 'io.or_id = o.id')
				 ->group_by('o.id');

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('o.id')
		         ->from($this->table)
				 ->where(['io.e_id' => $this->session->auth, 'o.status' => 'Completed'])
				 ->where(['io.status' => 'Delivered'])
				 ->join('item_orders io', 'io.or_id = o.id')
				 ->group_by('o.id');
		            	
		return $this->db->get()->num_rows();
	}
}