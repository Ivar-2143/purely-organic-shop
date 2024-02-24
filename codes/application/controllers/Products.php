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
    public function process(){
        $action = $this->input->post('form_action',TRUE);
        // var_dump($_FILES);
        // var_dump($this->input->post('category_state'));
        // var_dump($action);
        $data['main_image'] = $this->input->post('main_image',TRUE);
        // echo "action"
        if($action == 'add_product'){
            $errors = $this->Product->validate_add_product($this->input->post());
            if($errors){
                echo $errors;
                return;
            }else if(count($this->Product->get_files()) < 1){
                return;
            }
            $form_data = $this->Product->clean_fields($this->input->post());
            $files = $this->Product->clean_file_names($this->Product->get_files());
            $this->Product->create($form_data,$files);
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