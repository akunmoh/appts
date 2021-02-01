<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Po extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('po_model');
    }

    public function index()
    {
        if (!get_permission('sinar_jaya', 'is_view')) {
            access_denied();
        }
        $po_id = 1;
        $this->data['po'] = $this->po_model->data_list($po_id);
        $this->data['title'] = 'Sinar Jaya';
        $this->data['sub_page'] = 'po/sinarjaya';
        $this->data['main_menu'] = 'po';
        $this->load->view('layout/index', $this->data);
    }
    public function sinarjaya_edit()
    {
        $id = $this->input->post('id');
        $this->data['po'] = $this->po_model->get_list('po_bus', array('id' => $id), true);
        $this->load->view('po/sinarjaya_edit', $this->data);
    }
    public function nonsinar_edit()
    {
        $id = $this->input->post('id');
        $this->data['po'] = $this->po_model->get_list('po_bus', array('id' => $id), true);
        $this->load->view('po/nonsinar_edit', $this->data);
    }
    // --------------------------------------------------------------------
    // BAGIAN PENGATURAN
    // --------------------------------------------------------------------
    public function pengaturan()
    {
        if (!get_permission('pengaturan_po', 'is_view')) {
            access_denied();
        }

        if ($_POST) {
            if (!get_permission('pengaturan_po', 'is_add')) {
                access_denied();
            }

            $this->form_validation->set_rules('nama', 'Nama', 'trim|required|xss_clean');
            if ($this->form_validation->run() == false) {
                $this->data['validation_error'] = true;
            } else {
                $data = $this->input->post();
                $this->po_model->save_po($data);
                set_alert('success', 'Data telah berhasil ditambahkan');
                redirect(base_url('po/pengaturan'));
            }
        }
        $this->data['po'] = $this->po_model->get_list('po_nama');

        $this->data['title'] = 'Master Data PO Bus';
        $this->data['sub_page'] = 'po/pengaturan';
        $this->data['main_menu'] = 'pengaturan';
        $this->load->view('layout/index', $this->data);
    }

    // --------------------------------------------------------------------
    // BAGIAN PROSES DATA
    // --------------------------------------------------------------------
    public function proses($action = '', $id = '')
    {
        if ($action == 'simpan') {
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
                redirect(base_url('po'));
            }
        }
        if ($action == 'hapus') {
            $this->db->where('id', $id);
            $this->db->delete('po_bus');
        }
    }
    // --------------------------------------------------------------------
    // BAGIAN LAPORAN BUS
    // --------------------------------------------------------------------
    public function laporan()
    {
        if (!get_permission('laporan_po', 'is_view')) {
            access_denied();
        }

        if (isset($_POST['search'])) {
            $po_id = $this->input->post('po_id');
            $tanggal = $this->input->post('tanggal');
            $this->data['data_bus'] = $this->po_model->laporan_list($tanggal,$po_id);
            $this->data['tot_pnp'] = $this->po_model->tot_penumpang($tanggal,$po_id);
            $this->data['tot_bus'] = $this->po_model->total_bus($tanggal,$po_id);
            $this->data['barat'] = $this->po_model->barat($tanggal,$po_id);
            $this->data['timur'] = $this->po_model->timur($tanggal,$po_id);
            $this->data['tanggal'] = $tanggal;
            $this->data['po_id'] = $po_id;
        } 

        $this->data['po_list'] = $this->app_lib->getSelectList('po_nama');
        $this->data['title'] = 'Laporan P.O Bus';
        $this->data['sub_page'] = 'laporan/po';
        $this->data['main_menu'] = 'laporan_po';
        $this->load->view('layout/index', $this->data);
    }

}