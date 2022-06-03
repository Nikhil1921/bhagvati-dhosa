<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_controller  {

	protected $table = 'employees';
	protected $redirect = 'dashboard';
	
	public function index()
	{
        $data['title'] = 'dashboard';
        $data['name'] = 'dashboard';
        $data['url'] = $this->redirect;
        $data['orders'] = $this->main->getCurrentOrders($this->user->res_id);

        return $this->template->load('template', 'home', $data);
	}

	public function profile()
    {
        if ($this->form_validation->run('profile') == FALSE)
        {
            $data['title'] = 'Profile';
            $data['name'] = 'profile';
            $data['operation'] = 'Update';
            $data['url'] = $this->redirect;

            return $this->template->load('template', 'profile', $data);
        }
        else
        {
            $post = [
    			'mobile'   	 => $this->input->post('mobile'),
    			'email'   	 => $this->input->post('email'),
    			'name'   	 => $this->input->post('name')
    		];

            if ($this->input->post('password'))
                $post['password'] = my_crypt($this->input->post('password'));

            $id = $this->main->update(['id' => $this->session->auth], $post, $this->table);

            flashMsg($id, "Profile updated.", "Profile not updated. Try again.", admin("profile"));
        }
    }

	public function deliver_item()
    {
        $this->form_validation->set_rules('id', 'id', 'required|is_natural');

        if ($this->form_validation->run() == FALSE)
            flashMsg(0, "", "Some required fields are missing.", $this->redirect);
        else{
            $id = $this->main->deliverItem(d_id($this->input->post('id')));
            flashMsg($id, "Item delivered.", "Item not delivered.", $this->redirect);
        }
    }

	public function pay_order()
    {
        $this->form_validation->set_rules('id', 'id', 'required|is_natural');

        if ($this->form_validation->run() == FALSE)
            flashMsg(0, "", "Some required fields are missing.", $this->redirect);
        else{
            $id = $this->main->payOrder(d_id($this->input->post('id')));
            flashMsg($id, "Order paid.", "Order not paid.", $this->redirect);
        }
    }

	public function waiting()
    {
        $this->form_validation->set_rules('stove', 'Stove', 'required|less_than_equal_to[128]|is_natural|trim', [
            'required' => '%s is required.',
            'less_than_equal_to' => '%s is invalid.',
            'is_natural' => '%s is invalid.',
        ]);
        
        $this->form_validation->set_rules('w_time', 'Waiting time', 'required|less_than_equal_to[128]|is_natural|trim', [
            'required' => '%s is required.',
            'less_than_equal_to' => '%s is invalid.',
            'is_natural' => '%s is invalid.',
        ]);

        if ($this->form_validation->run() == FALSE)
        {
            $data['title'] = 'Waiting Time';
            $data['name'] = 'waiting';
            $data['operation'] = 'Update';
            $data['url'] = $this->redirect;
            $data['data'] = $this->main->get('waiting_time', 'stove, w_time', ['res_id' => $this->user->res_id]);
            
            if(!$data['data'])
            {
                $this->main->add(['stove' => 1, 'w_time' => 2, 'res_id' => $this->user->res_id], 'waiting_time');
                $data['data'] = $this->main->get('waiting_time', 'stove, w_time', ['res_id' => $this->user->res_id]);
            }
            
            return $this->template->load('template', 'waiting', $data);
        }
        else
        {
            $post = [
    			'stove' => $this->input->post('stove'),
                'w_time'  => $this->input->post('w_time')
    		];

            $id = $this->main->update(['res_id' => $this->session->auth], $post, 'waiting_time');

            flashMsg($id, "Waiting time updated.", "Waiting time not updated. Try again.", admin("waiting"));
        }
    }

	public function logout()
    {
        $this->session->sess_destroy();
        return redirect(admin('login'));
    }
}