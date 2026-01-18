<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Madmin');
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('login');
    }

    public function proses() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $admin = $this->Madmin->getByUsername($username);

        if ($admin && $password === $admin->password) {
            $this->session->set_userdata([
                'admin_id'    => $admin->id_admin,
                'admin_nama'  => $admin->nama_admin,
                'admin_login' => TRUE
            ]);
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah');
            redirect('login'); 
        }
        
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}
