<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penggajian extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('penggajian_model');
        $this->load->model('pegawai_model');
        $this->load->model('absensi_model');
        $this->load->model('keuangan_model');
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

    // --------------------------------------------------------------------
    // BAGIAN DATA PEGAWAI
    // --------------------------------------------------------------------
    public function index()
    {
        if (!get_permission('penggajian', 'is_view')) {
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

        $this->data['title'] = 'Penggajian';
        $this->data['sub_page'] = 'penggajian/index';
        $this->data['main_menu'] = 'pegawai';
        $this->load->view('layout/index', $this->data);
    }
    // --------------------------------------------------------------------
    // BAGIAN HITUNG GAJI
    // --------------------------------------------------------------------
    public function hitung()
    {
        $id = $this->input->post('id');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        $this->data['pegawai'] = $this->pegawai_model->getPegawai($id);
        $this->data['kasbon'] = $this->pegawai_model->getKasbon($id,$bulan,$tahun);
        $this->data['bulan'] = $bulan;
        $this->data['tahun'] = $tahun;


        $hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        $total_present = 0;
		$total_absent = 0;
        $total_late = 0;
        for ($i = 1; $i <= $hari; $i++) { 
            $tanggal = date('Y-m-d', strtotime($tahun . '-' . $bulan . '-' . $i));
            $absen = $this->absensi_model->absen_by_date($id, $tanggal);
            if (!empty($absen)) {
                if ($absen['status'] == 'A') { $total_absent++; }
                if ($absen['status'] == 'P') { $total_present++; }
                if ($absen['status'] == 'L') { $total_late++; }
            }
            $this->data['total_masuk'] = $total_present;
            $this->data['total_alfa'] = $total_absent;
            $this->data['total_terlambat'] = $total_late;
        }

        $this->load->view('penggajian/hitung_gaji', $this->data);
    }

    function hitung_gaji()
    {
        if (!get_permission('penggajian', 'is_add')) {
            access_denied();
        }
        $gaji_pokok = $this->input->post("gaji_pokok");
        $total_tambahan = $this->input->post("total_tambahan");
        $total_potongan = $this->input->post("total_potongan");
        $total_gaji = $this->input->post("total_gaji");
        $status = $this->input->post("status");
        $pegawai_id = $this->input->post("pegawai_id");
        $bulan = $this->input->post("bulan");
        $tahun = $this->input->post("tahun");
        $this->form_validation->set_rules('total_gaji', 'Total Gaji', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->hitung($bulan, $tahun, $pegawai_id);
        } else {
            $kode = substr(app_generate_hash(), 3, 7);
            $data = array(
                'kode' => $kode,
                'pegawai_id' => $pegawai_id,
                'gaji_pokok' => $gaji_pokok,
                'tambahan' => $total_tambahan,
                'potongan' => $total_potongan,
                'total_gaji' => $total_gaji,
                'status' => $status,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'tanggal' => date("Y-m-d"),
                'staff_id' => get_loggedin_user_id(),
            );
            $checkForUpdate = $this->penggajian_model->checkGaji($bulan, $tahun, $pegawai_id);
            if ($checkForUpdate == true) {
                $insert_id = $this->penggajian_model->simpanGaji($data);
                $gaji_id = $insert_id;

                $tambahan = $this->input->post("tambahan");
                $potongan = $this->input->post("potongan");

                if (!empty($tambahan)) {
                    foreach ($tambahan as $key => $value) {
                        $all_data = array('gaji_id' => $gaji_id,
                            'keterangan' => $value['nama'],
                            'nominal' => $value['nominal'],
                            'pegawai_id' => $pegawai_id,
                            'jenis' => "tambahan",
                        );
                        $insert_tambahan = $this->penggajian_model->add_tunjangan($all_data);
                    }
                }

                if (!empty($potongan)) {
                    foreach ($potongan as $key => $value) {
                        $type_data = array('gaji_id' => $gaji_id,
                            'keterangan' => $value['nama'],
                            'nominal' => $value['nominal'],
                            'pegawai_id' => $pegawai_id,
                            'jenis' => "potongan",
                        );
                        $insert_potongan = $this->penggajian_model->add_tunjangan($type_data);
                    }
                }

                set_alert('success', 'Berhasil menghitung gaji karyawan');
                redirect(base_url('penggajian'));
            } else {
                set_alert('error', "Perhitungan gaji sudah di hitung");
                redirect(base_url('penggajian'));
            }
        }
    }
    // --------------------------------------------------------------------
    // BAGIAN RESET
    // --------------------------------------------------------------------
    function hapusgaji($gaji_id) {
        if (!get_permission('penggajian', 'is_delete')) {
            access_denied();
        }
        if (!empty($gaji_id)) {
            $this->penggajian_model->hapusGaji($gaji_id);
        }

        redirect('penggajian');
    }

    public function bayar_gaji()
    {
        $id = $this->input->post('id');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $this->data['gaji'] = $this->penggajian_model->getGaji($id,$bulan,$tahun);
        $this->load->view('penggajian/bayar_gaji', $this->data);
    }

    public function simpan_gaji()
    {
        if (!get_permission('penggajian', 'is_add')) {
            access_denied();
        }

        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
        if ($this->form_validation->run() !== false) {
            $id = $this->input->post('id');
            $tanggal = $this->input->post('tanggal');
            $keterangan = $this->input->post('keterangan');
            $pegawai_id = $this->input->post('pegawai_id');
            $kode = $this->input->post('kode');
            $nominal = $this->input->post('nominal');
            $staff_id = get_loggedin_user_id();

            $this->db->where('id', $id);
            $this->db->update('pegawai_gaji', array('tanggal' => $tanggal,'status' => 'dibayar','keterangan' => $keterangan));
            // insert kas
            $nama_pegawai = $this->pegawai_model->getNamaById($pegawai_id);
            // Insert Pengeluaran
            $insert_pengeluaran = array(
                'kode' => $kode,
                'sumber_id' => 1,
                'nama' => 'Bayar gaji pegawai '.$nama_pegawai->nama,
                'nominal' => $nominal,
                'tanggal' => $tanggal,
                'staff_id' => $staff_id,
            );
            $this->db->insert('pengeluaran', $insert_pengeluaran);
            // Insert ke Pembukuan
            $insert_transaksi = array(
                'reff_no' => $kode,
                'keterangan' => 'Bayar gaji pegawai '.$nama_pegawai->nama,
                'type' => 'pengeluaran',
                'nominal' => $nominal,
                'debit' => '0',
                'kredit' => $nominal,
                'tanggal' => $tanggal,
                'staff_id' => $staff_id,
            );
            $this->db->insert('kas', $insert_transaksi);
            // update saldo rekening
            $this->keuangan_model->update_saldo($nominal,false);

            set_alert('success', 'Gaji berhasil di bayarkan');
        }
        redirect(base_url('penggajian'));
    }

    public function slipgaji()
    {
        $id = $this->input->post('id');
        $this->data['slipgaji'] = $this->penggajian_model->slipGaji($id);
        $this->load->view('penggajian/slip_gaji', $this->data);
    }

    function resetgaji($id) {
        //Ubah saldo rekening
        $gaji = $this->app_lib->get_table('pegawai_gaji', $id, TRUE);
        $this->keuangan_model->update_saldo($gaji['total_gaji']);
        //Hapus kas dan pengeluaran
        $this->keuangan_model->hapus_kas($gaji['kode']);
        $this->keuangan_model->hapus_pengeluaran($gaji['kode']);

        //Balikan Status Gaji
        $this->db->where('id', $id);
        $this->db->update('pegawai_gaji', array('status' => 'dihitung'));
        set_alert('success', 'Berhasil merubah status');

        redirect("penggajian");
    }

}