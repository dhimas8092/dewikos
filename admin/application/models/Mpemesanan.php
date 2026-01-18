<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpemesanan extends CI_Model
{

    public function getAllFullData(){
        $this->db->select('pemesanan.*, kamar.nama_kamar');
        $this->db->from('pemesanan');
        $this->db->join('kamar', 'kamar.id_kamar = pemesanan.id_kamar');
        $this->db->order_by('pemesanan.id_pemesanan', 'desc');
        return $this->db->get()->result();
    }

    public function updateStatus($id_pemesanan, $status) {
        $pesanan = $this->db->get_where('pemesanan', ['id_pemesanan' => $id_pemesanan])->row();
        if ($pesanan) {
            $status_baru = ($status == 'batal') ? 'dibatalkan' : $status;
            
            $this->db->where('id_pemesanan', $id_pemesanan);
            $this->db->update('pemesanan', ['status_pemesanan' => $status_baru]);
            if ($status_baru == 'dibatalkan' || $status_baru == 'selesai') {
                $this->db->where('id_kamar', $pesanan->id_kamar);
                $this->db->update('kamar', ['status' => 'Tersedia']);
            }
        }
    }
}
