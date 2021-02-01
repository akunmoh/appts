<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Beranda extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('beranda_model');
        $this->load->model('po_model');
    }

    public function index()
    {
        // Sinar Jaya
        $po_id = 1;
        $tanggal = date('Y-m-d');
        $this->data['data_bus'] = $this->po_model->laporan_list($tanggal,$po_id);
        $this->data['tot_pnp'] = $this->po_model->tot_penumpang($tanggal,$po_id);
        $this->data['tot_bus'] = $this->po_model->total_bus($tanggal,$po_id);
        $this->data['barat'] = $this->po_model->barat($tanggal,$po_id);
        $this->data['timur'] = $this->po_model->timur($tanggal,$po_id);

        // Non Sinar Jaya
        $this->data['data_bus2'] = $this->po_model->laporan_list($tanggal);
        $this->data['tot_pnp2'] = $this->po_model->tot_penumpang($tanggal);
        $this->data['tot_bus2'] = $this->po_model->total_bus($tanggal);
        $this->data['barat2'] = $this->po_model->barat($tanggal);
        $this->data['timur2'] = $this->po_model->timur($tanggal);

        // Gudang
        $this->data['get_total_barang'] = $this->beranda_model->get_total_barang();
        $this->data['get_masuk'] = $this->beranda_model->get_masuk();
        $this->data['get_keluar'] = $this->beranda_model->get_keluar();
        $this->data['get_stock'] = $this->beranda_model->get_stock();
        $this->data['stocklimit'] = $this->beranda_model->stocklimit();

        $this->data['masuklist'] = $this->beranda_model->masuklist();
        $this->data['keluarlist'] = $this->beranda_model->keluarlist();

        // Admin
        $this->data['get_total_pegawai'] = $this->beranda_model->get_total_pegawai();
        $this->data['get_pendapatan_pengeluaran'] = $this->beranda_model->get_pendapatan_pengeluaran();
        $this->data['saldo'] = $this->beranda_model->get_saldo();
        
        $this->data['grafik_tahunan'] = $this->beranda_model->get_grafik_tahunan();
        $this->data['grafik_bulanan'] = $this->beranda_model->get_grafik_bulanan();

        $this->data['title'] = 'Beranda';
        $this->data['sub_page'] = 'beranda/index';
        $this->data['headerelements'] = array(
           'js' => array(
               'vendor/chartjs/chart.min.js',
               'vendor/chartjs/utils.js',
           ),
        );
        $this->data['main_menu'] = 'beranda';
        $this->load->view('layout/index', $this->data);
    }

}
