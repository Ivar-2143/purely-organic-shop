<?php
class Users extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('User');
		$this->load->model('Category');
	}
    public function index(){
		$this->authenticate();
		$user = $this->session->userdata('user');
		if($user['access_level'] == 9){
			redirect('admin');
		}
		$this->load->view('users/catalogue');
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
	public function validate_login(){
		$user = $this->User->get_by_email($this->input->post('email'));
		if($user){
			$encrypted_password = md5($this->input->post('password').''.$user['salt']);
			if($user['password'] == $encrypted_password){
				$user['user_id'] = $user['id'];
				$user['access_level'] = $user['access_level'];
				$this->session->set_userdata('user',$user);
				redirect('/');
			}
		}
		$message = '<span class="notif notif-error">Invalid email or password</span>';
		$this->session->set_flashdata('login',$message);
		redirect('login');
	}
	public function admin(){
		$this->authenticate();
		redirect('admin/orders');
	}
	public function admin_orders(){
		$this->authenticate();
		$this->load->view('users/admin/admin_orders');
	}
	public function admin_products(){
		$this->authenticate();
		$data['categories'] = $this->Category->fetch_all_with_product_count();
		$this->load->view('users/admin/admin_products',$data);
	}
	public function authenticate(){
		if(!$this->session->userdata('user')){
			redirect('login');
		}
	}
    public function csrf(){
		$this->load->view('partials/csrf_input');
	}
}
?>