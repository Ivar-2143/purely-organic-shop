<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public function index()
	{
		$this->authenticate();
	}
	public function login(){
		// echo "Auth";
		$this->load->view('login');
	}
	public function register(){
		$this->load->view('register');
	}
	public function authenticate(){
		if(!$this->session->userdata('user')){
			redirect('login');
			// echo "Auth";
		}
	}
}