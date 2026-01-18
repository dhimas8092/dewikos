<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    private $serverKey = 'asdasdasdsdadasdasdasds';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mpemesanan');
        $this->load->model('Mkamar');
        if (!$this->session->userdata('login')) {
            redirect('auth/login');
        }
    }

    public function pilih_metode($id_pemesanan)
    {
        $pemesanan = $this->Mpemesanan->getById($id_pemesanan);
        if (!$pemesanan) show_404();
        if ($pemesanan->id_user != $this->session->userdata('id_user')) {
            redirect('pemesanan');
        }

        $kamar = $this->Mkamar->getById($pemesanan->id_kamar);
        $data_bayar = $this->db->get_where('pembayaran', ['id_pemesanan' => $id_pemesanan])->row();
        
        if (!$data_bayar) {
             $input = [
                'id_pemesanan'   => $id_pemesanan,
                'metode'         => 'Belum Memilih',
                'total_bayar'    => (int)($kamar->harga * $pemesanan->lama_sewa),
                'status'         => 'pending',
                'tgl_pembayaran' => date('Y-m-d H:i:s')
             ];
             $this->db->insert('pembayaran', $input);
             $id_pembayaran_final = $this->db->insert_id();
             $total_bayar_final   = $input['total_bayar'];
        } else {
             $id_pembayaran_final = $data_bayar->id_pembayaran;
             $total_bayar_final   = $data_bayar->total_bayar;
        }

        require_once FCPATH . 'midtrans-php/Midtrans.php';
        \Midtrans\Config::$serverKey = $this->serverKey;
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $id_pembayaran_final, 
                'gross_amount' => $total_bayar_final
            ],
            'customer_details' => [
                'first_name' => $this->session->userdata('nama')
            ]
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (Exception $e) {
            echo "Error Midtrans: " . $e->getMessage();
            die;
        }

        $data = [
            'pemesanan' => $pemesanan,
            'snapToken' => $snapToken,
            'kamar'     => $kamar,
            'id_pembayaran_final' => $id_pembayaran_final 
        ];

        $this->load->view('auth/pembayaran/pilih_metode', $data);
    }

    public function qris($id_pemesanan)
    {
        $pemesanan = $this->Mpemesanan->getById($id_pemesanan);
        if (!$pemesanan || $pemesanan->id_user != $this->session->userdata('id_user')) {
            redirect('pemesanan');
        }
        $kamar = $this->Mkamar->getById($pemesanan->id_kamar);
        $total_bayar = $kamar->harga * $pemesanan->lama_sewa;
        $data = [
            'pemesanan'   => $pemesanan,
            'total_bayar' => $total_bayar
        ];
        $this->load->view('auth/pembayaran/qris', $data);
    }

    public function finish()
    {
        $order_id = $this->input->get('order_id');

        if ($order_id) {
            require_once FCPATH . 'midtrans-php/Midtrans.php';
            \Midtrans\Config::$serverKey = $this->serverKey; 
            \Midtrans\Config::$isProduction = false;

            try {
                $status = \Midtrans\Transaction::status($order_id);
                $status_transaksi = $status->transaction_status;
                $fraud_status = $status->fraud_status;

                $status_bayar_db = 'pending';
                $is_paid = false;

                if ($status_transaksi == 'capture' || $status_transaksi == 'settlement') {
                    if ($status_transaksi == 'capture' && $fraud_status == 'challenge') {
                        $status_bayar_db = 'challenge';
                    } else {
                        $status_bayar_db = 'success';
                        $is_paid = true;
                    }
                } else if ($status_transaksi == 'deny' || $status_transaksi == 'expire' || $status_transaksi == 'cancel') {
                    $status_bayar_db = 'failure'; 
                }
                $this->db->where('id_pembayaran', $order_id);
                $this->db->update('pembayaran', ['status' => $status_bayar_db]);
                if ($is_paid) {
                    $data_bayar = $this->db->get_where('pembayaran', ['id_pembayaran' => $order_id])->row();
                    
                    if ($data_bayar) {
                        $id_pemesanan = $data_bayar->id_pemesanan;
                        $data_pesan = $this->db->get_where('pemesanan', ['id_pemesanan' => $id_pemesanan])->row();
                        
                        if ($data_pesan) {
                            $this->db->where('id_kamar', $data_pesan->id_kamar);
                            $this->db->update('kamar', ['status' => 'terisi']); 
                        }      
                        $this->db->where('id_pemesanan', $id_pemesanan);
                        $this->db->update('pemesanan', ['status_pemesanan' => 'dibayar']);
                    }
                }

            } catch (Exception $e) {
            }
        }
        redirect('pemesanan');
    }
}