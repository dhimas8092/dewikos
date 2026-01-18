<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('admin_login')) {
            redirect('login');
        }
    }

    public function index() {
        $data['kamar_tersedia'] = $this->db->where('status', 'Tersedia')->from('kamar')->count_all_results();
        $data['kamar_terisi']   = $this->db->where('status', 'Terisi')->from('kamar')->count_all_results();
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
        $data['grafik_data']   = json_encode($counts);
    
        $this->load->view('dashboard', $data);
    }
}