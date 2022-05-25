<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Expenses_model extends MY_Model
{
	public $table = "expenses e";
	public $select_column = ['e.id', 'e.expense', 'e.price', 'e.created_at'];
	public $search_column = ['e.expense', 'e.price', 'e.created_at'];
    public $order_column = [null, 'e.expense', 'e.price', 'e.created_at', null];
	public $order = ['e.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('e.is_deleted', 0)
				 ->where('e.res_id', $this->user->res_id);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('e.id')
		         ->from($this->table)
				 ->where('e.is_deleted', 0)
				 ->where('e.res_id', $this->user->res_id);
		            	
		return $this->db->get()->num_rows();
	}
}