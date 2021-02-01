<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('absensi_model');
    }

    public function index()
    {
        if (!get_permission('absensi', 'is_view')) {
            access_denied();
        }

        $jabatan = $this->input->post('jabatan_id');
        if (isset($_POST['search'])) {
            $this->form_validation->set_rules('tanggal', 'Date', 'trim|required|callback_get_valid_date');
            if ($this->form_validation->run() !== false) {
                $tanggal = $this->input->post('tanggal');
                $this->data['tanggal'] = $tanggal;
                $this->data['stafflist'] = $this->absensi_model->absensi_list($jabatan, $tanggal);
            }
        }else{
            $tanggal = date('Y-m-d');
            $this->data['tanggal'] = $tanggal;
            $this->data['stafflist'] = $this->absensi_model->absensi_list($jabatan, $tanggal);
        }
        
        if (isset($_POST['attensave'])) {
            if (!get_permission('absensi', 'is_add')) {
                access_denied();
            }
            $attendance = $this->input->post('attendance');
            $tanggal = $this->input->post('tanggal');
            foreach ($attendance as $key => $value) {
                $arrayData = array(
                    'pegawai_id' => $value['pegawai_id'],
                    'status' => $value['status'],
                    'keterangan' => $value['keterangan'],
                    'tanggal' => $tanggal,
                );
                if (empty($value['old_absen_id'])) {
                    $this->db->insert('pegawai_absensi', $arrayData);
                } else {
                    $this->db->where('id', $value['old_absen_id']);
                    $this->db->update('pegawai_absensi', $arrayData);
                }
            }
            set_alert('success', 'Berhasil menyimpan data');
            redirect(base_url('absensi'));
        }

        $this->data['jabatanlist'] = $this->app_lib->getSelectList('pegawai_jabatan');

        $this->data['title'] = 'Absensi Pegawai';
        $this->data['sub_page'] = 'absensi/index';
        $this->data['main_menu'] = 'pegawai';
        $this->load->view('layout/index', $this->data);
    }

    public function laporan()
    {
        // check access permission
        if (!get_permission('laporan_absensi', 'is_view')) {
            access_denied();
        }
        $jabatan = $this->input->post('jabatan_id');
        if (isset($_POST['search'])) {
            $timestamp = $this->input->post('timestamp');
            $this->data['bulan'] = date('m', strtotime($timestamp));
            $this->data['tahun'] = date('Y', strtotime($timestamp));
            $this->data['hari'] = cal_days_in_month(CAL_GREGORIAN, $this->data['bulan'], $this->data['tahun']);
            $this->data['pegawailist'] = $this->absensi_model->laporan_absensi($jabatan);
        }else{
            $timestamp = date('Y-F');
            $this->data['bulan'] = date('m', strtotime($timestamp));
            $this->data['tahun'] = date('Y', strtotime($timestamp));
            $this->data['hari'] = cal_days_in_month(CAL_GREGORIAN, $this->data['bulan'], $this->data['tahun']);
            $this->data['pegawailist'] = $this->absensi_model->laporan_absensi($jabatan);
        }
        $this->data['jabatanlist'] = $this->app_lib->getSelectList('pegawai_jabatan');
        $this->data['title'] = 'Laporan Absensi Pegawai';
        $this->data['sub_page'] = 'absensi/laporan';
        $this->data['main_menu'] = 'laporan_absensi';
        $this->load->view('layout/index', $this->data);
    }

    public function get_valid_date($date)
    {
        $present_date = date('Y-m-d');
        $date = date("Y-m-d", strtotime($date));
        if ($date > $present_date) {
            $this->form_validation->set_message("get_valid_date", "Please Enter Correct Date.");
            return false;
        } else {
            return true;
        }
    }
}
