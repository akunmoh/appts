<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kas extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('keuangan_model');
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/dropify/css/dropify.min.css',
            ),
            'js' => array(
                'js/employee.js',
                'vendor/dropify/js/dropify.min.js',
            ),
        );
    }
    public function index()
    {
        $this->pemasukkan();
    }
    // --------------------------------------------------------------------
    // BAGIAN KAS MASUK
    // --------------------------------------------------------------------
    public function pemasukkan()
    {
        if (!get_permission('kas_masuk', 'is_view')) {
            access_denied();
        }

        $this->data['pemasukkan'] = $this->keuangan_model->pemasukkan_list();
        $this->data['sumberlist'] = $this->app_lib->getSelectList('pemasukkan_sumber');
        $this->data['title'] = 'Kas Masuk';
        $this->data['sub_page'] = 'kas/pemasukkan';
        $this->data['main_menu'] = 'keuangan';
        $this->load->view('layout/index', $this->data);
    }
    
    public function pemasukkan_edit()
    {
        $id = $this->input->post('id');
        $this->data['pemasukkan'] = $this->keuangan_model->get_list('pemasukkan', array('id' => $id), true);
        $this->data['sumberlist'] = $this->app_lib->getSelectList('pemasukkan_sumber');
        $this->load->view('kas/pemasukkan_edit', $this->data);
    }

    public function aksi_pemasukkan($action = '', $id = '')
    {
        if ($action == 'simpan') {
            if (!get_permission('kas_masuk', 'is_add')) {
                access_denied();
            }

            $this->form_validation->set_rules('sumber_id', 'Sumber pemasukkan', 'trim|required');
            $this->form_validation->set_rules('nama', 'Nama pemasukkan', 'trim|required');
            $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $this->keuangan_model->save_pemasukkan($post);
                set_alert('success', 'Berhasil menambahkan data');
                redirect(base_url('kas/pemasukkan'));
            }
        }
        if ($action == 'hapus') {
            if (!get_permission('kas_masuk', 'is_delete')) {
                access_denied();
            }

            //Ubah saldo rekening
            $pemasukkan = $this->app_lib->get_table('pemasukkan', $id, TRUE);
            $this->keuangan_model->update_saldo($pemasukkan['nominal'],false);
            //Hapus kas
            $this->keuangan_model->hapus_kas($pemasukkan['kode']);
            //Hapus pemasukkan
            $this->db->where('id', $id);
            $this->db->delete('pemasukkan');
        }
    }

    // --------------------------------------------------------------------
    // BAGIAN KAS KELUAR
    // --------------------------------------------------------------------
    public function pengeluaran()
    {
        if (!get_permission('kas_keluar', 'is_view')) {
            access_denied();
        }

        $this->data['pengeluaran'] = $this->keuangan_model->pengeluaran_list();
        $this->data['sumberlist'] = $this->app_lib->getSelectList('pengeluaran_sumber');
        $this->data['title'] = 'Kas Keluar';
        $this->data['sub_page'] = 'kas/pengeluaran';
        $this->data['main_menu'] = 'keuangan';
        $this->load->view('layout/index', $this->data);
    }

    public function pengeluaran_edit()
    {
        $id = $this->input->post('id');
        $this->data['pengeluaran'] = $this->keuangan_model->get_list('pengeluaran', array('id' => $id), true);
        $this->data['sumberlist'] = $this->app_lib->getSelectList('pengeluaran_sumber');
        $this->load->view('kas/pengeluaran_edit', $this->data);
    }

    public function aksi_pengeluaran($action = '', $id = '')
    {
        if ($action == 'simpan') {
            if (!get_permission('kas_keluar', 'is_add')) {
                access_denied();
            }

            $this->form_validation->set_rules('sumber_id', 'Sumber pengeluaran', 'trim|required');
            $this->form_validation->set_rules('nama', 'Nama pengeluaran', 'trim|required');
            $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $this->keuangan_model->save_pengeluaran($post);
                set_alert('success', 'Berhasil menambahkan data');
                redirect(base_url('kas/pengeluaran'));
            }
        }
        if ($action == 'hapus') {
            if (!get_permission('kas_keluar', 'is_delete')) {
                access_denied();
            }
            //Ubah saldo rekening
            $pengeluaran = $this->app_lib->get_table('pengeluaran', $id, TRUE);
            $this->keuangan_model->update_saldo($pengeluaran['nominal']);
            //Hapus kas
            $this->keuangan_model->hapus_kas($pengeluaran['kode']);
            //Hapus pengeluaran
            $this->db->where('id', $id);
            $this->db->delete('pengeluaran');
        }
    }

    // --------------------------------------------------------------------
    // BAGIAN PENGATURAN KAS
    // --------------------------------------------------------------------
    public function pengaturan($action = 'pemasukkan')
    {
        if (!get_permission('pengaturan_keuangan', 'is_view')) {
            access_denied();
        }

        if ($_POST) {
            if (!get_permission('pengaturan_keuangan', 'is_edit')) {
                access_denied();
            }
        }

        if ($this->input->post('submit') == 'pemasukkan') {
            $this->form_validation->set_rules('nama', 'Sumber Pemasukkan', 'trim|required|callback_unique_spemasukan');
            if ($this->form_validation->run() !== false) {
                $this->db->insert('pemasukkan_sumber', array('nama' => $this->input->post('nama')));
                set_alert('success', 'Berhasil menambahkan data');
                redirect(base_url('kas/pengaturan/pemasukkan'));
            } else {
                $this->data['validation_error'] = true;
                $this->session->set_flashdata('form_modal', 1);
            }
        }

        if ($this->input->post('submit') == 'pengeluaran') {
            $this->form_validation->set_rules('nama', 'Sumber Pengeluaran', 'trim|required|callback_unique_spengeluaran');
            if ($this->form_validation->run() !== false) {
                $this->db->insert('pengeluaran_sumber', array('nama' => $this->input->post('nama')));
                set_alert('success', 'Berhasil menambahkan data');
                redirect(base_url('kas/pengaturan/pengeluaran'));
            } else {
                $this->data['validation_error'] = true;
                $this->session->set_flashdata('form_modal', 1);
            }
        }

        if ($action == 'pemasukkan') {
            $this->data['inside_subview'] = 'sumber_pemasukkan';
        } elseif ($action == 'pengeluaran') {
            $this->data['inside_subview'] = 'sumber_pengeluaran';
        }

        $this->data['pemasukanlist'] = $this->keuangan_model->get_list('pemasukkan_sumber');
        $this->data['pengeluaranlist'] = $this->keuangan_model->getPengeluaranList();

        $this->data['title'] = 'Pengaturan Keuangan';
        $this->data['sub_page'] = 'kas/pengaturan';
        $this->data['main_menu'] = 'pengaturan';
        $this->load->view('layout/index', $this->data);
    }

    // --------------------------------------------------------------------
    // BAGIAN SUMBER PEMASUKKAN
    // --------------------------------------------------------------------
    public function sumber_pemasukkan_edit()
    {
        $id = $this->input->post('id');
        $this->data['sumber'] = $this->keuangan_model->get_list('pemasukkan_sumber', array('id' => $id), true);
        $this->load->view('kas/sumber_pemasukkan_edit', $this->data);
    }

    public function sumber_pemasukkan_post()
    {
        if (!get_permission('sumber_kas_masuk', 'is_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('nama', 'Sumber pemasukkan', 'trim|required|callback_unique_spemasukan');
        if ($this->form_validation->run() !== false) {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('pemasukkan_sumber', array('nama' => $this->input->post('nama')));
            set_alert('success', 'Data telah berhasil diperbarui');
        }
        redirect(base_url('kas/pengaturan/pemasukkan'));
    }

    public function sumber_pemasukkan_delete($id)
    {
        if (!get_permission('sumber_kas_masuk', 'is_delete')) {
            access_denied();
        }
        $this->db->where('id', $id);
        $this->db->delete('pemasukkan_sumber');
    }

    public function unique_spemasukan($nama)
    {
        $id = $this->input->post('id');
        if (!empty($id)) {
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('nama', $nama);
        $query = $this->db->get('pemasukkan_sumber');
        if ($query->num_rows() > 0) {
            if (!empty($id)) {
                set_alert('error', "Nama sumber sudah ada, silahkan gunakan nama lain.");
            } else {
                $this->form_validation->set_message("unique_kategori", "Nama sumber sudah ada, silahkan gunakan nama lain.");
            }
            return false;
        } else {
            return true;
        }
    }

    // --------------------------------------------------------------------
    // BAGIAN SUMBER PENGELUARAN
    // --------------------------------------------------------------------
    public function sumber_pengeluaran_edit()
    {
        $id = $this->input->post('id');
        $this->data['sumber'] = $this->keuangan_model->get_list('pengeluaran_sumber', array('id' => $id), true);
        $this->load->view('kas/sumber_pengeluaran_edit', $this->data);
    }

    public function sumber_pengeluaran_post()
    {
        if (!get_permission('sumber_kas_keluar', 'is_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('nama', 'Sumber pengeluaran', 'trim|required|callback_unique_spengeluaran');
        if ($this->form_validation->run() !== false) {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('pengeluaran_sumber', array('nama' => $this->input->post('nama')));
            set_alert('success', 'Data telah berhasil diperbarui');
        }
        redirect(base_url('kas/pengaturan/pengeluaran'));
    }

    public function sumber_pengeluaran_delete($id)
    {
        if (!get_permission('sumber_kas_keluar', 'is_delete')) {
            access_denied();
        }
        $this->db->where('id', $id);
        $this->db->delete('pengeluaran_sumber');
    }

    public function unique_spengeluaran($nama)
    {
        $id = $this->input->post('id');
        if (!empty($id)) {
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('nama', $nama);
        $query = $this->db->get('pengeluaran_sumber');
        if ($query->num_rows() > 0) {
            if (!empty($id)) {
                set_alert('error', "Nama sumber sudah ada, silahkan gunakan nama lain.");
            } else {
                $this->form_validation->set_message("unique_kategori", "Nama sumber sudah ada, silahkan gunakan nama lain.");
            }
            return false;
        } else {
            return true;
        }
    }

}