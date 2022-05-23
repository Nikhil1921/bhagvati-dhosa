<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Employees_model extends MY_Model
{
	public $table = "employees e";
	public $select_column = ['e.id', 'e.name', 'e.mobile', 'e.unique_id', 'e.password', 'e.date_of_join', 'e.area_of_work'];
	public $search_column = ['e.name', 'e.mobile', 'e.unique_id', 'e.password', 'e.date_of_join', 'e.area_of_work'];
    public $order_column = [null, 'e.name', 'e.mobile', 'e.unique_id', 'e.password', 'e.date_of_join', 'e.area_of_work', null];
	public $order = ['e.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('e.is_deleted', 0);

		if ($this->input->get('status'))
			$this->db->where('ed.des_id', d_id($this->input->get('status')))->join('employee_designation ed', 'ed.emp_id = e.id','left');
	
        $this->datatable();
	}

	public function count()
	{
		$this->db->select('e.id')
		         ->from($this->table)
				 ->where('e.is_deleted', 0);
		
		if ($this->input->get('status'))
			$this->db->where('ed.des_id', d_id($this->input->get('status')))->join('employee_designation ed', 'ed.emp_id = e.id','left');
		
		return $this->db->get()->num_rows();
	}
	
	public function getEmp($where)
	{
		$this->db->select('e.name, e.mobile, e.unique_id, e.date_of_join, e.area_of_work, ed.des_id')
		         ->from($this->table)
				 ->where($where)
				 ->where('e.is_deleted', 0)
				 ->join('employee_designation ed', 'ed.emp_id = e.id','left');
		            	
		return $this->db->get()->row_array();
	}

	public function add_update($id)
	{
		$des_id = d_id($this->input->post('des_id'));
		$post = [
			'name' => $this->input->post('name'),
			'mobile' => $this->input->post('mobile'),
			'unique_id' => $this->input->post('unique_id'),
			'date_of_join' => $this->input->post('date_of_join'),
			'area_of_work' => $this->input->post('area_of_work'),
			'update_at' => time(),
		];

		if ($this->input->post('password'))
			$post['password'] = my_crypt($this->input->post('password'));

		if ($id === 0) $post['create_at'] = $post['update_at'];
		
		$this->db->trans_start();

		if ($id === 0){
			$this->db->insert('employees', $post);
			$e_id = $this->db->insert_id();
			$this->db->insert('employee_designation', ['emp_id' => $e_id, 'des_id' => $des_id]);
		}else{
			$this->db->update('employees', $post, ['id' => $id]);
			$this->db->update('employee_designation', ['des_id' => $des_id], ['emp_id' => $id]);
		}

		$this->db->trans_complete();

		return $this->db->trans_status();
	}
}