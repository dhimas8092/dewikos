<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Madmin extends CI_Model {

    private $table = 'admin';

    public function getByUsername($username) {
        return $this->db->get_where($this->table, ['username' => $username])->row();
    }
}