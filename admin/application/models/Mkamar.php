<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mkamar extends CI_Model {

    public function getAll() {
        return $this->db->get('kamar')->result();
    }

    public function getById($id_kamar) {
        return $this->db->where('id_kamar', $id_kamar)
                        ->get('kamar')
                        ->row();
    }

    public function insert($data) {
        return $this->db->insert('kamar', $data);
    }

    public function update($id_kamar, $data) {
        return $this->db->where('id_kamar', $id_kamar)
                        ->update('kamar', $data);
    }

    public function updateStatus($id_kamar, $status)
    {
        return $this->db->where('id_kamar', $id_kamar)
            ->update('kamar', ['status' => $status]);
    }

    public function delete($id_kamar)
{
    $this->db->select('id_pemesanan');
    $this->db->where('id_kamar', $id_kamar);
    $data_pemesanan = $this->db->get('pemesanan')->result_array();

    if (!empty($data_pemesanan)) {
        $ids = array_column($data_pemesanan, 'id_pemesanan');
        $this->db->where_in('id_pemesanan', $ids);
        $this->db->delete('pembayaran');
    }
    $this->db->where('id_kamar', $id_kamar);
    $this->db->delete('pemesanan');
    $this->db->where('id_kamar', $id_kamar);
    return $this->db->delete('kamar');
}
}