<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_controller  {

	protected $table = 'employees';
	protected $redirect = 'dashboard';
	
	public function index()
	{
        $data['title'] = 'dashboard';
        $data['name'] = 'dashboard';
        $data['url'] = $this->redirect;
        
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

	public function cart()
    {
        $this->form_validation->set_rules('tables[]', 'Table', 'required', ['required' => "Select at least one %s"]);

        if ($this->form_validation->run() == FALSE)
        {
            $data['title'] = 'cart';
            $data['name'] = 'cart';
            $data['url'] = $this->redirect;
            $data['cart'] = $this->main->getCart();
            $data['tables'] = $this->main->getAll('tables', 'id, t_name', ['res_id' => $this->user->res_id, 'is_booked' => 0, 'is_deleted' => 0]);

            return $this->template->load('template', 'cart', $data);
        }else{
            $id = $this->main->saveOrder();

            if($id)
                return redirect(admin("order-success"));
            else
                flashMsg($id, "", "Order is not successful.. Try again.", admin("cart"));
        }
    }

	public function order_success()
    {
        $data['title'] = 'Order success';
        $data['name'] = 'success_order';
        $data['url'] = $this->redirect;

        return $this->template->load('template', 'order_success', $data);
    }

	public function saveToCart()
    {
        check_ajax();

        $this->main->saveToCart($this->input->post());
    }

	public function logout()
    {
        $this->session->sess_destroy();
        return redirect(admin('login'));
    }
}