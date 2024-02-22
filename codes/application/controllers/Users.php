<?php
class Users extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('User');
	}
    public function index(){
		$this->authenticate();
	}
	public function login(){
		// echo "Auth";
		$this->load->view('login');
	}
	public function signup(){
		$this->load->view('signup');
	}
	public function validate_signup(){
		$errors = $this->User->validate_fields();
		if($errors){
			$this->session->set_flashdata('registration',$errors);
		}else{
			$clean_fields = $this->User->clean_fields($this->input->post());
			$array['message'] = "<span class='notif notif-success'>Successfully registered!</span>";
			if($this->User->create($clean_fields)){
				$this->session->set_flashdata('registration',$array); 
			}
		}
		redirect('/signup');
	}
	public function admin(){
		
	}
	public function authenticate(){
		if(!$this->session->userdata('user')){
			redirect('login');
			// echo "Auth";
		}
	}
    public function csrf(){
		$this->load->view('partials/csrf_input');
	}
}
?>