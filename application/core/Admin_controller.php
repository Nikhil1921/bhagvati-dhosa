<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Admin_controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->session->auth) 
			return redirect(admin('login'));
		
		switch (ADMIN) {
			case 'adminPanel':
				$this->user = (object) $this->main->get("admins", 'name, mobile, email', ['id' => $this->session->auth]);
				break;
			
			default:
				$this->user = (object) $this->main->get("employees", 'name, mobile, email, role, res_id', ['id' => $this->session->auth]);
				break;
		}
        
		$this->redirect = admin($this->redirect);
	}

	public function cart()
    {
        $this->form_validation->set_rules('tables[]', 'Table', 'required', ['required' => "Select at least one %s"]);

        if ($this->form_validation->run() == FALSE)
        {
            $data['title'] = 'cart';
            $data['name'] = 'dashboard';
            $data['url'] = $this->redirect;
            $data['cart'] = $this->main->getCart();
            $data['tables'] = $this->main->getAll('tables', 'id, t_name', ['res_id' => $this->user->res_id, 'is_booked' => 0, 'is_deleted' => 0]);
            // re($data);
            return $this->template->load('template', 'cart', $data);
        }else{
            $id = $this->main->saveOrder();

            if($id)
                return redirect(admin("order-success"));
            else
                flashMsg($id, "", "Order is not successful.. Try again.", admin("cart"));
        }
    }

	public function add_order()
    {
        $this->form_validation->set_rules('id', 'Order ID', 'required|is_natural', ['required' => "%s is required", 'is_natural' => '%s is invalid']);

        if ($this->form_validation->run() == FALSE)
        {
            $data['title'] = 'Add order';
            $data['name'] = 'dashboard';
            $data['url'] = $this->redirect;
            $data['cart'] = $this->main->getCart();
            $data['orders'] = $this->main->getCurrentOrders($this->user->res_id);
            
            return $this->template->load('template', 'add_order', $data);
        }else{
            $id = $this->main->addOrder($this->input->post());

            if($id)
                return redirect(admin("order-success"));
            else
                flashMsg($id, "", "Order is not successful.. Try again.", admin("add-order"));
        }
    }

	public function change_table($id)
    {
        $this->form_validation->set_rules('tables[]', 'Table', 'required', ['required' => "Select at least one %s"]);

        if ($this->form_validation->run() == FALSE)
        {
            $data['title'] = 'cart';
            $data['name'] = 'dashboard';
            $data['url'] = $this->redirect;
            $data['cart'] = $this->main->getCart();
            $data['tables'] = $this->main->getAll('tables', 'id, t_name', ['res_id' => $this->user->res_id, 'is_booked' => 0, 'is_deleted' => 0]);
            
            return $this->template->load('template', 'change_table', $data);
        }else{
            $c_id = $this->main->changeTable(d_id($id));

            if($c_id)
                return redirect(admin("table-success"));
            else
                flashMsg($c_id, "", "Change table is not successful.. Try again.", admin('change-table/'.$id));
        }
    }

	public function order_success()
    {
        $data['title'] = 'Order success';
        $data['name'] = 'dashboard';
        $data['url'] = $this->redirect;

        return $this->template->load('template', 'order_success', $data);
    }

	public function table_success()
    {
        $data['title'] = 'Table change success';
        $data['name'] = 'dashboard';
        $data['url'] = $this->redirect;

        return $this->template->load('template', 'table_success', $data);
    }

    public function cancel_item()
    {
        $this->form_validation->set_rules('id', 'id', 'required|is_natural');

        if ($this->form_validation->run() == FALSE)
            flashMsg(0, "", "Some required fields are missing.", $this->redirect);
        else{
            $id = $this->main->cancelItem(d_id($this->input->post('id')));
            flashMsg($id, "Item cancelled.", "Item not cancelled.", $this->redirect);
        }
    }

    public function cancel_order()
    {
        $this->form_validation->set_rules('id', 'id', 'required|is_natural');

        if ($this->form_validation->run() == FALSE)
            flashMsg(0, "", "Some required fields are missing.", $this->redirect);
        else{
            $id = $this->main->cancelOrder(d_id($this->input->post('id')));
            flashMsg($id, "Order cancelled.", "Order not cancelled.", $this->redirect);
        }
    }

	public function saveToCart()
    {
        check_ajax();

        $this->main->saveToCart($this->input->post());
    }

	public function parcel_order()
    {
        $id = $this->main->saveOrder();

        if($id)
            return redirect(admin("order-success"));
        else
            flashMsg($id, "", "Order is not successful.. Try again.", admin("cart"));
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

	public function forbidden()
	{
		$data['title'] = 'Error 403';
        $data['name'] = 'error_403';

		return $this->template->load('template', 'error_403', $data);
	}
}