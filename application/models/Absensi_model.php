<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // public function absensi_listx($jabatan_id = '', $tanggal = '')
    // {
    //     $sql = "SELECT pegawai.id, pegawai.nama as nama_pegawai, pegawai.pegawai_id as idpegawai, pegawai_absensi.id as absensi_id, pegawai_absensi.tanggal, IFNULL(pegawai_absensi.status, 0) as status_absen, pegawai_absensi.status, pegawai_absensi.keterangan FROM pegawai LEFT JOIN pegawai_absensi ON pegawai_absensi.pegawai_id = pegawai.id and pegawai_absensi.tanggal =" . $this->db->escape($tanggal) . " LEFT JOIN pegawai_jabatan ON pegawai_jabatan.id = pegawai.jabatan_id WHERE pegawai_jabatan.id = " . $this->db->escape($jabatan_id) . " ORDER BY pegawai.id ASC";
    //     return $this->db->query($sql)->result_array();
    // }

    public function absensi_list($jabatan_id = '', $tanggal)
    {
        $this->db->select('pegawai.id, pegawai.nama as nama_pegawai, pegawai.pegawai_id as idpegawai, pegawai_absensi.id as absensi_id, pegawai_absensi.tanggal, IFNULL(pegawai_absensi.status, 0) as status_absen, pegawai_absensi.status, pegawai_absensi.keterangan,IFNULL(pegawai_jabatan.nama, "N/A") as nama_jabatan');
        $this->db->from('pegawai');
        $this->db->join('pegawai_jabatan', 'pegawai_jabatan.id = pegawai.jabatan_id', 'left');
        $this->db->join('pegawai_absensi', 'pegawai_absensi.pegawai_id = pegawai.id and pegawai_absensi.tanggal ='.$this->db->escape($tanggal), 'left');
        
        if (!empty($jabatan_id)) {
            $this->db->where('pegawai_jabatan.id', $jabatan_id);
        }
        return $this->db->get()->result_array();
    }

    public function laporan_absensi($jabatan = '')
    {
        $this->db->select('pegawai.*,IFNULL(pegawai_jabatan.nama, "N/A") as nama_jabatan');
        $this->db->from('pegawai');
        $this->db->join('pegawai_jabatan', 'pegawai_jabatan.id = pegawai.jabatan_id', 'left');
        if (!empty($jabatan)) {
            $this->db->where('pegawai_jabatan.id', $jabatan);
        }
        $this->db->order_by('pegawai.id', 'ASC');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function absen_by_date($pegawai_id = '', $tanggal = '')
    {
        $this->db->select('pegawai_absensi.*');
        $this->db->from('pegawai_absensi');
        $this->db->where('pegawai_id', $pegawai_id);
        $this->db->where('tanggal', $tanggal);
        $result = $this->db->get()->row_array();
        return $result;
    }
}
