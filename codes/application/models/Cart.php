<?php
class Cart extends CI_Model{
    public function fetch_all_user_cart($id){
        return $this->db->query("SELECT * FROM cart_items")->result_array();
    }
    public function get_cart_item($product_id, $user_id){
        return $this->db->query("SELECT * FROM cart_items WHERE user_id = ? HAVING product_id = ? ",array($user_id,$product_id))->row_array();
    }
    public function add_to_cart($form_data,$product_id,$user_id){
        $exsisting_item = $this->get_cart_item($product_id,$user_id);
        if($exsisting_item){
            $query = "UPDATE cart_items
                        SET 
                            quantity = ?,
                            updated_at = ?
                        WHERE user_id = ? AND product_id = ?";
            $quantity = $form_data['quantity'] + $exsisting_item['quantity'];
            $values = array($quantity, date('Y-m-d H:i:s'), $user_id, $product_id);
        }else{
            $query = "INSERT INTO cart_items(product_id, quantity, user_id,created_at, updated_at) VALUES (?, ?, ?, ?, ?)";
            $values = array($product_id, $form_data['quantity'], $user_id, date('Y-m-d H:i:s'), date('Y-m-d H:i:s'));
        }
        return $this->db->query($query, $values);
    }
    public function clean_fields($form_data){
        $cleaned_fields = array();
        foreach($form_data as $key => $field){
            $cleaned_fields[$key] = $field; 
        }
        return $cleaned_fields;
    }
}
?>