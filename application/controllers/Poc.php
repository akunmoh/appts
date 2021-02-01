<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Poc extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('po_model');
    }

    public function index()
    {
        redirect(base_url('dashboard'));
    }

    public function view($po_id = 2)
    {
        if (!get_permission('non_sinar_jaya', 'is_view') || ($po_id == 1 )) {
            access_denied();
        }

        $this->data['po_id'] = $po_id;
        $this->data['title'] = 'P.O Stand C';
        $this->data['sub_page'] = 'po/view';
        $this->data['main_menu'] = 'po';
        $this->data['buslist'] = $this->po_model->get_nonsj_list($po_id);
        $this->load->view('layout/index', $this->data);
    }
    public function proses($action = '', $id = '')
    {
        if ($action == 'simpan') {
            $this->form_validation->set_rules('layanan', 'Layanan', 'trim|required');
            $this->form_validation->set_rules('no_bodi', 'Nomor Bodi', 'trim|required');
            $this->form_validation->set_rules('nama_sopir', 'Nama Sopir', 'trim|required');
            $this->form_validation->set_rules('jml_pnp', 'Jumlah Penumpang', 'trim|required');
            $this->form_validation->set_rules('kedatangan', 'Kedatangan', 'trim|required');
            $this->form_validation->set_rules('dari', 'Dari', 'trim|required');
            $this->form_validation->set_rules('tujuan', 'Tujuan', 'trim|required');
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $this->po_model->save_data($post);
                set_alert('success', 'Berhasil menambahkan data');
                redirect(base_url('poc/view/'.$this->input->post('po_id')));
            }
        }
        if ($action == 'hapus') {
            $this->db->where('id', $id);
            $this->db->delete('po_bus');
        }
    }

}
