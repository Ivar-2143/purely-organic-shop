<?php
class Categories extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('Category');
        $this->load->model('Product');
    }
    public function index(){

    }
    public function get_category_nav($id){
        $data['categories'] = $this->Category->fetch_all_with_product_count();
        $data['total_products'] = $this->Product->get_product_count();
        $data['current_category'] = $id;
        $this->load->view('partials/category_nav',$data);
    }
    public function get_options(){
        $data['categories'] = $this->Category->fetch_all();
        $this->load->view('partials/category_options',$data);
    }
}
?>