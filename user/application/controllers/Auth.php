<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Muser');
        $this->load->library('session');
    }

    public function login()
    {
        $this->load->view('auth/login');
    }

    public function proses_login()
    {
        $email    = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->Muser->getByEmail($email);

        if ($user && password_verify($password, $user->password)) {

            $this->session->set_userdata([
                'id_user' => $user->id_user,
                'nama'    => $user->nama,
                'email'   => $user->email,
                'login'   => TRUE
            ]);
            $this->session->set_flashdata('status', 'login_sukses');


            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Email atau password salah');
            redirect('login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

    public function register()
    {
        $this->load->view('auth/register');
    }

    public function proses_register()
    {
        $nama     = $this->input->post('nama');
        $email    = $this->input->post('email');
        $no_hp    = $this->input->post('no_hp');
        $password = $this->input->post('password');

        if ($this->Muser->getByEmail($email)) {
            $this->session->set_flashdata('error', 'Email sudah terdaftar');
            redirect('register');
        }

        $data = [
            'nama'     => $nama,
            'email'    => $email,
            'no_hp'    => $no_hp,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $this->Muser->insert($data);
        $this->session->set_flashdata('success', 'Registrasi berhasil, silakan login');
        redirect('login');

        $this->session->set_flashdata('success', 'Registrasi berhasil, silakan login');
        redirect('login');
    }
}
