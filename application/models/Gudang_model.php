<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gudang_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function barang_list()
    {
        $this->db->select('barang.*,barang_kategori.nama as nama_kategori,barang_unit.nama as nama_unit');
        $this->db->from('barang');
        $this->db->join('barang_kategori', 'barang_kategori.id = barang.kategori_id', 'left');
        $this->db->join('barang_unit', 'barang_unit.id = barang.unit_id', 'left');
        $this->db->order_by('barang.id', 'ASC');
        return $this->db->get()->result_array();
    }

    public function save_barang($data)
    {
        $insert_data = array(
            'nama' => $data['nama'],
            'kode' => $data['kode'],
            'kategori_id' => $data['kategori'],
            'unit_id' => $data['unit'],
            'stock' => '0',
            'stock_min' => $data['stock_min'],
            'keterangan' => $data['keterangan']
        );
        if (isset($data['barang_id']) && !empty($data['barang_id'])) {
            $this->db->where('id', $data['barang_id']);
            $this->db->update('barang', $insert_data);
        } else {
            $this->db->insert('barang', $insert_data);
        }
    }

    public function stock_list($tanggal = '')
    {
        $this->db->select('barang_stock.*,barang.nama as nama_barang,barang_kategori.nama as nama_kategori,staff.nama as nama_staff');
        $this->db->from('barang_stock');
        $this->db->join('staff', 'staff.id = barang_stock.dibuat_oleh', 'left');
        $this->db->join('barang', 'barang.id = barang_stock.barang_id', 'left');
        $this->db->join('barang_kategori', 'barang_kategori.id = barang.kategori_id', 'left');
        if (!empty($tanggal)) {
            $this->db->where('barang_stock.tanggal', $tanggal);
        }
        $this->db->order_by('barang_stock.id', 'desc');
        return $this->db->get()->result_array();
    }

    public function save_stock($data)
    {
        $insert_data = array(
            'barang_id' => $data['barang_id'],
            'tanggal' => $data['tanggal'],
            'stock_qty' => $data['stock_qty'],
            'keterangan' => $data['keterangan'],
            'dibuat_oleh' => get_loggedin_user_id(),
        );
        if (isset($data['old_barang_id'])) {
            if ($data['old_barang_id'] == $data['barang_id']) {
                if (isset($data['old_stock_qty'])) {
                    if ($data['stock_qty'] >= $data['old_stock_qty']) {
                        $stock = floatval($data['stock_qty'] - $data['old_stock_qty']);
                        $this->stock_upgrade($stock, $data['barang_id']);
                    } else {
                        $stock = floatval($data['old_stock_qty'] - $data['stock_qty']);
                        $this->stock_upgrade($stock, $data['barang_id'], false);
                    }
                }
            } else {
                $this->stock_upgrade($data['old_stock_qty'], $data['old_barang_id'], false);
                $this->stock_upgrade($data['stock_qty'], $data['barang_id']);
            }
        }
        if (!isset($data['stock_id'])) {
            $this->stock_upgrade($data['stock_qty'], $data['barang_id']);
            $this->db->insert('barang_stock', $insert_data);
        } else {
            $this->db->where('id', $data['stock_id']);
            $this->db->update('barang_stock', $insert_data);
        }
    }

    public function stock_upgrade($stock, $barang_id, $add = true)
    {
        if ($add == true) {
            $this->db->set('stock', 'stock +' . $stock, false);
        } else {
            $this->db->set('stock', 'stock -' . $stock, false);
        }
        $this->db->where('id', $barang_id);
        $this->db->update('barang');
    }

    public function keluar_list($tanggal = '')
    {
        $this->db->select('barang_keluar.*,pegawai_lokasi.nama as nama_lokasi,staff.nama as nama_staff');
        $this->db->from('barang_keluar');
        $this->db->join('staff', 'staff.id = barang_keluar.dibuat_oleh', 'left');
        $this->db->join('pegawai_lokasi', 'pegawai_lokasi.id = barang_keluar.lokasi_id', 'left');
        if (!empty($tanggal)) {
            $this->db->where('barang_keluar.tanggal', $tanggal);
        }
        $this->db->order_by('barang_keluar.id', 'desc');
        return $this->db->get()->result_array();
    }


    public function barangkeluar_save($data)
    {
        $arrayInvoice = array(
            'lokasi_id' => $data['lokasi_id'],
            'no_nota' => $data['no_nota'],
            'keterangan' => $data['keterangan'],
            'total' => $data['qty_total'],
            'hash' => app_generate_hash(),
            'tanggal' => date('Y-m-d', strtotime($data['tanggal'])),
            'dibuat_oleh' => get_loggedin_user_id(),
            'diubah_oleh' => get_loggedin_user_id(),
        );

        $this->db->insert('barang_keluar', $arrayInvoice);
        $barangkeluar_id = $this->db->insert_id();

        $arrayData = array();
        $lokasi = $data['lokasi_id'];
        $barangkeluar = $data['barangkeluar'];
        foreach ($barangkeluar as $key => $value) {
            $arraybarang = array(
                'lokasi_id' => $lokasi,
                'barangkeluar_id' => $barangkeluar_id,
                'barang_id' => $value['barang'],
                'jumlah' => $value['jumlah'],
            );
            $arrayData[] = $arraybarang;

            //ubah stock
            $this->stock_upgrade($value['jumlah'], $value['barang'], false);
        }
        
        $this->db->insert_batch('barang_keluar_detail', $arrayData);
    }

    public function get_invoice($id)
    {
        $this->db->select('barang_keluar.*,pegawai_lokasi.nama as nama_lokasi,staff.nama as nama_staff');
        $this->db->from('barang_keluar');
        $this->db->join('pegawai_lokasi', 'pegawai_lokasi.id = barang_keluar.lokasi_id', 'left');
        $this->db->join('staff', 'staff.id = barang_keluar.dibuat_oleh', 'left');
        $this->db->where('barang_keluar.id', $id);
        return $this->db->get()->row_array();
    }

    public function laporan_stock()
    {
        $this->db->select('barang.*,barang_kategori.nama as nama_kategori,barang_unit.nama as nama_unit,(SELECT sum(stock_qty) from barang_stock where barang.id=barang_stock.barang_id) as jml_masuk,(SELECT sum(jumlah) from barang_keluar_detail where barang.id=barang_keluar_detail.barang_id) as jml_keluar');
        $this->db->from('barang');
        $this->db->join('barang_kategori', 'barang_kategori.id = barang.kategori_id', 'left');
        $this->db->join('barang_unit', 'barang_unit.id = barang.unit_id', 'left');
        $this->db->join('barang_stock', 'barang_stock.barang_id = barang.id', 'left');
        $this->db->join('barang_keluar_detail', 'barang_keluar_detail.barang_id = barang.id', 'left');
        $this->db->group_by('barang_stock.barang_id','barang_keluar_detail.barang_id');
        $this->db->order_by('barang.id', 'ASC');
        return $this->db->get()->result_array();
    }

    public function laporan_masuk($start='', $end='')
    {
        $this->db->select('barang_stock.*,barang.nama as nama_barang,barang_kategori.nama as nama_kategori,staff.nama as nama_staff');
        $this->db->from('barang_stock');
        $this->db->join('staff', 'staff.id = barang_stock.dibuat_oleh', 'left');
        $this->db->join('barang', 'barang.id = barang_stock.barang_id', 'left');
        $this->db->join('barang_kategori', 'barang_kategori.id = barang.kategori_id', 'left');
        $this->db->where('barang_stock.tanggal >=', $start);
		$this->db->where('barang_stock.tanggal <=', $end);
        $this->db->order_by('barang_stock.id', 'ASC');
        return $this->db->get()->result_array();
    }

    public function laporan_keluar($start='', $end='', $lokasi_id = '')
    {
        $this->db->select('barang_keluar_detail.*,barang.nama as nama_barang,barang_kategori.nama as nama_kategori,staff.nama as nama_staff,pegawai_lokasi.nama as nama_lokasi,barang_keluar.tanggal as tanggal');
        $this->db->from('barang_keluar_detail');
        $this->db->join('barang', 'barang.id = barang_keluar_detail.barang_id', 'left');
        $this->db->join('barang_kategori', 'barang_kategori.id = barang.kategori_id', 'inner');
        $this->db->join('barang_keluar', 'barang_keluar.id = barang_keluar_detail.barangkeluar_id', 'left');
        $this->db->join('pegawai_lokasi', 'pegawai_lokasi.id = barang_keluar.lokasi_id', 'inner');
        $this->db->join('staff', 'staff.id = barang_keluar.dibuat_oleh', 'inner');
        $this->db->where('barang_keluar.tanggal >=', $start);
        $this->db->where('barang_keluar.tanggal <=', $end);
        if (!empty($lokasi_id)) {
            $this->db->where('barang_keluar.lokasi_id', $lokasi_id);
        }
        $this->db->order_by('barang_keluar_detail.id', 'ASC');
        return $this->db->get()->result_array();
    }
}
