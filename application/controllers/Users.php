<?php
    class Users extends CI_Controller{
        //register user
        public function register(){
            $data['title'] = 'Sign Up';
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exist');
            $this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exist');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');

            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/register', $data);
                $this->load->view('templates/footer');

            }else{
                //encrypt password
                $enc_password = md5($this->input->post('password'));

                $this->user_model->register($enc_password);

                //set message
                $this->session->set_flashdata('user_registered', 'You are now registered and you can log in');

                redirect('posts');
            }
        }
        //login user
        public function login(){
            $data['title'] = 'Sign In';
            
           
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            

            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('users/login', $data);
                $this->load->view('templates/footer');

            }else{
               //get username
               $username = $this->input->post('username');
               //get and encrypt password
               $password = md5($this->input->post('password'));

               //Login user
               $user_id = $this->user_model->login($username, $password);

                
                if($user_id){
                    //create session
                    $user_data = array(
                        'user_id' => $user_id,
                        'username' => $username,
                        'logged_in' => true
                    );

                    $this->session->set_userdata($user_data);

                    $this->session->set_flashdata('user_loggedin', 'You are now loggedin');
                }else{
                    $this->session->set_flashdata('login_failed', 'Login invalid');
                    redirect('users/login');
                }

                redirect('posts');
            }
        }
        //log out
        public function logout(){
            //unset user data
            $this->session->unset_userdata('logged_in');
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('username');
            $this->session->set_flashdata('logged_out', 'User logged out');
            redirect('users/login');
        }
        //check if username exist
        public function check_username_exist($username){
            $this->form_validation->set_message('check_username_exist', 'That username is taken. Please choose a different one');
            if($this->user_model->check_username_exist($username)){
                return true;
            }else{
                return false;
            }
        }
        //check if email exist
        public function check_email_exist($email){
            $this->form_validation->set_message('check_email_exist', 'That email is taken. Please choose a different one');
            if($this->user_model->check_email_exist($email)){
                return true;
            }else{
                return false;
            }
        }
        
    }