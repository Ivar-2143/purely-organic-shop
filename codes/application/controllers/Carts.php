<?php
class Carts extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Cart');
        $this->load->model('Product');
    }
    public function add($id){
        $user = $this->session->userdata('user');
        $product = $this->Product->fetch_by_id($id);
        if(!$user){
            echo show_error('Forbidden: You are not logged in', 403, $heading = 'An Error Was Encountered');
            return;
        }
        if(!$product){
            echo show_error('No product found.', 500, $heading = 'An Error Was Encountered');
            return;
        }
        // var_dump($this->input->post(NULL,TRUE));
        if(!$this->Cart->add_to_cart($this->input->post(NULL,TRUE),$id,$user['user_id'])){
            echo show_error('Forbidden: You are not logged in', 403, $heading = 'An Error Was Encountered');
        }
    }
}
?>