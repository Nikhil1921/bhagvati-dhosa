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

	public function forbidden()
	{
		$data['title'] = 'Error 403';
        $data['name'] = 'error_403';

		return $this->template->load('template', 'error_403', $data);
	}
}