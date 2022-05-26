<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends API_controller {

    public function list()
	{
		get();
        
        verifyRequiredParams(['res_id', 'status', 'date']);

		$orders = $this->api_model->ordersList($this->input->get());
		
		$response['row'] = $orders;
		$response['error'] = $orders ? false : true;
		$response['message'] = $orders ? "Orders list success." : "Orders list not success.";

		echoRespnse(200, $response);
	}

    public function add_order()
	{
		post();

        $this->form_validation->set_rules($this->add_order);

		verifyRequiredParams();

		$id = $this->api_model->addOrder($this->input->post());
		
		$response['error'] = $id ? false : true;
		$response['message'] = $id ? "Order add success." : "Order add not success.";

		echoRespnse(200, $response);
	}

    public function __construct()
    {
        parent::__construct($this->table);
        $this->load->model('api_model');
        $this->api = $this->verify_api_key();
    }

    protected $table = 'employees';
    protected $orders = 'orders';

    public $add_order = [
        [
            'field' => 't_id',
            'label' => 'Table ID',
            'rules' => 'required|is_natural|trim',
            'errors' => [
                'required' => "%s is required",
                'is_natural' => "%s is invalid",
            ],
        ],
        [
            'field' => 'i_id',
            'label' => 'Item ID',
            'rules' => 'required|is_natural|trim',
            'errors' => [
                'required' => "%s is required",
                'is_natural' => "%s is invalid",
            ],
        ],
        [
            'field' => 'qty',
            'label' => 'Quantity',
            'rules' => 'required|is_natural|trim',
            'errors' => [
                'required' => "%s is required",
                'is_natural' => "%s is invalid",
            ],
        ],
        [
            'field' => 'price',
            'label' => 'Price',
            'rules' => 'required|is_natural|trim',
            'errors' => [
                'required' => "%s is required",
                'is_natural' => "%s is invalid",
            ],
        ],
    ];
}