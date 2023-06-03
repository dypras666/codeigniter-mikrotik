<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Auth extends CI_Controller {	
	function __construct(){
		parent::__construct();  
        $this->load->model('auth_model');
        $this->load->library('form_validation');
    }

    public function login(){
    if($this->auth_model->current_user()){
        redirect('/'); 
    }	
    $data = array();
    $this->load->view('template_sbadmin/header', $data); 
    $rules = $this->auth_model->rules();
    $this->form_validation->set_rules($rules);

    if($this->form_validation->run() == FALSE){
        return $this->load->view('template_sbadmin/login');
    }

    $username = $this->input->post('username');
    $password = $this->input->post('password');

    if($this->auth_model->login($username, $password)){
        redirect('/');
    } else {
        $this->session->set_flashdata('error', 'Login Gagal, pastikan username dan passwrod benar!');
    }
	
    $this->load->view('template_sbadmin/login', $data);
    // $this->load->view('template_sbadmin/footer', $data); 
}

public function logout()
{ 
    $this->auth_model->logout();
    redirect(site_url('auth/login'));
}
}