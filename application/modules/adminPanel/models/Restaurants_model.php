<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Restaurants_model extends MY_Model
{
	public $table = "restaurants r";
	public $select_column = ['r.id', 'r.name', 'r.c_name', 'r.mobile', 'r.email'];
	public $search_column = ['r.name', 'r.c_name', 'r.mobile', 'r.email'];
    public $order_column = [null, 'r.name', 'r.c_name', 'r.mobile', 'r.email', null];
	public $order = ['r.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('r.is_deleted', 0);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('r.id')
		         ->from($this->table)
				 ->where('r.is_deleted', 0);
		            	
		return $this->db->get()->num_rows();
	}
}