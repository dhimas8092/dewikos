<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemesanan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_login')) {
            redirect('login');
        }
        $this->load->model('Mpemesanan');
    }

    public function index() {
    $data['pemesanan'] = $this->Mpemesanan->getAllFullData(); 
    $this->load->view('pemesanan/index', $data);
    }

    public function update($id_pemesanan, $status) {
        $this->Mpemesanan->updateStatus($id_pemesanan, $status);
    
        if ($status == 'batal') {
            $detail = $this->db->get_where('pemesanan', ['id_pemesanan' => $id_pemesanan])->row();
            if ($detail) {
                $this->db->where('id_pemesanan', $id_pemesanan);
                $this->db->update('pembayaran', ['status' => 'batal']);
    
                $this->db->where('id_kamar', $detail->id_kamar);
                $this->db->update('kamar', ['status' => 'Tersedia']);
            }
        }
        redirect('pemesanan');
    }
}