<?php
class Category extends CI_Model{
    public function fetch_all(){
        return $this->db->query("SELECT * FROM product_categories")->result_array();
    }
    public function fetch_all_with_product_count(){
        return $this->db->query("SELECT product_categories.*, count(products.id) as product_count FROM product_categories LEFT JOIN products ON products.category_id = product_categories.id GROUP BY product_categories.id")->result_array();
    }
}
?>