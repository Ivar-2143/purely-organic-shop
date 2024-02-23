<?php
class Product extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function create(){
        
    }
    public function validate_add_product(){
        $this->form_validation->set_rules('product_name','Product_Name','required|trim|min_length[3]');
        $this->form_validation->set_rules('description','Description','required|trim');
        $this->form_validation->set_rules('price','Description','required|trim|greater_than_equal_to[0.1]');
        $this->form_validation->set_rules('inventory','Description','required|trim|is_natural_no_zero');
        if($this->form_validation->run() === FALSE){
            return validation_errors();
        }
    }
}
?>