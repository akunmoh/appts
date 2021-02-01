<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save_shift($data)
    {
        $insert_data = array(
            'nama' => $data['nama'],
            'jam_masuk' => $data['jam_masuk'],
            'jam_keluar' => $data['jam_keluar'],
        );

        if (isset($data['id']) && !empty($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('pegawai_shift', $insert_data);
        } else {
            $this->db->insert('pegawai_shift', $insert_data);
        }
    }

    public function get_pegawai_list($lokasi = '',$jabatan = '',$shift = '')
    {
        $this->db->select('pegawai.*,pegawai_lokasi.nama as nama_lokasi,pegawai_jabatan.nama as nama_jabatan,pegawai_shift.nama as shift');
        $this->db->from('pegawai');
        $this->db->join('pegawai_lokasi', 'pegawai_lokasi.id = pegawai.lokasi_id', 'left');
        $this->db->join('pegawai_jabatan', 'pegawai_jabatan.id = pegawai.jabatan_id', 'left');
        $this->db->join('pegawai_shift', 'pegawai_shift.id = pegawai.shift_id', 'left');

        if (!empty($lokasi)) {
            $this->db->where('pegawai.lokasi_id', $lokasi);
        }
        if (!empty($jabatan)) {
            $this->db->where('pegawai.jabatan_id', $jabatan);
        }
        if (!empty($shift)) {
            $this->db->where('pegawai.shift_id', $shift);
        }
        $this->db->order_by('pegawai.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function save($data)
    {
        $gaji_pokok = preg_replace('/[^0-9]/', '', $data['gaji_pokok']);
        $insert_data = array(
            'lokasi_id' => $data['lokasi_id'],
            'jabatan_id' => $data['jabatan_id'],
            'shift_id' => $data['shift_id'],
            'nama' => $data['nama'],
            'notelp' => $data['notelp'],
            'tempat_lahir' => $data['tempat_lahir'],
            'tgl_lahir' => $data['tgl_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'pendidikan' => $data['pendidikan'],
            'agama' => $data['agama'],
            'status_pernikahan' => $data['status_pernikahan'],
            'gaji_pokok' => $gaji_pokok,
            'alamat' => $data['alamat'],
            'photo' => $this->uploadImage('pegawai'),
        );

        if (isset($data['pegawai_id']) && !empty($data['pegawai_id'])) {
            $this->db->where('id', $data['pegawai_id']);
            $this->db->update('pegawai', $insert_data);
        } else {
            $insert_data['pegawai_id'] = substr(app_generate_hash(), 3, 7);
            $this->db->insert('pegawai', $insert_data);
        }
    }

    public function getPegawai($id = '')
    {
        $this->db->select('pegawai.*,pegawai_lokasi.nama as nama_lokasi,pegawai_jabatan.nama as nama_jabatan,pegawai_shift.nama as shift');
        $this->db->from('pegawai');
        $this->db->join('pegawai_lokasi', 'pegawai_lokasi.id = pegawai.lokasi_id', 'left');
        $this->db->join('pegawai_jabatan', 'pegawai_jabatan.id = pegawai.jabatan_id', 'left');
        $this->db->join('pegawai_shift', 'pegawai_shift.id = pegawai.shift_id', 'left');
        $this->db->where('pegawai.id', $id);

        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            show_404();
        }
        return $query->row_array();
    }

    public function kasbon_list($pegawai = '',$bulan = '')
    {
        $this->db->select('pegawai_kasbon.*,staff.nama as nama_staff,pegawai.nama as nama_pegawai');
        $this->db->from('pegawai_kasbon');
        $this->db->join('staff', 'staff.id = pegawai_kasbon.staff_id', 'left');
        $this->db->join('pegawai', 'pegawai.id = pegawai_kasbon.pegawai_id', 'left');

        if (!empty($pegawai)) {
            $this->db->where('pegawai_kasbon.pegawai_id', $pegawai);
        }
        if (!empty($bulan)) {
            $this->db->where('pegawai_kasbon.bulan', $bulan);
        }

        $this->db->order_by('pegawai_kasbon.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function save_kasbon($data)
    {
        $bulan = date("m", strtotime($data['month_year']));
        $tahun = date("Y", strtotime($data['month_year']));
        $tanggal = date('Y-m-d');
        $nominal = preg_replace('/[^0-9]/', '', $data['nominal']);
        $staff_id = get_loggedin_user_id();
        // if (isset($data['id']) && !empty($data['id'])) {
        //     $insert_data = array(
        //         'pegawai_id' => $data['pegawai_id'],
        //         'nama' => $data['nama'],
        //         'nominal' => $data['nominal'],
        //         'keterangan' => $data['keterangan'],
        //         'staff_id' => $account_id,
        //     );

        //     if ($data['nominal'] > $data['old_nominal']) {
        //         $selisih = floatval($data['nominal'] - $data['old_nominal']);
        //         $this->update_saldo($selisih,false);
        //     }elseif($data['nominal'] < $data['old_nominal']) {
        //         $selisih = floatval($data['old_nominal'] - $data['nominal']);
        //         $this->update_saldo($selisih);
        //     }
        //     $this->db->where('id', $data['id']);
        //     $this->db->update('pengeluaran', $insert_data);

        //     $update_transaksi = array(
        //         'keterangan' => $data['nama'],
        //         'nominal' => $data['nominal'],
        //         'debit' => '0',
        //         'kredit' => $data['nominal'],
        //         'staff_id' => $staff_id,
        //     );
        //     $this->db->where('reff_no', $data['kode']);
        //     $this->db->update('pegawai_kasbon', $update_transaksi);
        // } 
        //     else 
        // {
            $kode = substr(app_generate_hash(), 3, 7);
            $insert_data = array(
                'kode' => $kode,
                'pegawai_id' => $data['pegawai_id'],
                'nominal' => $nominal,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'keterangan' => $data['keterangan'],
                'tanggal' => $tanggal,
                'staff_id' => $staff_id,
            );
            $this->db->insert('pegawai_kasbon', $insert_data);
            $nama_pegawai = $this->getNamaById($data['pegawai_id']);

            // Insert Pengeluaran
            $insert_pengeluaran = array(
                'kode' => $kode,
                'sumber_id' => 2,
                'nama' => 'Kasbon pegawai '.$nama_pegawai->nama,
                'nominal' => $nominal,
                'tanggal' => $tanggal,
                'staff_id' => $staff_id,
            );
            $this->db->insert('pengeluaran', $insert_pengeluaran);
            // Insert ke Pembukuan
            $insert_transaksi = array(
                'reff_no' => $kode,
                'keterangan' => 'Kasbon pegawai '.$nama_pegawai->nama,
                'type' => 'pengeluaran',
                'nominal' => $nominal,
                'debit' => '0',
                'kredit' => $nominal,
                'tanggal' => $tanggal,
                'staff_id' => $staff_id,
            );
            $this->db->insert('kas', $insert_transaksi);
            // update saldo rekening
            $this->update_saldo($nominal,false);
        // }
    }

    public function getNamaById($id) {
        $this->db->select('*');
        $this->db->from('pegawai');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return FALSE;
        }
    }
    public function getKasbon($id,$bulan,$tahun)
    {
        $this->db->select('IFNULL(SUM(nominal),0) as total_kasbon');
        $this->db->from('pegawai_kasbon');
        $this->db->where('pegawai_id', $id);
        $this->db->where('bulan', $bulan);
        $this->db->where('tahun', $tahun);
        return $this->db->get()->row_array();
    }
    public function update_saldo($nominal, $add = true)
    {
        if ($add == true) {
            $this->db->set('saldo', 'saldo +' . $nominal, false);
        } else {
            $this->db->set('saldo', 'saldo -' . $nominal, false);
        }
        $this->db->where('id', 1);
        $this->db->update('rekening');
    }
}