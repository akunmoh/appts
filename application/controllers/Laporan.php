<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('keuangan_model');
        $this->load->model('gudang_model');
        $this->load->model('penggajian_model');
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/daterangepicker/daterangepicker.css',
            ),
            'js' => array(
                'vendor/moment/moment.js',
                'vendor/daterangepicker/daterangepicker.js',
            ),
        );
    }
    public function index()
    {
        $this->pemasukkan();
    }
    // --------------------------------------------------------------------
    // BAGIAN LAPORAN PEMASUKKAN
    // --------------------------------------------------------------------
    public function pemasukkan()
    {
        if (!get_permission('laporan_kas_masuk', 'is_view')) {
            access_denied();
        }
        if (isset($_POST['search'])) {
            $sumber_id = $this->input->post('sumber_id');
            $tanggal = $this->input->post('tanggal');
            $this->data['pemasukkan'] = $this->keuangan_model->pemasukkan_list($sumber_id,$tanggal);
        } else {
            $this->data['pemasukkan'] = $this->keuangan_model->pemasukkan_list();
        }

        $this->data['sumberlist'] = $this->app_lib->getSelectList('pemasukkan_sumber');
        $this->data['title'] = 'Laoran Kas Masuk';
        $this->data['sub_page'] = 'laporan/pemasukkan';
        $this->data['main_menu'] = 'laporan_keuangan';
        $this->load->view('layout/index', $this->data);
    }

    // --------------------------------------------------------------------
    // BAGIAN LAPORAN PENGELUARAN
    // --------------------------------------------------------------------
    public function pengeluaran()
    {
        if (!get_permission('laporan_kas_keluar', 'is_view')) {
            access_denied();
        }
        if (isset($_POST['search'])) {
            $sumber_id = $this->input->post('sumber_id');
            $tanggal = $this->input->post('tanggal');
            $this->data['pengeluaran'] = $this->keuangan_model->pengeluaran_list($sumber_id,$tanggal);
        } else {
            $this->data['pengeluaran'] = $this->keuangan_model->pengeluaran_list();
        }

        $this->data['sumberlist'] = $this->app_lib->getSelectList('pengeluaran_sumber');
        $this->data['title'] = 'Laporan Kas Keluar';
        $this->data['sub_page'] = 'laporan/pengeluaran';
        $this->data['main_menu'] = 'laporan_keuangan';
        $this->load->view('layout/index', $this->data);
    }

    // --------------------------------------------------------------------
    // BAGIAN LAPORAN KAS
    // --------------------------------------------------------------------
    public function kas()
    {
        if (!get_permission('laporan_kas', 'is_view')) {
            access_denied();
        }
        if ($_POST) {
            $daterange = explode(' - ', $this->input->post('daterange'));
            $start = date("Y-m-d", strtotime($daterange[0]));
            $end = date("Y-m-d", strtotime($daterange[1]));
            $this->data['daterange'] = $daterange;
            $this->data['saldo_awal'] = $this->keuangan_model->get_saldo_awal($start);
            $this->data['jurnal'] = $this->keuangan_model->get_laporan_kas($start, $end);
        }
        $this->data['title'] = 'Laporan Kas';
        $this->data['sub_page'] = 'laporan/kas';
        $this->data['main_menu'] = 'laporan_keuangan';
        $this->load->view('layout/index', $this->data);
    }

        // --------------------------------------------------------------------
    // BAGIAN LAPORAN PENGGAJIAN
    // --------------------------------------------------------------------
    public function penggajian()
    {
        if (!get_permission('laporan_penggajian', 'is_view')) {
            access_denied();
        }
        $jabatan = $this->input->post('jabatan_id');
        if (isset($_POST['search'])) {
            $this->data['month'] = date("m", strtotime($this->input->post('month_year')));
            $this->data['year'] = date("Y", strtotime($this->input->post('month_year')));
            $this->data['payslip'] = $this->penggajian_model->get_summary($this->data['month'], $this->data['year'], $jabatan);
            $this->data['bulan'] = $this->data['month'];
            $this->data['tahun'] = $this->data['year'];
        }else{
            $bulan = date('m');
            $tahun = date('Y');
            $this->data['payslip'] = $this->penggajian_model->get_summary($bulan, $tahun, $jabatan);
            $this->data['bulan'] = $bulan;
            $this->data['tahun'] = $tahun;
        }
        $this->data['jabatanlist'] = $this->app_lib->getSelectList('pegawai_jabatan');

        $this->data['title'] = 'Laporan Penggajian';
        $this->data['sub_page'] = 'laporan/penggajian';
        $this->data['main_menu'] = 'laporan_keuangan';
        $this->load->view('layout/index', $this->data);
    }

    // --------------------------------------------------------------------
    // BAGIAN LAPORAN STOCK
    // --------------------------------------------------------------------
    public function laporan_stock(){
        if (!get_permission('laporan_stock', 'is_view')) {
            access_denied();
        }

        $this->data['stocklist'] = $this->gudang_model->laporan_stock();
        $this->data['title'] = 'Laproan Stock Barang';
        $this->data['sub_page'] = 'laporan/laporan_stock';
        $this->data['main_menu'] = 'laporan_gudang';
        $this->load->view('layout/index', $this->data);
    }

    // --------------------------------------------------------------------
    // BAGIAN LAPORAN BARANG MASUK
    // --------------------------------------------------------------------
    public function barang_masuk(){
        if (!get_permission('laporan_barang_masuk', 'is_view')) {
            access_denied();
        }
        if ($_POST) {
            $daterange = explode(' - ', $this->input->post('daterange'));
            $start = date("Y-m-d", strtotime($daterange[0]));
            $end = date("Y-m-d", strtotime($daterange[1]));
            $this->data['daterange'] = $daterange;
            $this->data['lapmasuk'] = $this->gudang_model->laporan_masuk($start, $end);
        }
        $this->data['title'] = 'Laproan Barang Masuk';
        $this->data['sub_page'] = 'laporan/barang_masuk';
        $this->data['main_menu'] = 'laporan_gudang';
        $this->load->view('layout/index', $this->data);
    }

    // --------------------------------------------------------------------
    // BAGIAN LAPORAN BARANG KELUAR
    // --------------------------------------------------------------------
    public function barang_keluar(){
        if (!get_permission('laporan_barang_keluar', 'is_view')) {
            access_denied();
        }

        if ($_POST) {
            $lokasi_id = $this->input->post('lokasi_id');
            $daterange = explode(' - ', $this->input->post('daterange'));
            $start = date("Y-m-d", strtotime($daterange[0]));
            $end = date("Y-m-d", strtotime($daterange[1]));
            $this->data['daterange'] = $daterange;
            $this->data['lapkeluar'] = $this->gudang_model->laporan_keluar($start, $end, $lokasi_id);
        }
        $this->data['lokasilist'] = $this->app_lib->getSelectList('pegawai_lokasi');
        $this->data['title'] = 'Laproan Barang Keluar';
        $this->data['sub_page'] = 'laporan/barang_keluar';
        $this->data['main_menu'] = 'laporan_gudang';
        $this->load->view('layout/index', $this->data);
    }


}