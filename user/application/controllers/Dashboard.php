<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');

        if (!$this->session->userdata('login')) {
            redirect('login');
        }
    }

    public function index() {
        $keyword = $this->input->get('keyword');
        
        if ($keyword) {
            redirect('kamar/index?keyword=' . urlencode($keyword));
        }
        $this->db->where('status', 'tersedia');
        $this->db->limit(7);
        $this->db->order_by('id_kamar', 'DESC');
        $data['rekomendasi'] = $this->db->get('kamar')->result();

        $this->load->view('dashboard/index', $data);
    }
}