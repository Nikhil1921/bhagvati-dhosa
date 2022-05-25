<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Tables_model extends MY_Model
{
	public $table = "tables t";
	public $select_column = ['t.id', 't.t_name'];
	public $search_column = ['t.t_name'];
    public $order_column = [null, 't.t_name', null];
	public $order = ['t.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('t.is_deleted', 0)
				 ->where('t.res_id', $this->user->res_id);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('t.id')
		         ->from($this->table)
				 ->where('t.is_deleted', 0)
				 ->where('t.res_id', $this->user->res_id);
		            	
		return $this->db->get()->num_rows();
	}
}