<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends API_controller {

    public function new_orders()
	{
		get();
		
		$orders = $this->api_model->getNewOrders();

		$response['row'] = $orders ? $orders : [];
		$response['error'] = $orders ? false : true;
		$response['message'] = $orders ? "Orders list success." : "Orders list not success.";

		echoRespnse(200, $response);
	}
	
    public function ongoing_orders()
	{
		get();
		verifyRequiredParams(['status']);
		
		$orders = $this->api_model->getOngoingOrders();

		$response['row'] = $orders ? $orders : [];
		$response['error'] = $orders ? false : true;
		$response['message'] = $orders ? "Orders list success." : "Orders list not success.";

		echoRespnse(200, $response);
	}
	
    public function collect_orders()
	{
		get();
		
		$orders = $this->api_model->getCollectOrders();

		$response['row'] = $orders ? $orders : [];
		$response['error'] = $orders ? false : true;
		$response['message'] = $orders ? "Orders list success." : "Orders list not success.";

		echoRespnse(200, $response);
	}

    public function change_on_off()
	{
		post();
        $this->form_validation->set_rules('status', 'Status', 'required', ['required' => "%s is required"]);
		verifyRequiredParams();

		$id = $this->api_model->update(['id' => $this->api], ['on_off' => $this->input->post('status')], $this->table);

		$response['error'] = $id ? false : true;
		$response['message'] = $id ? "Status change success." : "Status change not success.";

		echoRespnse(200, $response);
	}

    public function __construct()
    {
        parent::__construct($this->table);
        $this->load->model('api_model');
        $this->api = $this->verify_api_key();
        $this->city = $this->api_model->getCity();
    }

    protected $table = 'logins';
}