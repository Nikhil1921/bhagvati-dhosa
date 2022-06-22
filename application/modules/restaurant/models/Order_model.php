<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Order_model extends MY_Model
{
	public $table = "orders o";
	public $select_column = ['o.id', 'o.or_id', 'o.created_date', 'o.created_time', 'o.pay_status', 'o.discount', 'o.final_total'];
	public $search_column = ['o.or_id', 'o.created_date', 'o.created_time', 'o.pay_status', 'o.discount', 'o.final_total'];
    public $order_column = [null, 'o.or_id', 'o.created_date', 'o.pay_status', 'o.discount', 'o.final_total', null];
	public $order = ['o.id' => 'DESC'];

	public function make_query()
	{
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where(['o.res_id' => $this->user->res_id, 'o.status' => 'Completed']);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('o.id')
		         ->from($this->table)
				 ->where(['o.res_id' => $this->user->res_id, 'o.status' => 'Completed']);
		            	
		return $this->db->get()->num_rows();
	}
}