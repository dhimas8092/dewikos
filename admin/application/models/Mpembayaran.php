<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpembayaran extends CI_Model {

    public function getAll() {
        return $this->db
            ->select('pb.*, pb.total_bayar as total, u.nama, k.nama_kamar, p.id_pemesanan')
            ->from('pembayaran pb')
            ->join('pemesanan p','p.id_pemesanan=pb.id_pemesanan')
            ->join('user u','u.id_user=p.id_user')
            ->join('kamar k','k.id_kamar=p.id_kamar')
            ->get()->result();
    }

    public function setStatus($id, $status) {
        $db_status = ($status == 'terima') ? 'success' : 'failed';
    
        $this->db->where('id_pembayaran', $id)->update('pembayaran', ['status' => $db_status]);
    
        $data_pb = $this->db->get_where('pembayaran', ['id_pembayaran' => $id])->row();
        $id_pesan = $data_pb->id_pemesanan;
    
        if ($db_status == 'success') {
            $this->db->where('id_pemesanan', $id_pesan)->update('pemesanan', ['status_pemesanan' => 'dibayar']);
            $pesan = $this->db->get_where('pemesanan', ['id_pemesanan' => $id_pesan])->row();
            $this->db->where('id_kamar', $pesan->id_kamar)->update('kamar', ['status' => 'terisi']);
        } else {
            $this->db->where('id_pemesanan', $id_pesan)->update('pemesanan', ['status_pemesanan' => 'dibatalkan']);
            $pesan = $this->db->get_where('pemesanan', ['id_pemesanan' => $id_pesan])->row();
            $this->db->where('id_kamar', $pesan->id_kamar)->update('kamar', ['status' => 'tersedia']);
        }
    }
}
