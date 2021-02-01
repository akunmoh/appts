<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Beranda_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_total_pegawai()
    {
        $this->db->select('id');
        return $this->db->get('pegawai')->num_rows();
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_saldo()
    {
        $this->db->select('IFNULL(SUM(saldo), 0) as total_saldo');
        $this->db->from('rekening');
        $this->db->where('id', 1);
        return $this->db->get()->row_array();
    }

    public function get_pendapatan_pengeluaran()
    {
        $this->db->select('IFNULL(SUM(debit),0) as total_pemasukkan, IFNULL(SUM(kredit),0) as total_pengeluaran');
        $this->db->from('kas');
        $this->db->where('tanggal', date('Y-m-d'));
        return $this->db->get()->row_array();
    }

    public function get_grafik_tahunan()
    {
        $year = date('Y');
        $debit = array();
        $kredit = array();
        for ($month = 1; $month <= 12; $month++) {
            $date = $year . '-' . $month . '-1';
            $month_start = date('Y-m-d', strtotime($date));
            $month_end = date("Y-m-t", strtotime($date));
            $query = 'SELECT IFNULL(SUM(debit),0) as debit, IFNULL(SUM(kredit),0) as kredit FROM kas where tanggal between ' . $this->db->escape($month_start) . ' AND ' . $this->db->escape($month_end);
            $query = $this->db->query($query);
            $result = $query->row_array();
            $debit[] = (float) $result['debit'];
            $kredit[] = (float) $result['kredit'];
        }
        return array('pemasukkan' => $debit, 'pengeluaran' => $kredit);
    }

    public function get_grafik_bulanan()
    {
        $tgl = array();
        $total_pemasukkan = array();
        $total_pengeluaran = array();
        $startdate = date('Y-m-01');
        $enddate = date('Y-m-t');
        $start = strtotime($startdate);
        $end = strtotime($enddate);
        while ($start <= $end) {
            $today = date('Y-m-d', $start);
            $query = 'SELECT IFNULL(SUM(debit),0) as net_pemasukkan,IFNULL(SUM(kredit),0) as net_pengeluaran FROM kas WHERE tanggal = ' . $this->db->escape($today);
            $query = $this->db->query($query);
            $result = $query->row_array();
            $tgl[] = date('d', $start);
            $total_pemasukkan[] = (float) $result['net_pemasukkan'];
            $total_pengeluaran[] = (float) $result['net_pengeluaran'];
            $start = strtotime('+1 day', $start);
        }
        return array('total_pemasukkan' => $total_pemasukkan, 'total_pengeluaran' => $total_pengeluaran, 'tgl' => $tgl);
    }

    // BAGIAN GUDANG
    public function get_total_barang()
    {
        $this->db->select('id');
        return $this->db->get('barang')->num_rows();
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_masuk()
    {
        $this->db->select('IFNULL(SUM(stock_qty),0) as stock_masuk');
        $this->db->from('barang_stock');
        $this->db->where('tanggal', date('Y-m-d'));
        return $this->db->get()->row_array();
    }
    public function get_keluar()
    {
        $this->db->select('IFNULL(SUM(total),0) as stock_keluar');
        $this->db->from('barang_keluar');
        $this->db->where('tanggal', date('Y-m-d'));
        return $this->db->get()->row_array();
    }
    public function get_stock()
    {
        $this->db->select('IFNULL(SUM(stock),0) as jumlah_stock');
        $this->db->from('barang');
        return $this->db->get()->row_array();
    }
    //Gudang Info Barang
    public function stocklimit()
    {
        $this->db->select('barang.*,barang_kategori.nama as nama_kategori,barang_unit.nama as nama_unit,(SELECT sum(jumlah) from barang_keluar_detail where barang.id=barang_keluar_detail.barang_id) as jml_keluar');
        $this->db->from('barang');
        $this->db->join('barang_kategori', 'barang_kategori.id = barang.kategori_id', 'left');
        $this->db->join('barang_unit', 'barang_unit.id = barang.unit_id', 'left');
        $this->db->join('barang_stock', 'barang_stock.barang_id = barang.id', 'left');
        $this->db->join('barang_keluar_detail', 'barang_keluar_detail.barang_id = barang.id', 'left');
        $this->db->group_by('barang_stock.barang_id','barang_keluar_detail.barang_id');
        $this->db->order_by('barang.id', 'ASC');
        return $this->db->get()->result_array();
    }
    public function masuklist()
    {
        $this->db->select('barang_stock.*,barang.nama as nama_barang,barang_kategori.nama as nama_kategori,staff.nama as nama_staff');
        $this->db->from('barang_stock');
        $this->db->join('staff', 'staff.id = barang_stock.dibuat_oleh', 'left');
        $this->db->join('barang', 'barang.id = barang_stock.barang_id', 'left');
        $this->db->join('barang_kategori', 'barang_kategori.id = barang.kategori_id', 'left');
        $this->db->limit(10);
        $this->db->order_by('barang_stock.id', 'desc');
        return $this->db->get()->result_array();
    }
    public function keluarlist()
    {
        $this->db->select('barang_keluar_detail.*,barang.nama as nama_barang,barang_kategori.nama as nama_kategori,staff.nama as nama_staff,pegawai_lokasi.nama as nama_lokasi,barang_keluar.tanggal as tanggal');
        $this->db->from('barang_keluar_detail');
        $this->db->join('barang', 'barang.id = barang_keluar_detail.barang_id', 'left');
        $this->db->join('barang_kategori', 'barang_kategori.id = barang.kategori_id', 'inner');
        $this->db->join('barang_keluar', 'barang_keluar.id = barang_keluar_detail.barangkeluar_id', 'left');
        $this->db->join('pegawai_lokasi', 'pegawai_lokasi.id = barang_keluar.lokasi_id', 'inner');
        $this->db->join('staff', 'staff.id = barang_keluar.dibuat_oleh', 'inner');
        $this->db->limit(10);
        $this->db->order_by('barang_keluar_detail.id', 'ASC');
        return $this->db->get()->result_array();
    }
}
