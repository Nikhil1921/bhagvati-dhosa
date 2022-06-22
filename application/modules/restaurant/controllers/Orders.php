<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Admin_controller  {

	private $table = 'orders';
	protected $redirect = 'orders';
	protected $title = 'Order';
	protected $name = 'orders';
	
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

        $this->load->model('Order_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $this->input->get('start') + 1;
        $data = [];

        foreach($fetch_data as $row)
        {
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->or_id;
            $sub_array[] = date('d-m-Y', strtotime($row->created_date)) . ' ' . date('h:i A', strtotime($row->created_time));
            $sub_array[] = $row->pay_status;
            $sub_array[] = "$row->discount %";
            $sub_array[] = $row->final_total;
            
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
}