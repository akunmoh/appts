<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pegawai_model');
        $this->load->model('keuangan_model');
    }
    // --------------------------------------------------------------------
    // BAGIAN DATA PEGAWAI
    // --------------------------------------------------------------------
    public function index()
    {
        if (!get_permission('pegawai', 'is_view')) {
            access_denied();
        }
        if (isset($_POST['search'])) {
            $lokasi = $this->input->post('lokasi_id');
            $jabatan = $this->input->post('jabatan_id');
            $shift = $this->input->post('shift_id');
            $this->data['pegawailist'] = $this->pegawai_model->get_pegawai_list($lokasi,$jabatan,$shift);
        } else {
            $this->data['pegawailist'] = $this->pegawai_model->get_pegawai_list();
        }
        $this->data['lokasilist'] = $this->app_lib->getSelectList('pegawai_lokasi');
        $this->data['jabatanlist'] = $this->app_lib->getSelectList('pegawai_jabatan');
        $this->data['shiftlist'] = $this->app_lib->getSelectList('pegawai_shift');

        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/dropify/css/dropify.min.css',
            ),
            'js' => array(
                'js/employee.js',
                'vendor/dropify/js/dropify.min.js',
            ),
        );
        
        $this->data['title'] = 'Data Pegawai';
        $this->data['sub_page'] = 'pegawai/index';
        $this->data['main_menu'] = 'pegawai';
        $this->load->view('layout/index', $this->data);
    }

    protected function validation()
    {
        $this->form_validation->set_rules('lokasi_id', 'Lokasi', 'trim|required');
        $this->form_validation->set_rules('jabatan_id', 'Jabatan', 'trim|required');
        $this->form_validation->set_rules('shift_id', 'Shift', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('notelp', 'No telp', 'trim|required');
        $this->form_validation->set_rules('pendidikan', 'Pendidikan', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
    }

    public function submitted_data($action = '', $id = '')
    {
        if ($action == 'create') {
            if (!get_permission('pegawai', 'is_add')) {
                access_denied();
            }
            $this->validation();
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $user_id = $this->pegawai_model->save($post);

                set_alert('success', 'Berhasil menambahkan data');
                redirect(base_url('pegawai'));
            }
        }

        if ($action == 'delete') {
            if (!get_permission('pegawai', 'is_delete')) {
                access_denied();
            }
            $photo = $this->db->select('photo')->where('id', $id)->get('pegawai')->row()->photo;
            $this->db->where('id', $id);
            $this->db->delete('pegawai');

            if (file_exists('uploads/photo/pegawai/'.$photo)) {
                unlink('uploads/photo/pegawai/' . $photo );
            }
        }
    }

    public function detail($id = '')
    {
        if (!get_permission('pegawai', 'is_edit')) {
            access_denied();
        }
        if ($this->input->post('submit') == 'update') {
            $this->validation();
            if ($this->form_validation->run() == true) {
                $this->pegawai_model->save($this->input->post());

                set_alert('success', 'Data telah berhasil diperbarui');
                $this->session->set_flashdata('profile_tab', 1);
                redirect(base_url('pegawai/detail/' . $id));
            } else {
                $this->session->set_flashdata('profile_tab', 1);
            }
        }
        $this->data['pegawai'] = $this->pegawai_model->getPegawai($id);
        $this->data['lokasilist'] = $this->app_lib->getSelectList('pegawai_lokasi','all');
        $this->data['jabatanlist'] = $this->app_lib->getSelectList('pegawai_jabatan','all');
        $this->data['shiftlist'] = $this->app_lib->getSelectList('pegawai_shift','all');

        $this->data['title'] = 'Detail Pegawai';
        $this->data['sub_page'] = 'pegawai/detail';
        $this->data['main_menu'] = 'pegawai';
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/dropify/css/dropify.min.css',
            ),
            'js' => array(
                'js/employee.js',
                'vendor/dropify/js/dropify.min.js',
            ),
        );
        $this->load->view('layout/index', $this->data);
    }

    // --------------------------------------------------------------------
    // BAGIAN PENGATURAN PEGAWAI
    // --------------------------------------------------------------------
    public function pengaturan($action = 'lokasi')
    {
        if (!get_permission('pengaturan_pegawai', 'is_view')) {
            access_denied();
        }

        if ($_POST) {
            if (!get_permission('pengaturan_pegawai', 'is_edit')) {
                access_denied();
            }
        }

        if ($this->input->post('submit') == 'lokasi') {
            $this->form_validation->set_rules('nama', 'Nama Lokasi', 'trim|required|callback_unique_lokasi');
            if ($this->form_validation->run() !== false) {
                $this->db->insert('pegawai_lokasi', array('nama' => $this->input->post('nama')));
                set_alert('success', 'Berhasil menambahkan data');
                redirect(base_url('pegawai/pengaturan/lokasi'));
            } else {
                $this->data['validation_error'] = true;
                $this->session->set_flashdata('form_modal', 1);
            }
        }

        if ($this->input->post('submit') == 'jabatan') {
            $this->form_validation->set_rules('nama', 'Nama Jabatan', 'trim|required|callback_unique_jabatan');
            if ($this->form_validation->run() !== false) {
                $this->db->insert('pegawai_jabatan', array('nama' => $this->input->post('nama')));
                set_alert('success', 'Berhasil menambahkan data');
                redirect(base_url('pegawai/pengaturan/jabatan'));
            } else {
                $this->data['validation_error'] = true;
                $this->session->set_flashdata('form_modal', 1);
            }
        }

        if ($this->input->post('submit') == 'shift') {
            $this->form_validation->set_rules('nama', 'Nama Shift', 'trim|required|callback_unique_shift');
            $this->form_validation->set_rules('jam_masuk', 'Jam Masuk', 'trim|required');
            $this->form_validation->set_rules('jam_keluar', 'Jam Keluar', 'trim|required');
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $this->pegawai_model->save_shift($post);
                set_alert('success', 'Berhasil menambahkan data');
                redirect(base_url('pegawai/pengaturan/shift'));
            } else {
                $this->data['validation_error'] = true;
                $this->session->set_flashdata('form_modal', 1);
            }
        }

        if ($action == 'lokasi') {
            $this->data['inside_subview'] = 'lokasi';
        } elseif ($action == 'jabatan') {
            $this->data['inside_subview'] = 'jabatan';
        } elseif ($action == 'shift') {
            $this->data['inside_subview'] = 'shift';
        }

        $this->data['lokasilist'] = $this->pegawai_model->get_list('pegawai_lokasi');
        $this->data['jabatanlist'] = $this->pegawai_model->get_list('pegawai_jabatan');
        $this->data['shiftlist'] = $this->pegawai_model->get_list('pegawai_shift');
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/bootstrap-timepicker/css/bootstrap-timepicker.css',
            ),
            'js' => array(
                'vendor/bootstrap-timepicker/bootstrap-timepicker.js',
            ),
        );
        $this->data['title'] = 'Pengaturan Pegawai';
        $this->data['sub_page'] = 'pegawai/pengaturan';
        $this->data['main_menu'] = 'pengaturan';
        $this->load->view('layout/index', $this->data);
    }

    // --------------------------------------------------------------------
    // BAGIAN LOKASI PEGAWAI
    // --------------------------------------------------------------------
    public function lokasi_edit()
    {
        $id = $this->input->post('lokasi_id');
        $this->data['lokasi'] = $this->pegawai_model->get_list('pegawai_lokasi', array('id' => $id), true);
        $this->load->view('pegawai/lokasi_edit', $this->data);
    }

    public function lokasi_edit_post()
    {
        if (!get_permission('lokasi_pegawai', 'is_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('nama', 'Nama Lokasi', 'trim|required|callback_unique_lokasi');
        if ($this->form_validation->run() !== false) {
            $lokasi_id = $this->input->post('lokasi_id');
            $this->db->where('id', $lokasi_id);
            $this->db->update('pegawai_lokasi', array('nama' => $this->input->post('nama')));
            set_alert('success', 'Data telah berhasil diperbarui');
        }
        redirect(base_url('pegawai/pengaturan/lokasi'));
    }

    public function lokasi_delete($id)
    {
        if (!get_permission('lokasi_pegawai', 'is_delete')) {
            access_denied();
        }
        $this->db->where('id', $id);
        $this->db->delete('pegawai_lokasi');
    }

    public function unique_lokasi($nama)
    {
        $lokasi_id = $this->input->post('lokasi_id');
        if (!empty($lokasi_id)) {
            $this->db->where_not_in('id', $lokasi_id);
        }
        $this->db->where('nama', $nama);
        $query = $this->db->get('pegawai_lokasi');
        if ($query->num_rows() > 0) {
            if (!empty($lokasi_id)) {
                set_alert('error', "Nama lokasi sudah ada, silahkan gunakan nama lain.");
            } else {
                $this->form_validation->set_message("unique_lokasi", "Nama lokasi sudah ada, silahkan gunakan nama lain.");
            }
            return false;
        } else {
            return true;
        }
    }

    // --------------------------------------------------------------------
    // BAGIAN JABATAN PEGAWAI
    // --------------------------------------------------------------------
    public function jabatan_edit()
    {
        $id = $this->input->post('jabatan_id');
        $this->data['jabatan'] = $this->pegawai_model->get_list('pegawai_jabatan', array('id' => $id), true);
        $this->load->view('pegawai/jabatan_edit', $this->data);
    }

    public function jabatan_edit_post()
    {
        if (!get_permission('jabatan_pegawai', 'is_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('nama', 'Nama Jabatan', 'trim|required|callback_unique_jabatan');
        if ($this->form_validation->run() !== false) {
            $jabatan_id = $this->input->post('jabatan_id');
            $this->db->where('id', $jabatan_id);
            $this->db->update('pegawai_jabatan', array('nama' => $this->input->post('nama')));
            set_alert('success', 'Data telah berhasil diperbarui');
        }
        redirect(base_url('pegawai/pengaturan/jabatan'));
    }

    public function jabatan_delete($id)
    {
        if (!get_permission('jabatan_pegawai', 'is_delete')) {
            access_denied();
        }
        $this->db->where('id', $id);
        $this->db->delete('pegawai_jabatan');
    }

    public function unique_jabatan($nama)
    {
        $jabatan_id = $this->input->post('jabatan_id');
        if (!empty($jabatan_id)) {
            $this->db->where_not_in('id', $jabatan_id);
        }
        $this->db->where('nama', $nama);
        $query = $this->db->get('pegawai_jabatan');
        if ($query->num_rows() > 0) {
            if (!empty($jabatan_id)) {
                set_alert('error', "Nama jabatan sudah ada, silahkan gunakan nama lain.");
            } else {
                $this->form_validation->set_message("unique_jabatan", "Nama jabatan sudah ada, silahkan gunakan nama lain.");
            }
            return false;
        } else {
            return true;
        }
    }

    // --------------------------------------------------------------------
    // BAGIAN SHIFT PEGAWAI
    // --------------------------------------------------------------------
    public function shift_edit()
    {
        $id = $this->input->post('shift_id');
        $this->data['shift'] = $this->pegawai_model->get_list('pegawai_shift', array('id' => $id), true);
        $this->load->view('pegawai/shift_edit', $this->data);
    }

    public function shift_edit_post()
    {
        if (!get_permission('shift_pegawai', 'is_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('nama', 'Nama shift', 'trim|required|callback_unique_shift');
        $this->form_validation->set_rules('jam_masuk', 'Jam Masuk', 'trim|required');
        $this->form_validation->set_rules('jam_keluar', 'Jam Keluar', 'trim|required');
        if ($this->form_validation->run() !== false) {
            $post = $this->input->post();
            $this->pegawai_model->save_shift($post);
            set_alert('success', 'Data telah berhasil diperbarui');
        }
        redirect(base_url('pegawai/pengaturan/shift'));
    }

    public function shift_delete($id)
    {
        if (!get_permission('shift_pegawai', 'is_delete')) {
            access_denied();
        }
        $this->db->where('id', $id);
        $this->db->delete('pegawai_shift');
    }

    public function unique_shift($nama)
    {
        $shift_id = $this->input->post('id');
        if (!empty($shift_id)) {
            $this->db->where_not_in('id', $shift_id);
        }
        $this->db->where('nama', $nama);
        $query = $this->db->get('pegawai_shift');
        if ($query->num_rows() > 0) {
            if (!empty($shift_id)) {
                set_alert('error', "Nama shift sudah ada, silahkan gunakan nama lain.");
            } else {
                $this->form_validation->set_message("unique_shift", "Nama shift sudah ada, silahkan gunakan nama lain.");
            }
            return false;
        } else {
            return true;
        }
    }

    // --------------------------------------------------------------------
    // KASBON PEGAWAI
    // --------------------------------------------------------------------
    public function kasbon()
    {
        if (!get_permission('kasbon', 'is_view')) {
            access_denied();
        }

        $this->data['kasbon'] = $this->pegawai_model->kasbon_list();
        $this->data['pegawailist'] = $this->app_lib->getSelectList('pegawai');
        $this->data['title'] = 'Manage Kasbon';
        $this->data['sub_page'] = 'pegawai/kasbon';
        $this->data['main_menu'] = 'pegawai';
        $this->load->view('layout/index', $this->data);
    }

    public function kasbon_proses($action = '', $id = '')
    {
        if ($action == 'simpan') {
            if (!get_permission('kasbon', 'is_add')) {
                access_denied();
            }

            $this->form_validation->set_rules('pegawai_id', 'Nama Pegawai', 'trim|required');
            $this->form_validation->set_rules('nominal', 'Nominal', 'trim|required');
            $this->form_validation->set_rules('month_year', 'Tanggal', 'trim|required');
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $this->pegawai_model->save_kasbon($post);
                set_alert('success', 'Berhasil menambahkan data');
                redirect(base_url('pegawai/kasbon'));
            }
        }
        if ($action == 'hapus') {
            if (!get_permission('kasbon', 'is_delete')) {
                access_denied();
            }
            //Ubah saldo rekening
            $kasbon = $this->app_lib->get_table('pegawai_kasbon', $id, TRUE);
            $this->keuangan_model->update_saldo($kasbon['nominal']);
            //Hapus kas dan pengeluaran
            $this->keuangan_model->hapus_kas($kasbon['kode']);
            $this->keuangan_model->hapus_pengeluaran($kasbon['kode']);
            //Hapus pengeluaran
            $this->db->where('id', $id);
            $this->db->delete('pegawai_kasbon');
        }
    }
}