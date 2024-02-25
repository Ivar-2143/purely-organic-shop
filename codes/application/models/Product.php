<?php
class Product extends CI_Model{
    private $datetime_format = 'Y-m-d H:i:s';
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function fetch_all(){
        return $this->db->query("SELECT products.*, product_categories.name as category FROM products LEFT JOIN product_categories ON products.category_id = product_categories.id")->result_array();
    }
    public function fetch_by_id($id){
        $query = "SELECT * FROM products WHERE id = ?";
        return $this->db->query($query,array($id))->row_array();
    }
    public function fetch_by_category($id){
        $query = "SELECT products.*, product_categories.name as category 
                    FROM products 
                    INNER JOIN product_categories 
                        ON product_categories.id = products.category_id
                    WHERE category_id = ?";
        return $this->db->query($query, array($id))->result_array();
    }
    public function fetch_similar_by_category($category_id,$id){
        $query = "SELECT products.*, product_categories.name as category 
                    FROM products 
                    INNER JOIN product_categories 
                        ON product_categories.id = products.category_id
                    WHERE products.category_id = ? AND products.id != ?";
        return $this->db->query($query, array($category_id,$id))->result_array();
    }
    public function get_product_count(){
        return $this->db->query("SELECT count(id) as total_count FROM products")->row_array();
    }
    public function fetch_by_name($name){
        return $this->db->query("SELECT * FROM products WHERE name = ?", array($name))->row_array();
    }
    public function create($form_data,$files){
        $this->create_directory($form_data['category'],$form_data['product_name']);
        $this->copy_files($form_data['category'],$form_data['product_name'],$files);
        $files['main_image'] = $files[$form_data['main_image']]; 
        $query = "INSERT INTO products(name, price, stocks, description, category_id, image_links_json, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $values = array(
            $form_data['product_name'],
            $form_data['price'],
            $form_data['inventory'],    
            $form_data['description'],
            $form_data['category'], 
            json_encode($files),
            date($this->datetime_format),date($this->datetime_format));
        return $this->db->query($query,$values);
    }
    public function update($form_data,$files){
        $editing_product = $this->fetch_by_id($form_data['edit_product_id']);
        $this->remove_files($editing_product);
        $this->create_directory($form_data['category'],$form_data['product_name']);
        $this->copy_files($form_data['category'],$form_data['product_name'],$files);
        $files['main_image'] = $files[$form_data['main_image']]; 
        $query = "UPDATE products
            SET 
                name = ?, 
                price = ?, 
                stocks = ?, 
                description = ?, 
                category_id = ?, 
                image_links_json = ?, 
                updated_at = ?
            WHERE id = ?";
        $values = array(
            $form_data['product_name'],
            $form_data['price'],
            $form_data['inventory'],    
            $form_data['description'],
            $form_data['category'], 
            json_encode($files),
            date($this->datetime_format),
            $form_data['edit_product_id']);
        return $this->db->query($query,$values);
    }
    public function delete($id){
        return $this->db->query("DELETE FROM products WHERE id = ?",array($id));
    }
    public function validate_add_product(){
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        $this->form_validation->set_rules('product_name','Product_Name','required|trim|min_length[3]');
        $this->form_validation->set_rules('description','Description','required|trim');
        $this->form_validation->set_rules('price','Price','required|trim|greater_than_equal_to[0.1]');
        $this->form_validation->set_rules('inventory','Inventory Stocks','required|trim|is_natural_no_zero');
        $this->form_validation->set_rules('category','Product Category','required|trim|is_natural_no_zero');
        if($this->form_validation->run() === FALSE){
            // $errors = array();
            // foreach($fields as $field){
            //     $errors[$field] = form_error($field);
            // }
            // return $errors;
            return validation_errors();
        }
    }
    public function clean_fields($form_data){
        $cleaned_fields = array();
        foreach($form_data as $key => $value){
            $cleaned_fields[$key] = $this->security->xss_clean($value);
        }
        return $cleaned_fields;
    }
    public function clean_file_names($files){
        $cleaned_names = array();
        foreach($files as $key => $file){
            $cleaned_names[$key] = $this->security->sanitize_filename($file);
        }
        return $cleaned_names;
    }
    public function get_files(){
        return get_filenames(APPPATH.'..\\assets\\images\\uploads\\');
    }
    public function get_uploaded_files($category,$name){
        $dir = APPPATH.'..\\assets\\images\\products\\'.$category.'\\'.$name;
        $files = get_filenames($dir);
        return $files;
    }
    public function create_directory($category,$name){
        $dir = APPPATH.'..\\assets\\images\\products\\'.$category.'\\'.$name;
        if(!file_exists($dir)){
            mkdir($dir.'\\',0755);
        }
    }
    public function copy_files($category,$name,$files){
        $from = APPPATH.'..\\assets\\images\\uploads\\';
        $to = APPPATH.'..\\assets\\images\\products\\'.$category.'\\'.$name.'\\';
        foreach($files as $file){
            copy($from.$file,$to.$file);
            unlink($from.$file);
        }
    }
    public function copy_uploaded_images($category,$name){
        $to = APPPATH.'..\\assets\\images\\uploads\\';
        $from = APPPATH.'..\\assets\\images\\products\\'.$category.'\\'.$name.'\\';
        $files = get_filenames($from);
        foreach($files as $file){
            copy($from.$file,$to.$file);
        }
    }
    public function remove_files($product){
        $directory = APPPATH.'..\\assets\\images\\products\\'.$product['category_id'].'\\'.$product['name'].'\\';
        $files = get_filenames($directory);
        foreach($files as $file){
            unlink($directory.$file);
        }
        clearstatcache();
    }
    public function delete_directory($product){
        $directory = APPPATH.'..\\assets\\images\\products\\'.$product['category_id'].'\\'.$product['name'];
        rmdir($directory);
        clearstatcache();
    }
}
?>