<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends Admin_controller  {

    public function __construct()
	{
		parent::__construct();
        $this->cats = $this->main->getAll('categories', 'id, c_name', ['is_deleted' => 0, 'res_id' => $this->user->res_id]);
	}

	private $table = 'food_items';
	protected $redirect = 'items';
	protected $title = 'Food item';
	protected $name = 'items';
	
	public function index()
	{
        check_access($this->name, 'list');
        
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
        $this->load->model('Items_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $this->input->get('start') + 1;
        $data = [];

        $edit = verify_access($this->name, 'add_update');
        $delete = verify_access($this->name, 'delete');

        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->i_name;
            $sub_array[] = $row->i_price;
            $sub_array[] = $row->wait_time;
            $sub_array[] = $row->c_name;

            $action = '<div class="basic-dropdown">
                        <div class="dropdown">
                            <button type="button" class="btn btn-outline-primary btn-xs dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-cogs"></i>
                            </button>
                            <div class="dropdown-menu" style="">';
                            
            if($edit)
                $action .= anchor($this->redirect."/add-update/".e_id($row->id), '<i class="fa fa-edit"></i> Edit</a>', 'class="dropdown-item"');
            
            if($delete)
                $action .= form_open($this->redirect.'/delete', 'id="'.e_id($row->id).'"', ['id' => e_id($row->id)]).
                    '<a class="dropdown-item" onclick="script.delete('.e_id($row->id).'); return false;" href=""><i class="fa fa-trash"></i> Delete</a>'.
                    form_close();

            $action .= '</div></div></div>';
            
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
        check_access($this->name, 'add_update');

        $this->form_validation->set_rules($this->validate);

        $data['title'] = $this->title;
        $data['name'] = $this->name;
        $data['operation'] = $id === 0 ? "Add" : "Update";
        $data['url'] = $this->redirect;

        if($id !== 0) $data['data'] = $this->main->get($this->table, 'i_name, i_price, description, c_id, wait_time', ['id' => d_id($id)]);
        
        if ($this->form_validation->run() == FALSE)
        {
            return $this->template->load('template', "$this->redirect/form", $data);
        }else{
            $post = [
                'i_name'       => $this->input->post('i_name'),
                'i_price'      => $this->input->post('i_price'),
                'description'  => $this->input->post('description'),
                'wait_time'    => $this->input->post('wait_time'),
                'c_id'         => d_id($this->input->post('c_id')),
                'res_id'       => $this->user->res_id
            ];

            $uid = ($id === 0) ? $this->main->add($post, $this->table) : $this->main->update(['id' => d_id($id)], $post, $this->table);
            $msg = ($id === 0) ? 'added' : 'updated';

            flashMsg($uid, "$this->title $msg.", "$this->title not $msg. Try again.", $this->redirect);
        }
	}

    public function delete()
    {   
        check_access($this->name, 'delete');

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
            'field' => 'c_id',
            'label' => 'Category',
            'rules' => 'required|is_natural|trim',
            'errors' => [
                'required' => "%s is required",
                'is_natural' => "%s is invalid",
            ],
        ],
        [
            'field' => 'i_name',
            'label' => 'Item name',
            'rules' => 'required|max_length[100]|alpha_numeric_spaces|trim',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 100 chars allowed.",
                'alpha_numeric_spaces' => "Only characters and numbers are allowed.",
            ],
        ],
        [
            'field' => 'i_price',
            'label' => 'Item price',
            'rules' => 'required|max_length[5]|is_natural|trim',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 5 chars allowed.",
                'is_natural' => "%s is invalid",
            ],
        ],
        [
            'field' => 'description',
            'label' => 'Item description',
            'rules' => 'required|trim',
            'errors' => [
                'required' => "%s is required",
            ],
        ],
    ];
}