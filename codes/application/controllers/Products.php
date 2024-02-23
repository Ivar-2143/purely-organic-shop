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
        // var_dump($this->input->post());
        $data['main_image'] = $this->input->post('main_image',TRUE);
        if($action == 'add_product'){
            $errors = $this->Product->validate_add_product($this->input->post());
            if($errors){
                echo $errors;
            }
        }
        if($action == 'remove_image'){
            $images = get_filenames(APPPATH.'../assets/images/uploads/');
            $image_index = $this->input->post('image_index',TRUE);
                unlink(APPPATH.'..\\assets\\images\\uploads\\'.$images[$image_index]);
            $data['images'] = get_filenames(APPPATH.'..\\assets\\images\\uploads\\');
            $this->load->view('partials/uploaded_images',$data);
        }
        else if($action == 'upload_image'){
            if($_FILES['image']['name']){
                $file_name = $_FILES['image']['name'];
                $file_path = $_FILES['image']['tmp_name'];
                $save_path = APPPATH.'..\\assets\\images\\uploads\\'.$file_name;
                copy($file_path, $save_path);
            }
            $data['images']= get_filenames(APPPATH.'../assets/images/uploads/');
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
}
?>