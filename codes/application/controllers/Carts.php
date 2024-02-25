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
        $this->authenticate($user);
        if(!$product){
            echo show_error('No product found.', 500, $heading = 'An Error Was Encountered');
            return;
        }
        if(!$this->Cart->add_to_cart($this->input->post(NULL,TRUE),$id,$user['user_id'])){
            echo show_error('Forbidden: You are not logged in', 403, $heading = 'An Error Was Encountered');
        }
    }
    public function update(){
        $user = $this->session->userdata('user');
        $this->authenticate($user);
        $cart_item_id = $this->input->post('update_cart_item_id',TRUE);
        $cart_item_quantity = $this->input->post('update_cart_item_quantity',TRUE);
        $this->Cart->update_item($cart_item_id,$cart_item_quantity);
        $data['cart_items'] = $this->Cart->fetch_user_cart($user['user_id']);
        $data['total'] = $this->Cart->get_cart_total_amount($user['user_id']);
        $this->load->view('partials/cart_section',$data);
    }
    public function authenticate($user){
        if(!$user){
            echo show_error('Forbidden: You are not logged in', 403, $heading = 'An Error Was Encountered');
            return;
        }
    }
}
?>