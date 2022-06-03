<?php defined('BASEPATH') OR exit('No direct script access allowed');

switch ($this->user->role) {
    case 'Shef':
        $this->load->view('dashboard/shef');
        break;
    case 'Accountant':
        $this->load->view('dashboard/accountant');
        break;
    
    default:
        $this->load->view('dashboard/admin');
        break;
}