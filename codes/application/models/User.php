<?php
class User extends CI_Model{
    private $datetime_format = 'Y-m-d, H:i:s';
    public function get_by_email($email){
        return $this->db->query("SELECT * FROM users WHERE email = ?", array($this->security->xss_clean($email)))->row_array();
    }
    public function create($form_data){
        $salt = bin2hex(openssl_random_pseudo_bytes(22));
        $encrypted_password = md5($form_data['password'].''.$salt);
        $users = $this->db->query("SELECT COUNT(id) as count FROM users")->row_array();
        $access_level = 0;
        if($users['count'] == 0){
            $access_level = 9;
        }
        $query = "INSERT INTO users (first_name, last_name, email, password, salt, access_level, created_at, updated_at)
            VALUES (?,?,?,?,?,?,?,?)";
        $values = array(
            $form_data['first_name'],$form_data['last_name'],$form_data['email'],
            $encrypted_password, $salt, $access_level,
            date($this->datetime_format), date($this->datetime_format)
        );
        return $this->db->query($query,$values);
    }
    public function validate_fields(){
        $fields = array(
            'first_name',
            'last_name',
            'email',
            'password',
            'confirm_password'
        );
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span>','</span>');
        $this->form_validation->set_rules('first_name','First Name', 'required|trim|alpha_numeric_spaces|min_length[2]');
        $this->form_validation->set_rules('last_name','Last Name', 'required|trim|alpha_numeric_spaces|min_length[2]');
        $this->form_validation->set_rules('email','Email', 'required|trim|valid_email|is_unique[users.email]', array('is_unique' => 'Email is already used.'));
        $this->form_validation->set_rules('password','Password', 'required|trim|min_length[8]');
        $this->form_validation->set_rules('confirm_password','Confirm Password', 'matches[password]', array('matches' => "Password doesn\'t match"));
        if($this->form_validation->run() === FALSE){
            // $data['message'] = "<span class='notif notif-error'>Registration Error!</span>";
            $errors  = array();
            foreach($fields as $field){
                if(form_error($field)){
                    $errors[$field] = form_error($field);
                }
            }
            $data['errors'] = $errors;
            return $data;
        }
    }
    public function clean_fields($form_data){
        $data = array();
        foreach($form_data as $key => $value){
            $data[$key] = $this->security->xss_clean($value);
        }
        return $data;
    }
}
?>