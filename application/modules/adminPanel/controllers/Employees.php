<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends Admin_controller  {

    public function __construct()
	{
		parent::__construct();
		$this->path = $this->config->item('users');
        $this->designations = $this->main->getAll('designations', 'id, designation', ['is_deleted' => 0]);
	}

	protected $table = 'employees';
	protected $redirect = 'employees';
	protected $title = 'Employee';
	protected $name = 'employees';
	
	public function index()
	{
        $data['title'] = $this->title;
        $data['name'] = $this->name;
        $data['url'] = $this->redirect;
        $data['operation'] = "List";
        $data['datatable'] = "$this->redirect/get";
		
		return $this->template->load('template', "$this->redirect/home", $data);
	}

    public function get()
    {
        check_ajax();
        $this->load->model('Employees_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $this->input->get('start') + 1;
        $data = [];

        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->name;
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->unique_id;
            $sub_array[] = my_crypt($row->password, 'd');
            $sub_array[] = date('d-m-Y', strtotime($row->date_of_join));
            $sub_array[] = $row->area_of_work;

            $action = '<div class="btn-group" role="group"><button class="btn btn-success dropdown-toggle" id="btnGroupVerticalDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon-settings"></span></button><div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" x-placement="bottom-start">';
            
            $action .= anchor($this->redirect."/add-update/".e_id($row->id), '<i class="fa fa-edit"></i> Edit</a>', 'class="dropdown-item"');

            $action .= form_open($this->redirect.'/delete', 'id="'.e_id($row->id).'"', ['id' => e_id($row->id)]).
                '<a class="dropdown-item" onclick="script.delete('.e_id($row->id).'); return false;" href=""><i class="fa fa-trash"></i> Delete</a>'.
                form_close();

            $action .= '</div></div>';
            $sub_array[] = $action;
            
            $data[] = $sub_array;
            $sr++;
        }

        $output = [
            "draw"              => intval($this->input->get('draw')),  
            "recordsTotal"      => $this->data->count(),
            "recordsFiltered"   => $this->data->get_filtered_data(),
            "data"              => $data
        ];
        
        die(json_encode($output));
    }

    public function add_update($id=0)
	{
        $this->load->model('employees_model');

        $this->form_validation->set_rules($this->validate);

        if ($this->form_validation->run() == FALSE)
        {
            $data['title'] = $this->title;
            $data['name'] = $this->name;
            $data['operation'] = $id === 0 ? "Add" : "Update";
            $data['url'] = $this->redirect;

            if($id !== 0) $data['data'] = $this->employees_model->getEmp(['id' => d_id($id)]);
            
            return $this->template->load('template', "$this->redirect/form", $data);
        }else{
            $uid = $this->employees_model->add_update(d_id($id));

            $msg = ($id === 0) ? 'added' : 'updated';

            flashMsg($uid, "$this->title $msg.", "$this->title not $msg. Try again.", $this->redirect);
        }
	}

    public function delete()
    {
        $this->form_validation->set_rules('id', 'id', 'required|is_natural');
        
        if ($this->form_validation->run() == FALSE)
            flashMsg(0, "", "Some required fields are missing.", $this->redirect);
        else{
            $id = $this->main->update(['id' => d_id($this->input->post('id'))], ['is_deleted' => 1], $this->table);
            flashMsg($id, "$this->title deleted.", "$this->title not deleted.", $this->redirect);
        }
    }

    public function mobile_check($str)
    {
        $id = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
        
        $where = ['mobile' => $str, 'id != ' => d_id($id)];
        
        if ($this->main->check($this->table, $where, 'id'))
        {
            $this->form_validation->set_message('mobile_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function unique_id_check($str)
    {   
        $id = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
        
        $where = ['unique_id' => $str, 'id != ' => d_id($id)];
        
        if ($this->main->check($this->table, $where, 'id'))
        {
            $this->form_validation->set_message('unique_id_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function password_check($str)
    {   
        if (!$this->uri->segment(4) && !$str)
        {
            $this->form_validation->set_message('password_check', '%s is required');
            return FALSE;
        } else
            return TRUE;
    }

    protected $validate = [
        [
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|max_length[50]|alpha_numeric_spaces|trim',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 50 chars allowed.",
                'alpha_numeric_spaces' => "Only characters and numbers are allowed.",
            ],
        ],
        [
            'field' => 'mobile',
            'label' => 'Mobile no.',
            'rules' => 'required|exact_length[10]|is_numeric|callback_mobile_check|trim',
            'errors' => [
                'required' => "%s is required",
                'exact_length' => "%s is invalid",
                'is_numeric' => "%s is invalid",
            ],
        ],
        [
            'field' => 'unique_id',
            'label' => 'Unique ID',
            'rules' => 'required|max_length[30]|is_numeric|callback_unique_id_check|trim',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 30 chars allowed.",
                'is_numeric' => "%s is invalid",
            ],
        ],
        [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'max_length[100]|callback_password_check|trim',
            'errors' => [
                'max_length' => "Max 100 chars allowed.",
            ],
        ],
        [
            'field' => 'date_of_join',
            'label' => 'Date of join',
            'rules' => 'required|trim',
            'errors' => [
                'required' => "%s is required",
            ],
        ],
        [
            'field' => 'area_of_work',
            'label' => 'Area of work',
            'rules' => 'required|in_list[Field Work,Office Work]|trim',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 100 chars allowed.",
                'in_list' => "%s is invalid",
            ],
        ],
        [
            'field' => 'des_id',
            'label' => 'Designation',
            'rules' => 'required|is_numeric|trim',
            'errors' => [
                'required' => "%s is required",
                'is_numeric' => "%s is invalid",
            ],
        ],
    ];
}