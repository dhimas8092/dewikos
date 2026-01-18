<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpemesanan extends CI_Model {
    public function getById($id_pemesanan) {
        return $this->db->get_where('pemesanan', ['id_pemesanan' => $id_pemesanan])->row();
    }

    public function insert($data) {
        $this->db->insert('pemesanan', $data);
        return $this->db->insert_id();
    }

    public function getByUser($id_user) {
        $this->db->select('pemesanan.*, kamar.nama_kamar');
        $this->db->from('pemesanan');
        $this->db->join('kamar', 'kamar.id_kamar = pemesanan.id_kamar');
        $this->db->where('pemesanan.id_user', $id_user);
        $this->db->order_by('pemesanan.tanggal_pesan', 'DESC');
        return $this->db->get()->result();
    }

    public function set_lunas($id_pemesanan) {
        $this->db->where('id_pemesanan', $id_pemesanan);
        $this->db->update('pemesanan', ['status_pemesanan' => 'dibayar']);
    }

    public function get_all_by_user($id_user) {
        $this->db->select('pemesanan.*, kamar.nama_kamar, kamar.harga, kamar.foto');
        $this->db->from('pemesanan');
        $this->db->join('kamar', 'kamar.id_kamar = pemesanan.id_kamar');
        $this->db->where('pemesanan.id_user', $id_user);
        $this->db->order_by('pemesanan.tanggal_pesan', 'DESC'); 
        
        return $this->db->get()->result();
    }
}