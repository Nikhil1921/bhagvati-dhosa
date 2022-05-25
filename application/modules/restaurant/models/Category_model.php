<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Category_model extends MY_Model
{
	public $table = "categories c";
	public $select_column = ['c.id', 'c.c_name'];
	public $search_column = ['c.c_name'];
    public $order_column = [null, 'c.c_name', null];
	public $order = ['c.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('c.is_deleted', 0)
				 ->where('c.res_id', $this->user->res_id);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('c.id')
		         ->from($this->table)
				 ->where('c.is_deleted', 0)
				 ->where('c.res_id', $this->user->res_id);
		            	
		return $this->db->get()->num_rows();
	}
}