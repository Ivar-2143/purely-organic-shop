<?php
class Products extends CI_Controller{
    public function __construct(){
        parent::__construct();
        // $this->load->model('Product');
        $this->load->helper('file');
        $this->load->model('Product');
    }
    public function index(){

    }
    public function view($id){
        $user = $this->session->userdata('user');
        if(!$user){
            redirect('/');
        }
        $data = array();
        $data['products'] = $this->Product->fetch_all();
		$data['user'] = $user;
        $data['product'] = $this->Product->fetch_by_id($id);
        $data['products'] = $this->Product->fetch_by_category($data['product']['category_id']);
        $images = json_decode($data['product']['image_links_json'],TRUE);
        $data['images'] = $this->Product->get_uploaded_files($data['product']['category_id'],$data['product']['name']);
        $data['main_image'] = $images['main_image'];
        $this->load->view('users/product_view',$data);
    }
    public function get_product($id){
        $product = $this->Product->fetch_by_id($id);
        echo json_encode($product);
    }
    public function get_editing_product_images($category_id,$name){
        // var_dump($category_id);
        // var_dump(str_replace('%20',' ',$name));
        $this->Product->copy_uploaded_images($category_id,str_replace('%20',' ',$name));
        $data['images'] = $this->Product->get_files();
        $product = $this->Product->fetch_by_name(str_replace('%20',' ',$name));
        $images = json_decode($product['image_links_json'],TRUE);
        $data['main_image_name'] = $images['main_image'];
            // var_dump($data);
        $this->load->view('partials/uploaded_images',$data);
    }
    public function process(){
        $action = $this->input->post('form_action',TRUE);
        // var_dump($_FILES);
        // var_dump($this->input->post('category_state'));
        // var_dump($action);
        $data['main_image'] = $this->input->post('main_image',TRUE);
        // echo "action"
        if($action == 'add_product' || $action == 'edit_product'){
            $errors = $this->Product->validate_add_product($this->input->post());
            if($errors){
                echo $errors;
                return;
            }else if(count($this->Product->get_files()) < 1){
                return;
            }
            $form_data = $this->Product->clean_fields($this->input->post());
            $files = $this->Product->clean_file_names($this->Product->get_files());
            if($action == 'add_product'){
                $existing = $this->Product->fetch_by_name($form_data['product_name']);
                if($existing){
                    echo "<p class='error'>Product Name already exists!</p>";
                    return;
                }
                $this->Product->create($form_data,$files);
            }else{
                $existing = $this->Product->fetch_by_name($form_data['product_name']);
                if($existing['id'] != $form_data['edit_product_id']){
                    echo "<p class='error'>Product Name already exists!</p>";
                    return;
                }
                $this->Product->update($form_data,$files);
            }
            $state = $this->input->post('category_state',TRUE);
            if($state < 1){
                $data['products'] = $this->Product->fetch_all();
            }else{
                $data['products'] = $this->Product->fetch_by_category($state);
            }
            // var_dump($this->input->post());
            $this->load->view('partials/admin_row_products',$data);
        }
        if($action == 'remove_image'){
            $images = get_filenames(APPPATH.'../assets/images/uploads/');
            $image_index = $this->input->post('image_index',TRUE);
                unlink(APPPATH.'..\\assets\\images\\uploads\\'.$images[$image_index]);
            $data['images'] = get_filenames(APPPATH.'..\\assets\\images\\uploads\\');
            $this->load->view('partials/uploaded_images',$data);
        }
        else if($action == 'upload_image'){
            if($_FILES['image']['name'] && !empty($_FILES['image']['tmp_name']) && $_FILES['image']['size'] < (1024 * 10000)){
                $file_name = $_FILES['image']['name'];
                $file_path = $_FILES['image']['tmp_name'];
                $save_path = APPPATH.'..\\assets\\images\\uploads\\'.$file_name;
                copy($file_path, $save_path);
            }
            $data['images'] = get_filenames(APPPATH.'../assets/images/uploads/');
            // var_dump($data);
            $this->load->view('partials/uploaded_images',$data);
        }else if($action == 'mark_as_main'){
            $data['main_image'] = $this->input->post('image_index',TRUE);
            $data['images'] = get_filenames(APPPATH.'..\\assets\\images\\uploads\\');
            $this->load->view('partials/uploaded_images',$data);
        }
        else if($action == 'reset_form'){
            delete_files(APPPATH. '..\\assets\\images\\uploads\\');
        }
    }
    public function remove($id){
        $product = $this->Product->fetch_by_id($id);
        $this->Product->remove_files($product);
        $this->Product->delete_directory($product);
        $this->Product->delete($id);
        $data['products'] = $this->Product->fetch_all();
        $this->load->view('partials/admin_row_products',$data);
    }
    public function category(){
        $id = $this->input->post('category',TRUE);
        if($id > 0){
            $data['products'] = $this->Product->fetch_by_category($id);
        }else{
            $data['products'] = $this->Product->fetch_all();
        }
        $this->load->view('partials/admin_row_products',$data);
    }
}
?>