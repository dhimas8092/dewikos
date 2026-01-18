<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muser extends CI_Model {

    public function getByEmail($email) {
        return $this->db->where('email', $email)
                        ->get('user')
                        ->row();
    }

    public function insert($data) {
        return $this->db->insert('user', $data);
    }

    public function getById($id_user) {
        return $this->db->where('id_user', $id_user)
                        ->get('user')
                        ->row();
    }
public function update($id, $data) {
    $this->db->where('id_user', $id);
    return $this->db->update('user', $data);
}
    
}