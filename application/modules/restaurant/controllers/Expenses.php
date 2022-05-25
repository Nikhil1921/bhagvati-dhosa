<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses extends Admin_controller  {

	private $table = 'expenses';
	protected $redirect = 'expenses';
	protected $title = 'Expense';
	protected $name = 'expenses';
	
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

        $this->load->model('Expenses_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $this->input->get('start') + 1;
        $data = [];

        $edit = verify_access($this->name, 'add_update');
        $delete = verify_access($this->name, 'delete');

        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->expense;
            $sub_array[] = $row->price;
            $sub_array[] = date('d-m-Y', $row->created_at);

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

        if($id !== 0) $data['data'] = $this->main->get($this->table, 'expense, price, created_at, res_id, created_by', ['id' => d_id($id)]);
        
        if ($this->form_validation->run() == FALSE)
        {
            return $this->template->load('template', "$this->redirect/form", $data);
        }else{

            $post = [
                'expense'     => $this->input->post('expense'),
                'price'       => $this->input->post('price'),
                'created_at'  => strtotime($this->input->post('created_at')),
                'res_id'      => $this->user->res_id,
                'created_by'  => $this->session->auth
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
            'field' => 'expense',
            'label' => 'Expense Item',
            'rules' => 'required|max_length[100]|alpha_numeric_spaces|trim',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 100 chars allowed.",
                'alpha_numeric_spaces' => "Only characters and numbers are allowed.",
            ],
        ],
        [
            'field' => 'price',
            'label' => 'Expense price',
            'rules' => 'required|is_natural|max_length[9]|trim',
            'errors' => [
                'required' => "%s is required",
                'max_length' => "Max 9 chars allowed.",
                'is_natural' => "%s is invalid",
            ],
        ],
        [
            'field' => 'created_at',
            'label' => 'Expense date',
            'rules' => 'required|trim',
            'errors' => [
                'required' => "%s is required",
            ],
        ]
    ];
}