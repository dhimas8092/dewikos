<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mpembayaran');
        $this->load->model('Mpemesanan');
        $this->load->model('Mkamar');
        if ($this->router->fetch_method() != 'notification') {
            if (!$this->session->userdata('admin_login')) {
                redirect('login');
            }
        }
    }

    public function index() {

        $data['pembayaran'] = $this->Mpembayaran->getAll();
        $data['total_trx'] = $this->db->count_all('pemesanan');
        $data['total_pending'] = $this->db->group_start()
                                          ->where('status_pemesanan', 'menunggu')
                                          ->or_where('status_pemesanan', 'pending')
                                          ->group_end()
                                          ->from('pemesanan')
                                          ->count_all_results();
        $data['total_diterima'] = $this->db->group_start()
                                           ->where('status_pemesanan', 'dibayar')
                                           ->or_where('status_pemesanan', 'lunas')
                                           ->or_where('status_pemesanan', 'selesai')
                                           ->or_where('status_pemesanan', 'success')
                                           ->group_end()
                                           ->from('pemesanan')
                                           ->count_all_results();
        $data['total_ditolak'] = $this->db->group_start()
                                          ->where('status_pemesanan', 'batal')
                                          ->or_where('status_pemesanan', 'dibatalkan')
                                          ->or_where('status_pemesanan', 'failed')
                                          ->or_where('status_pemesanan', 'expire')
                                          ->group_end()
                                          ->from('pemesanan')
                                          ->count_all_results();
        $labels = [];
        $counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $labels[] = date('D', strtotime($date));
            $counts[] = $this->db->where('DATE(tgl_pembayaran)', $date)
                                 ->from('pembayaran')
                                 ->count_all_results();
        }
        
        $data['grafik_labels'] = json_encode($labels);
        $data['grafik_data'] = json_encode($counts);
    
        $this->load->view('pembayaran/index', $data);
    }
    public function terima($id_pembayaran) {
        $this->db->where('id_pembayaran', $id_pembayaran);
        $this->db->update('pembayaran', ['status' => 'success']);
        $bayar = $this->db->get_where('pembayaran', ['id_pembayaran' => $id_pembayaran])->row();
        
        if ($bayar) {
            $this->db->where('id_pemesanan', $bayar->id_pemesanan);
            $this->db->update('pemesanan', ['status_pemesanan' => 'dibayar']);
            $pesanan = $this->db->get_where('pemesanan', ['id_pemesanan' => $bayar->id_pemesanan])->row();
            $this->db->where('id_kamar', $pesanan->id_kamar);
            $this->db->update('kamar', ['status' => 'Terisi']);
        }
        
        redirect('pembayaran');
    }

    public function tolak($id_pembayaran) {
        $pembayaran = $this->db->get_where('pembayaran', ['id_pembayaran' => $id_pembayaran])->row();
        if ($pembayaran) {
            $this->db->where('id_pembayaran', $id_pembayaran);
            $this->db->update('pembayaran', ['status' => 'batal']);
            $this->db->where('id_pemesanan', $pembayaran->id_pemesanan);
            $this->db->update('pemesanan', ['status_pemesanan' => 'dibatalkan']);
            $pemesanan = $this->db->get_where('pemesanan', ['id_pemesanan' => $pembayaran->id_pemesanan])->row();
            if ($pemesanan) {
                $this->db->where('id_kamar', $pemesanan->id_kamar);
                $this->db->update('kamar', ['status' => 'Tersedia']);
            }
        }

        redirect('pembayaran');
    }

    public function notification() {
        $json = file_get_contents('php://input');
        $notif = json_decode($json);
    
        if ($notif) {
            $status_transaksi = $notif->transaction_status;
            $type_pembayaran  = $notif->payment_type;
            $order_id         = $notif->order_id;
            $bayar = $this->db->get_where('pembayaran', ['id_pembayaran' => $order_id])->row();
    
            if ($bayar) {
                $metode_fix = $type_pembayaran;
                if ($type_pembayaran == 'bank_transfer') {
                    if (isset($notif->va_numbers)) {
                        $metode_fix = 'Bank ' . strtoupper($notif->va_numbers[0]->bank);
                    } else {
                        $metode_fix = 'Transfer Bank (Permata/Lainnya)';
                    }
                } else if ($type_pembayaran == 'echannel') {
                    $metode_fix = 'Bank Mandiri Bill';
                }
    
                if ($status_transaksi == 'settlement' || $status_transaksi == 'capture') {
                    
                    $data_update_bayar = [
                        'status' => 'success',
                        'metode' => $metode_fix
                    ];
                    
                    $this->db->where('id_pembayaran', $order_id);
                    $this->db->update('pembayaran', $data_update_bayar);
    
                    $this->db->where('id_pemesanan', $bayar->id_pemesanan);
                    $this->db->update('pemesanan', ['status_pemesanan' => 'dibayar']);

                    $pesanan = $this->db->get_where('pemesanan', ['id_pemesanan' => $bayar->id_pemesanan])->row();
                    $this->db->where('id_kamar', $pesanan->id_kamar);
                    $this->db->update('kamar', ['status' => 'Terisi']);
                }
                else if ($status_transaksi == 'expire' || $status_transaksi == 'cancel' || $status_transaksi == 'deny') {
                    $this->db->where('id_pembayaran', $order_id);
                    $this->db->update('pembayaran', ['status' => 'failed']);
                }
            }
        }
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
                        $this->Mpemesanan->updateStatus($id_pemesanan, 'dibayar');
                        
                    }
                }

            } catch (Exception $e) {
            }
        }
        redirect('pemesanan');
    }
}