<?php
    class user_model extends CI_Model{
        public function register($enc_password){
            //User data array
            $data = array(
                'name' => $this->input->post('name'),
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'zipcode' => $this->input->post('zipcode'),
                'password' => $enc_password
            );
            //Insert User
            return $this->db->insert('users', $data);
        }
        //check username exist
        public function check_username_exist($username){
            $query = $this->db->get_where('users', array('username' => $username));
            if(empty($query->row_array())){
                return true;
            }else{
                return false;
            }

        }
        //check email exist
        public function check_email_exist($email){
            $query = $this->db->get_where('users', array('email' => $email));
            if(empty($query->row_array())){
                return true;
            }else{
                return false;
            }

        }
        //user login
        public function login($username, $password){
            //Valadate
            $this->db->where('username', $username);
            $this->db->where('password', $password);
            $result = $this->db->get('users');
            if($result->num_rows()== 1){
                return $result->row(0)->id;
            }else{
                return false;
            }
        }
    }