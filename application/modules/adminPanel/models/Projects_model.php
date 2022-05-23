<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Projects_model extends MY_Model
{
	public $table = "projects p";
	public $select_column = ['p.id', 'p.p_name', 'p.location'];
	public $search_column = ['p.p_name', 'p.location'];
    public $order_column = [null, 'p.p_name', 'p.location', null];
	public $order = ['p.id' => 'DESC'];

	public function make_query()
	{
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('p.is_deleted', 0);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('p.id')
		         ->from($this->table)
				 ->where('p.is_deleted', 0);
		            	
		return $this->db->get()->num_rows();
	}

	public function assign_emps($proj_id)
	{
		$this->db->trans_start();

		$this->db->delete('employee_project', ['proj_id' => $proj_id]);
		
		$emps = array_map(function($e) use ($proj_id){ 
			return ['emp_id' => d_id($e), 'proj_id' => $proj_id];
		}, $this->input->post('emps'));
		
		$this->db->insert_batch('employee_project', $emps);
		
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
}