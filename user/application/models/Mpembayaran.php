<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpembayaran extends CI_Model {

    public function insert($data) {
        return $this->db->insert('pembayaran', $data);
    }

    public function getByPemesanan($id_pemesanan) {
        return $this->db->where('id_pemesanan', $id_pemesanan)
                        ->get('pembayaran')
                        ->row();
    }
}