<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(['form_validation','session']);
        $this->load->helper(['url','form','security']);
        $this->load->model('User_model');
        $this->load->library('UserService');
    }

    public function register() {
        $this->form_validation->set_rules('name','Name','required|min_length[3]|is_unique[users.name]');
        $this->form_validation->set_rules('email','Email','required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password','Password','required|min_length[6]');
        $this->form_validation->set_rules('passconf','Confirm','required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->load->view('auth/register');
            $this->load->view('templates/footer');
            return;
        }

        $data = [
            'name' => $this->input->post('name', true),
            'email' => $this->input->post('email', true),
            'password' => $this->input->post('password'),
            'role' => $this->input->post('role', true) 
        ];

        $this->userservice->createUser($data);
        $this->session->set_flashdata('success','ثبت‌نام انجام شد. وارد شوید.');
        redirect('login');
    }

    public function login() {
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('password','Password','required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header');
            $this->load->view('auth/login');
            $this->load->view('templates/footer');
            return;
        }

        $email = $this->input->post('email', true);
        $password = $this->input->post('password');

        $user = $this->User_model->get_by_email($email);
        if ($user && password_verify($password, $user->password)) {
            $this->session->set_userdata([
                'user_id' => $user->id,
                'user_role' => $user->role,
                'user_name' => $user->name,
                'logged_in' => true
            ]);
            if ($user->role === 'admin') redirect('admin/users');
            else redirect('profile');
        }

        $this->session->set_flashdata('error','نام کاربری یا رمز اشتباه است.');
        redirect('login');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

    public function profile() {
        if (!$this->session->userdata('logged_in')) redirect('login');
        $user = $this->userservice->getById($this->session->userdata('user_id'));
        $this->load->view('templates/header');
        $this->load->view('auth/profile', ['user' => $user]);
        $this->load->view('templates/footer');
    }
}
