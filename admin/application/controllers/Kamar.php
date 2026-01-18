<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kamar extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mkamar');
        $this->load->library('session');

        if (!$this->session->userdata('admin_login')) {
            redirect('login');
        }
    }

    public function index()
    {
        $data['kamar'] = $this->db->get('kamar')->result();
        $data['total_tersedia'] = $this->db->where('status', 'tersedia')->from('kamar')->count_all_results();
        $data['total_terisi']   = $this->db->where('status', 'terisi')->from('kamar')->count_all_results();

        $this->load->view('kamar/index', $data);
    }

    public function tambah()
    {
        $this->load->view('kamar/tambah');
    }

    public function simpan() {
        $config['upload_path']   = FCPATH . '../assets/fotokamar/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['encrypt_name']  = TRUE;
    
        $this->load->library('upload', $config);
        $fasilitas = $this->input->post('fasilitas');
        $fasilitas_string = !empty($fasilitas) ? implode(',', $fasilitas) : '';

        if ($this->upload->do_upload('foto_kamar')) {
            $uploadData = $this->upload->data();
            $foto = $uploadData['file_name'];
    
            $data = [
                'nama_kamar' => $this->input->post('nama_kamar'),
                'deskripsi'  => $this->input->post('deskripsi'),
                'harga'      => $this->input->post('harga'),
                'fasilitas'  => $fasilitas_string,
                'status'     => 'tersedia',
                'foto'       => $foto
            ];
    
            $this->Mkamar->insert($data);
            redirect('kamar');
        } else {
            echo $this->upload->display_errors();
        }
    }


    public function edit($id_kamar)
    {
        $data['kamar'] = $this->Mkamar->getById($id_kamar);
        $this->load->view('kamar/edit', $data);
    }

    public function update($id_kamar)
    {
        $fasilitas = $this->input->post('fasilitas');
        $fasilitas_string = !empty($fasilitas) ? implode(',', $fasilitas) : '';

        $data = [
            'nama_kamar' => $this->input->post('nama_kamar'),
            'deskripsi'  => $this->input->post('deskripsi'),
            'harga'      => $this->input->post('harga'),
            'fasilitas'  => $fasilitas_string,
            'status'     => $this->input->post('status')
        ];

        if (!empty($_FILES['foto_kamar_baru']['name'])) {
            $config['upload_path']   =  FCPATH . '../assets/fotokamar/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['encrypt_name']  = TRUE;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto_kamar_baru')) {
                $data['foto'] = $this->upload->data('file_name');
            }
        }

        $this->Mkamar->update($id_kamar, $data);
        redirect('kamar');
    }

    public function hapus($id_kamar)
    {
        $kamar = $this->Mkamar->getById($id_kamar);

        if ($kamar) {
            $this->db->where('id_kamar', $id_kamar);
            $this->db->delete('pemesanan');
            if (!empty($kamar->foto)) {
                $path = FCPATH . '../assets/fotokamar/' . $kamar->foto;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $this->Mkamar->delete($id_kamar);
            $this->session->set_flashdata('pesan', 'Kamar dan seluruh riwayat pesanannya berhasil dihapus.');
        }

        redirect('kamar');
    }
}