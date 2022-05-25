<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Restaurants_model extends MY_Model
{
	public $table = "restaurants r";
	public $select_column = ['r.id', 'r.name', 'e.name AS c_name', 'e.mobile', 'e.email'];
	public $search_column = ['r.name', 'e.name', 'e.mobile', 'e.email'];
    public $order_column = [null, 'r.name', 'e.name', 'e.mobile', 'e.email', null];
	public $order = ['r.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
				 ->where('r.is_deleted', 0)
				 ->where('e.is_deleted', 0)
				 ->where('e.role', 'Admin')
				 ->join('employees e', 'e.res_id = r.id');

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('r.id')
		         ->from($this->table)
				 ->where('r.is_deleted', 0)
				 ->where('e.is_deleted', 0)
				 ->where('e.role', 'Admin')
				 ->join('employees e', 'e.res_id = r.id');
		            	
		return $this->db->get()->num_rows();
	}

	public function get($table, $select, $where)
	{
		$this->db->select($select)
		         ->from($this->table)
				 ->where('r.is_deleted', 0)
				 ->where($where)
				 ->join('employees e', 'e.res_id = r.id');
		            	
		return $this->db->get()->row_array();
	}

	public function add_update($id, $img)
	{
		$emp = $id === 0 ? [] : $this->get('', 'e.id', ['r.id' => $id]);
		
		$post = [
			'name'    => $this->input->post('name'),
			'address' => $this->input->post('address'),
			'logo'    => $img
		];
		
		$this->db->trans_start();
		
		if(!$emp)
		{
			$this->db->insert('restaurants', $post);
			$res_id = $this->db->insert_id();
			$this->db->insert('waiting_time', ['stove' => 1, 'w_time' => 2, 'res_id' => $res_id]);
		}else{
			$this->db->update('restaurants', $post, ['id' => $id]);
			$res_id = $id;
		}
		
		$post = [
			'name'    => $this->input->post('c_name'),
			'mobile'  => $this->input->post('mobile'),
			'email'   => $this->input->post('email'),
			'res_id'  => $res_id
		];

		if ($this->input->post('password'))
			$post['password'] = my_crypt($this->input->post('password'));

		if(!$emp)
			$this->db->insert('employees', $post);
		else
			$this->db->update('employees', $post, ['id' => $emp['id']]);

		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}

	public function delete($id, $table)
	{
		$this->db->trans_start();

		$this->db->update($table, ['is_deleted' => 1], ['id' => $id]);
		$this->db->update('employees', ['is_deleted' => 1], ['res_id' => $id]);

		$this->db->trans_complete();

		return $this->db->trans_status();
	}
}