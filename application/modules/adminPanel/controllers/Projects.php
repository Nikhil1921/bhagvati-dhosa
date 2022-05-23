<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends Admin_controller  {

    public function __construct()
	{
		parent::__construct();
		$this->path = $this->config->item('designation');
	}

	private $table = 'projects';
	protected $redirect = 'projects';
	protected $title = 'Project';
	protected $name = 'projects';
	
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
        $this->load->model('Projects_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $this->input->get('start') + 1;
        $data = [];

        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->p_name;
            $sub_array[] = $row->location;

            $action = '<div class="btn-group" role="group"><button class="btn btn-success dropdown-toggle" id="btnGroupVerticalDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="icon-settings"></span></button><div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" x-placement="bottom-start">';
            
            $action .= anchor($this->redirect."/add-update/".e_id($row->id), '<i class="fa fa-edit"></i> Edit</a>', 'class="dropdown-item"');
            $action .= anchor($this->redirect."/assign-emps/".e_id($row->id), '<i class="fa fa-users"></i> Assign</a>', 'class="dropdown-item"');

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
        $this->form_validation->set_rules($this->validate);

        if ($this->form_validation->run() == FALSE)
        {
            $data['title'] = $this->title;
            $data['name'] = $this->name;
            $data['operation'] = $id === 0 ? "Add" : "Update";
            $data['url'] = $this->redirect;

            if($id !== 0) $data['data'] = $this->main->get($this->table, 'p_name, location', ['id' => d_id($id)]);
            
            return $this->template->load('template', "$this->redirect/form", $data);
        }else{
            $post = [
                'p_name'   => $this->input->post('p_name'),
                'location' => $this->input->post('location')
            ];
                
            $uid = ($id === 0) ? $this->main->add($post, $this->table) : $this->main->update(['id' => d_id($id)], $post, $this->table);
            $msg = ($id === 0) ? 'added' : 'updated';

            flashMsg($uid, "$this->title $msg.", "$this->title not $msg. Try again.", $this->redirect);
        }
	}

    public function assign_emps($id)
	{
        $this->load->model('projects_model');
        $this->form_validation->set_rules('emps[]', 'Employees', 'required', ['required' => "%s are required"]);

        if ($this->form_validation->run() === TRUE)
        {
            $uid = $this->projects_model->assign_emps(d_id($id));

            flashMsg($uid, "Employees assigned to project.", "Employees not assigned to project. Try again.", $this->redirect);
        }else{
            $data['title'] = $this->title;
            $data['name'] = $this->name;
            $data['operation'] = $id === 0 ? "Add" : "Update";
            $data['url'] = $this->redirect;

            $data['data'] = $this->main->get($this->table, 'p_name, location', ['id' => d_id($id)]);
            $data['emps'] = array_map(function($e){ return $e['emp_id']; }, $this->main->getAll('employee_project', 'emp_id', ['proj_id' => d_id($id)]));
            $data['employees'] = $this->main->getAll('employees', 'id, name', ['is_deleted' => 0]);
            
            return $this->template->load('template', "$this->redirect/assign_emps", $data);
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

    protected $validate = [
        [
            'field' => 'p_name',
            'label' => 'Project name',
            'rules' => 'required|max_length[100]|trim',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 100 chars allowed.",
            ],
        ],
        [
            'field' => 'location',
            'label' => 'Project location',
            'rules' => 'required|max_length[100]|trim',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 100 chars allowed.",
            ],
        ]
    ];
}