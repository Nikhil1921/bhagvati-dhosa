<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends API_controller {

    public function change_status()
	{
		post();
        $this->form_validation->set_rules('status', 'Status', 'required', ['required' => "%s is required"]);
        $this->form_validation->set_rules('id', 'Order id', 'required|is_numeric', ['required' => "%s is required", 'is_numeric' => "%s is invalid"]);
        /* $this->form_validation->set_rules('lattitude', 'Lattitude', 'required', ['required' => "%s is required"]);
        $this->form_validation->set_rules('longitude', 'Longitude', 'required', ['required' => "%s is required"]); */

		verifyRequiredParams();

        if($this->input->post('status') === 'Collect Sample'){
            $this->form_validation->set_rules('otp', 'OTP', 'required', ['required' => "%s is required"]);
            verifyRequiredParams();
            $check = $this->api_model->get($this->orders, 'id', ['id' => $this->input->post('id'), 'coll_otp' => $this->input->post('otp')]);
            if(!$check){
                $response['error'] = true;
		        $response['message'] = "Invalid otp.";
                echoRespnse(200, $response);
            }
        }

        $post = [
            'phlebotomist_id' => $this->api,
            'status' => $this->input->post('status'),
            /* 'lattitude' => $this->input->post('lattitude'),
            'longitude' => $this->input->post('longitude') */
        ];
        
		$id = $this->api_model->update(['id' => $this->input->post('id')], $post, $this->orders);

        if($id){
            $token = $this->api_model->getUserToken($this->input->post('id'));
            send_notification("Test update", 'Your test is in : '.$post['status'], $token['token'], $this->config->item('user-token'));
        }

		$response['error'] = $id ? false : true;
		$response['message'] = $id ? "Status change success." : "Status change not success.";

		echoRespnse(200, $response);
	}

    public function update_latlng()
	{
        post();
        
        $this->form_validation->set_rules('id', 'Order id', 'required|is_numeric', ['required' => "%s is required", 'is_numeric' => "%s is invalid"]);
        $this->form_validation->set_rules('lattitude', 'Lattitude', 'required', ['required' => "%s is required"]);
        $this->form_validation->set_rules('longitude', 'Longitude', 'required', ['required' => "%s is required"]);

        $post = [
            'lattitude' => $this->input->post('lattitude'),
            'longitude' => $this->input->post('longitude')
        ];

        $id = $this->api_model->update(['id' => $this->input->post('id')], $post, $this->orders);

		$response['error'] = $id ? false : true;
		$response['message'] = $id ? "Update lat lng success." : "Update lat lng not success.";

		echoRespnse(200, $response);
    }

    public function sample_list()
    {
        get();
        verifyRequiredParams(['order_id']);

        $data = $this->api_model->getSamples($this->input->get('order_id'));

        $response['row'] = $data ? $data : [];
        $response['error'] = false;
        $response['message'] = "Samples list success.";

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
    protected $orders = 'orders';
}