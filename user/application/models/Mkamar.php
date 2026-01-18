<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mkamar extends CI_Model {

    public function getAll() {
        return $this->db->get('kamar')->result();
    }

    public function getTersedia() {
        return $this->db->where('status', 'tersedia')
                        ->get('kamar')
                        ->result();
    }

    public function getById($id_kamar) {
        return $this->db
            ->get_where('kamar', ['id_kamar' => $id_kamar])
            ->row();
    }

public function cariKamar($keyword)
{
    $this->db->select('*');
    $this->db->from('kamar');
    $this->db->group_start();
        $this->db->like('nama_kamar', $keyword);
        $this->db->or_like('fasilitas', $keyword);
        $this->db->or_like('deskripsi', $keyword);
    $this->db->group_end();
    $this->db->where('status', 'Tersedia'); 

    return $this->db->get()->result();
}
}