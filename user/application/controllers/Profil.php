<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Muser');
        $this->load->library('session');

        if (!$this->session->userdata('login')) {
            redirect('login');
        }
    }

    public function index() {
        $id_user = $this->session->userdata('id_user');
        $data['user'] = $this->Muser->getById($id_user);
        $this->load->view('profil/index', $data);
    }

    public function update() {
        $id_user = $this->session->userdata('id_user');
        $nama  = $this->input->post('nama');
        $email = $this->input->post('email');
        $no_hp = $this->input->post('no_hp');
        $pass  = $this->input->post('password');
    
        $data = [
            'nama'  => $nama,
            'email' => $email,
            'no_hp' => $no_hp,
        ];
        if (!empty($pass)) {
            $data['password'] = password_hash($pass, PASSWORD_DEFAULT);
        }
        $this->Muser->update($id_user, $data);
        $this->session->set_userdata([
            'nama'  => $nama,
            'email' => $email
        ]);
    
        $this->session->set_flashdata('success', 'Profil berhasil diperbarui');
        redirect('profil');
    }

    public function edit() {
        $id_user = $this->session->userdata('id_user');
        $data['user'] = $this->db->get_where('user', ['id_user' => $id_user])->row();
        $this->load->view('profil/edit', $data);
    }
    
}
