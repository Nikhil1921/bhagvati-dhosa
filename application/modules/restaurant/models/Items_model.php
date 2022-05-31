<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Items_model extends MY_Model
{
	public $table = "food_items i";
	public $select_column = ['i.id', 'i.i_name', 'i.i_price', 'i.wait_time', 'c.c_name'];
	public $search_column = ['i.i_name', 'i.i_price', 'i.wait_time', 'c.c_name'];
    public $order_column = [null, 'i.i_name', 'i.i_price', 'i.wait_time', 'c.c_name', null];
	public $order = ['i.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where(['c.is_deleted' => 0, 'i.is_deleted' => 0])
				 ->where('i.res_id', $this->user->res_id)
				 ->join('categories c', 'c.id = i.c_id');
		
		if($this->input->get('status'))
			$this->db->where('i.c_id', d_id($this->input->get('status')));

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('i.id')
		         ->from($this->table)
				 ->where(['c.is_deleted' => 0, 'i.is_deleted' => 0])
				 ->where('i.res_id', $this->user->res_id)
				 ->join('categories c', 'c.id = i.c_id');
		
		if($this->input->get('status'))
			$this->db->where('i.c_id', d_id($this->input->get('status')));
		            	
		return $this->db->get()->num_rows();
	}
}