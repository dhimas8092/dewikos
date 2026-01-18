<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemesanan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mpemesanan');
        $this->load->model('Mkamar');
        $this->load->library('session');

        if (!$this->session->userdata('login')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $id_user = $this->session->userdata('id_user');
        $data['pemesanan'] = $this->Mpemesanan->getByUser($id_user);
        $this->load->view('pemesanan/riwayat', $data);
    }
    
    public function tambah($id_kamar) {
        $data['kamar'] = $this->Mkamar->getById($id_kamar);
    
        if (!$data['kamar']) {
            show_404();
        }
        $this->load->view('pemesanan/form', $data);
    }

    public function proses() {
        $id_user   = $this->session->userdata('id_user');
        $id_kamar  = $this->input->post('id_kamar');
        $lama_sewa = $this->input->post('lama_sewa');
        $kamar = $this->Mkamar->getById($id_kamar);
    
        if (!$kamar || $kamar->status != 'tersedia') {
            $this->session->set_flashdata('error', 'Kamar tidak tersedia.');
            redirect('kamar');
        }
    
        $total_harga = $kamar->harga * $lama_sewa;
        $data_pemesanan = [
            'id_user'            => $id_user,
            'id_kamar'           => $id_kamar,
            'tanggal_pesan'      => date('Y-m-d'),
            'lama_sewa'          => $lama_sewa,
            'total_harga'        => $total_harga,
            'status_pemesanan'   => 'menunggu',
            'tanggal_mulai'      => date('Y-m-d'),
            'tanggal_selesai'    => date('Y-m-d', strtotime("+$lama_sewa months"))
        ];
    
        $id_pemesanan = $this->Mpemesanan->insert($data_pemesanan);
    
        if ($id_pemesanan) {
            $data_pembayaran = [
                'id_pemesanan'     => $id_pemesanan,
                'metode'           => 'Belum Memilih',
                'total_bayar'      => $total_harga,
                'status'           => 'pending',
                'tgl_pembayaran'   => date('Y-m-d H:i:s'),
                'bukti_pembayaran' => ''
            ];
            $this->db->insert('pembayaran', $data_pembayaran);
    
            redirect('pembayaran/pilih_metode/' . $id_pemesanan);
        } else {
            $this->session->set_flashdata('error', 'Gagal memproses pemesanan.');
            redirect('kamar/detail/' . $id_kamar);
        }
    }
}