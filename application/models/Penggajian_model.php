<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penggajian_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_summary($bulan = '', $tahun = '', $jabatan_id = '')
    {
        $this->db->select('pegawai.*,pegawai_gaji.status,IFNULL(pegawai_gaji.id,0) as penggajian_id,IFNULL(pegawai_jabatan.nama, "N/A") as nama_jabatan');
        $this->db->from('pegawai');
        $this->db->join('pegawai_jabatan', 'pegawai_jabatan.id = pegawai.jabatan_id', 'left');
        $this->db->join('pegawai_gaji', 'pegawai.id = pegawai_gaji.pegawai_id and bulan = '.$bulan.' and tahun = '.$tahun, 'left');
        if (!empty($jabatan_id)) {
            $this->db->where('pegawai.jabatan_id', $jabatan_id);
        }
        return $this->db->get()->result_array();
    }

    function simpanGaji($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('pegawai_gaji', $data);
        } else {
            $this->db->insert('pegawai_gaji', $data);
            return $this->db->insert_id();
        }
    }
    
    function checkGaji($bulan, $tahun, $pegawai_id) {
        $query = $this->db->where(array('bulan' => $bulan, 'tahun' => $tahun, 'pegawai_id' => $pegawai_id))->get("pegawai_gaji");
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    function add_tunjangan($data) 
    {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('gaji_tunjangan', $data);
        } else {
            $this->db->insert('gaji_tunjangan', $data);
            return $this->db->insert_id();
        }
    }

    public function hapusGaji($gaji_id)
    {
        $this->db->where("id", $gaji_id)->delete("pegawai_gaji");
        $this->db->where("gaji_id", $gaji_id)->delete("gaji_tunjangan");
    }

    public function getGaji($id,$bulan,$tahun)
    {
        $this->db->select('pegawai_gaji.*,pegawai.nama as nama_pegawai');
        $this->db->from('pegawai_gaji');
        $this->db->join('pegawai', 'pegawai.id = pegawai_gaji.pegawai_id', 'left');
        $this->db->where('pegawai_gaji.id', $id);
        $this->db->where('pegawai_gaji.bulan', $bulan);
        $this->db->where('pegawai_gaji.tahun', $tahun);

        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            show_404();
        }
        return $query->row_array();
    }

    public function slipGaji($id)
    {
        $this->db->select('pegawai_gaji.*,pegawai.nama as nama_pegawai,pegawai.notelp as no_telp,staff.nama as nama_staff,pegawai_jabatan.nama as nama_jabatan');
        $this->db->from('pegawai_gaji');
        $this->db->join('staff', 'staff.id = pegawai_gaji.staff_id', 'left');
        $this->db->join('pegawai', 'pegawai.id = pegawai_gaji.pegawai_id', 'left');
        $this->db->join('pegawai_jabatan', 'pegawai_jabatan.id = pegawai.jabatan_id', 'inner');
        $this->db->where('pegawai_gaji.id', $id);

        $query = $this->db->get();
        return $query->row_array();
    }


}