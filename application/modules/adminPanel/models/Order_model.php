<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Order_model extends MY_Model
{
	public $table = "orders o";
	public $select_column = ['o.id', 'r.name', 'o.or_id', 'o.created_date', 'o.created_time', 'o.pay_status', 'o.discount', 'o.final_total'];
	public $search_column = ['r.name', 'o.or_id', 'o.created_date', 'o.created_time', 'o.pay_status', 'o.discount', 'o.final_total'];
    public $order_column = [null, 'r.name', 'o.or_id', 'o.created_date', 'o.pay_status', 'o.discount', 'o.final_total', null];
	public $order = ['o.id' => 'DESC'];

	public function make_query()
	{
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where(['o.status' => 'Completed'])
				 ->join('restaurants r', 'o.res_id = r.id');

		if($this->input->get('status'))
				 $this->db->where(['o.res_id' => d_id($this->input->get('status'))]);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('o.id')
		         ->from($this->table)
				 ->where(['o.status' => 'Completed'])
				 ->join('restaurants r', 'o.res_id = r.id');

		if($this->input->get('status'))
				 $this->db->where(['o.res_id' => d_id($this->input->get('status'))]);
		            	
		return $this->db->get()->num_rows();
	}
}