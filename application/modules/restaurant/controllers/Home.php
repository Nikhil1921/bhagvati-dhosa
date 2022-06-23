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
        
        $data['cats'] = array_map(function($cat){
            $cat['prods'] = $this->main->getAll('food_items', 'id, i_name, i_price, wait_time, description, IF(special_item = 0, "Normal", "Special") AS special_item', ['c_id' => $cat['id'], 'is_deleted' => 0]);
            return $cat;
        }, $this->main->getAll('categories', 'id, c_name', ['res_id' => $this->user->res_id, 'is_deleted' => 0]));

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

	public function pay_order($id)
    {
        $data['title'] = 'Complete order';
        $data['name'] = 'complete_order';
        $data['operation'] = 'Complete order';
        $data['url'] = $this->redirect;
        $data['data'] = $this->main->getOrder(d_id($id));
        
        if($data['data']){
            $this->form_validation->set_rules('final_total', 'Final Total', 'required|is_natural', ['required' => '%s is required.', 'is_natural' => '%s is invalid.']);
    
            if ($this->form_validation->run() === FALSE)
                return $this->template->load('template', 'pay_order', $data);
            else{
                $id = $this->main->payOrder(d_id($id));
    
                flashMsg($id, "Order paid.", "Order not paid.", $this->redirect);
            }
        }else
            return $this->error_404();
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

	public function getItemsData()
    {
        check_ajax();
        
        $items = $this->main->getItemsData($this->user->res_id);
        
        $series = array_map(function($item){
            return (int) $item['sellings'];
        }, $items);

        $earnings = array_map(function($item){
            return (int) $item['earnings'];
        }, $items);

        $labels = array_map(function($item){
            return $item['i_name'];
        }, $items);

        die(json_encode(['series' => $series, 'labels' => $labels, 'earnings' => $earnings]));
    }

	public function logout()
    {
        $this->session->sess_destroy();
        return redirect(admin('login'));
    }
}