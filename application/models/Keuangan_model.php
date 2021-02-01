<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function getPengeluaranList()
    {
        $this->db->select('*');
        $this->db->where_not_in('id', array(1,2));
        $r = $this->db->get('pengeluaran_sumber')->result_array();
        return $r;  
    }

    public function pemasukkan_list($sumber = '',$tanggal = '')
    {
        $this->db->select('pemasukkan.*,staff.nama as nama_staff,pemasukkan_sumber.nama as nama_sumber');
        $this->db->from('pemasukkan');
        $this->db->join('staff', 'staff.id = pemasukkan.staff_id', 'left');
        $this->db->join('pemasukkan_sumber', 'pemasukkan_sumber.id = pemasukkan.sumber_id', 'left');

        if (!empty($sumber)) {
            $this->db->where('pemasukkan.sumber_id', $sumber);
        }
        if (!empty($tanggal)) {
            $this->db->where('pemasukkan.tanggal', $tanggal);
        }

        $this->db->order_by('pemasukkan.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function pengeluaran_list($sumber = '',$tanggal = '')
    {
        $this->db->select('pengeluaran.*,staff.nama as nama_staff,pengeluaran_sumber.nama as nama_sumber');
        $this->db->from('pengeluaran');
        $this->db->join('staff', 'staff.id = pengeluaran.staff_id', 'left');
        $this->db->join('pengeluaran_sumber', 'pengeluaran_sumber.id = pengeluaran.sumber_id', 'left');

        if (!empty($sumber)) {
            $this->db->where('pengeluaran.sumber_id', $sumber);
        }
        if (!empty($tanggal)) {
            $this->db->where('pengeluaran.tanggal', $tanggal);
        }

        $this->db->order_by('pengeluaran.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function save_pemasukkan($data)
    {
        $nominal = preg_replace('/[^0-9]/', '', $data['nominal']);
        $account_id = get_loggedin_user_id();
        if (isset($data['id']) && !empty($data['id'])) {
            $insert_data = array(
                'sumber_id' => $data['sumber_id'],
                'nama' => $data['nama'],
                'nominal' => $data['nominal'],
                'keterangan' => $data['keterangan'],
                'staff_id' => $account_id,
            );
            if ($data['nominal'] > $data['old_nominal']) {
                $selisih = floatval($data['nominal'] - $data['old_nominal']);
                $this->update_saldo($selisih);
            }elseif($data['nominal'] < $data['old_nominal']) {
                $selisih = floatval($data['old_nominal'] - $data['nominal']);
                $this->update_saldo($selisih,false);
            }
            $this->db->where('id', $data['id']);
            $this->db->update('pemasukkan', $insert_data);

            $update_transaksi = array(
                'keterangan' => $data['nama'],
                'nominal' => $data['nominal'],
                'debit' => $data['nominal'],
                'kredit' => '0',
                'staff_id' => get_loggedin_user_id(),
            );
            $this->db->where('reff_no', $data['kode']);
            $this->db->update('kas', $update_transaksi);
        } 
            else 
        {
            $kode = substr(app_generate_hash(), 3, 7);
            $insert_data = array(
                'kode' => $kode,
                'sumber_id' => $data['sumber_id'],
                'nama' => $data['nama'],
                'nominal' => $nominal,
                'tanggal' => $data['tanggal'],
                'keterangan' => $data['keterangan'],
                'staff_id' => $account_id,
            );
            $this->db->insert('pemasukkan', $insert_data);
            // Insert ke Pembukuan
            $insert_transaksi = array(
                'reff_no' => $kode,
                'keterangan' => $data['nama'],
                'type' => 'pemasukkan',
                'nominal' => $nominal,
                'debit' => $nominal,
                'kredit' => '0',
                'tanggal' => $data['tanggal'],
                'staff_id' => get_loggedin_user_id(),
            );
            $this->db->insert('kas', $insert_transaksi);
            // update saldo rekening
            $this->update_saldo($nominal);
        }
    }

    public function save_pengeluaran($data)
    {
        $nominal = preg_replace('/[^0-9]/', '', $data['nominal']);
        $account_id = get_loggedin_user_id();
        if (isset($data['id']) && !empty($data['id'])) {
            $insert_data = array(
                'sumber_id' => $data['sumber_id'],
                'nama' => $data['nama'],
                'nominal' => $data['nominal'],
                'keterangan' => $data['keterangan'],
                'staff_id' => $account_id,
            );

            if ($data['nominal'] > $data['old_nominal']) {
                $selisih = floatval($data['nominal'] - $data['old_nominal']);
                $this->update_saldo($selisih,false);
            }elseif($data['nominal'] < $data['old_nominal']) {
                $selisih = floatval($data['old_nominal'] - $data['nominal']);
                $this->update_saldo($selisih);
            }
            $this->db->where('id', $data['id']);
            $this->db->update('pengeluaran', $insert_data);

            $update_transaksi = array(
                'keterangan' => $data['nama'],
                'nominal' => $data['nominal'],
                'debit' => '0',
                'kredit' => $data['nominal'],
                'staff_id' => get_loggedin_user_id(),
            );
            $this->db->where('reff_no', $data['kode']);
            $this->db->update('kas', $update_transaksi);
        } 
            else 
        {
            $kode = substr(app_generate_hash(), 3, 7);
            $insert_data = array(
                'kode' => $kode,
                'sumber_id' => $data['sumber_id'],
                'nama' => $data['nama'],
                'nominal' => $nominal,
                'tanggal' => $data['tanggal'],
                'keterangan' => $data['keterangan'],
                'staff_id' => $account_id,
            );
            $this->db->insert('pengeluaran', $insert_data);
            // Insert ke Pembukuan
            $insert_transaksi = array(
                'reff_no' => $kode,
                'keterangan' => $data['nama'],
                'type' => 'pengeluaran',
                'nominal' => $nominal,
                'debit' => '0',
                'kredit' => $nominal,
                'tanggal' => $data['tanggal'],
                'staff_id' => get_loggedin_user_id(),
            );
            $this->db->insert('kas', $insert_transaksi);
            // update saldo rekening
            $this->update_saldo($nominal,false);
        }
    }

    public function get_saldo_awal($tanggal='')
	{
		$this->db->select('kas.*,staff.nama as staff');
		$this->db->from('kas');
		$this->db->join('staff', 'staff.id = kas.staff_id', 'left');
		$this->db->where('kas.tanggal <', $tanggal);
		$this->db->order_by('kas.id', 'ASC');
		return $this->db->get()->result_array();
    }

    public function get_laporan_kas($start='', $end='')
	{
		$this->db->select('kas.*,staff.nama as staff');
		$this->db->from('kas');
		$this->db->join('staff', 'staff.id = kas.staff_id', 'left');
		$this->db->where('kas.tanggal >=', $start);
		$this->db->where('kas.tanggal <=', $end);
		$this->db->order_by('kas.id', 'ASC');
		return $this->db->get()->result_array();
    }
    
    public function update_saldo($nominal, $add = true)
    {
        if ($add == true) {
            $this->db->set('saldo', 'saldo +' . $nominal, false);
        } else {
            $this->db->set('saldo', 'saldo -' . $nominal, false);
        }
        $this->db->where('id', '1');
        $this->db->update('rekening');
    }

    public function hapus_kas($kode)
    {
        $this->db->where('reff_no', $kode);
        $this->db->delete('kas');
    }

    public function hapus_pengeluaran($kode)
    {
        $this->db->where('kode', $kode);
        $this->db->delete('pengeluaran');
    }
}