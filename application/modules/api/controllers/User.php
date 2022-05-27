<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends API_controller {

    public function __construct()
    {
        parent::__construct($this->table);
        $this->load->model('api_model');
        $this->api = $this->verify_api_key();
    }

    protected $table = 'employees';
    protected $orders = 'orders';
}