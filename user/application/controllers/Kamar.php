<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kamar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mkamar');
    }

    public function index() {
        $keyword = $this->input->get('keyword');
        if ($keyword) {
            $data['kamar'] = $this->Mkamar->cariKamar($keyword);
            $data['keyword_pencarian'] = $keyword;
        } else {
            $data['kamar'] = $this->Mkamar->getTersedia();
            $data['keyword_pencarian'] = null;
        }
        $this->load->view('kamar/index', $data);
    }

    public function detail($id_kamar) {
        $data['kamar'] = $this->Mkamar->getById($id_kamar);
        $this->load->view('kamar/detail', $data);
    }
}