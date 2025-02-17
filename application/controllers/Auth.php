<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    public function register() {
        $this->load->view('templates/header');
        $this->load->view('auth/register');
        $this->load->view('templates/footer');
    }

    public function store() {
        $this->load->model('User_model');

        $data = [
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'full_name' => $this->input->post('full_name')
        ];

        if ($this->User_model->register($data)) {
            redirect('auth/login');
        } else {
            redirect('auth/register');
        }
    }

    public function login() {
        $this->load->view('templates/header');
        $this->load->view('auth/login');
        $this->load->view('templates/footer');
    }

    public function authenticate() {
        $this->load->model('User_model');

        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user = $this->User_model->check_login($email, $password);

        if ($user) {
            $this->session->set_userdata([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'logged_in' => TRUE
            ]);
            redirect('dashboard'); // You can create a dashboard controller
        } else {
            $this->session->set_flashdata('error', 'Invalid email or password');
            redirect('auth/login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

}
