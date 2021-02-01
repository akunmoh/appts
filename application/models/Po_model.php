<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Po_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function data_list($po_id = '')
    {
        $this->db->select('po_bus.*,staff.nama as nama_staff');
        $this->db->from('po_bus');
        $this->db->join('staff', 'staff.id = po_bus.staff_id', 'left');
        $this->db->join('po_nama', 'po_nama.id = po_bus.po_id', 'left');
        $this->db->where('po_bus.po_id', $po_id);
        $this->db->order_by('po_bus.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_nonsj_list($po_id)
    {
        $this->db->select('po_bus.*,po_nama.nama as nama_po,staff.nama as nama_staff');
        $this->db->from('po_bus');
        $this->db->join('po_nama', 'po_nama.id = po_bus.po_id', 'left');
        $this->db->join('staff', 'staff.id = po_bus.staff_id', 'left');
        $this->db->where('po_bus.po_id', $po_id);
        $this->db->order_by('po_bus.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function save_data($data)
    {
        if(isset($data['layanan']) && !empty($data['layanan'])){
            $insert_data = array(
                'po_id' => $data['po_id'],
                'layanan' => $data['layanan'],
                'no_bodi' => $data['no_bodi'],
                'jml_pnp' => $data['jml_pnp'],
                'nama_sopir' => $data['nama_sopir'],
                'kedatangan' => $data['kedatangan'],
                'dari' => $data['dari'],
                'tujuan' => $data['tujuan'],
                'tanggal' => date('Y-m-d H:i:s'),
                'staff_id' => get_loggedin_user_id(),
            );
        }else{
            $insert_data = array(
                'po_id' => $data['po_id'],
                'no_bodi' => $data['no_bodi'],
                'no_polisi' => $data['no_polisi'],
                'jml_pnp' => $data['jml_pnp'],
                'nama_sopir' => $data['nama_sopir'],
                'kedatangan' => $data['kedatangan'],
                'dari' => $data['dari'],
                'tujuan' => $data['tujuan'],
                'tanggal' => date('Y-m-d H:i:s'),
                'staff_id' => get_loggedin_user_id(),
            );
        }

        if (isset($data['id']) && !empty($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('po_bus', $insert_data);
        } else {
            $this->db->insert('po_bus', $insert_data);
        }
    }

    public function save_po($data)
    {
        $insert_data = array(
            'nama' => $this->input->post('nama'),
        );

        if (isset($data['id']) && !empty($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('po_nama', $insert_data);
        } else {
            $this->db->insert('po_nama', $insert_data);
        }
    }

    public function laporan_list($tanggal = '',$po_id = '')
    {
        $this->db->select('po_bus.*,staff.nama as nama_staff');
        $this->db->from('po_bus');
        $this->db->join('staff', 'staff.id = po_bus.staff_id', 'left');
        $this->db->join('po_nama', 'po_nama.id = po_bus.po_id', 'left');

        if (!empty($po_id)) {
            $this->db->where('po_bus.po_id', $po_id);
        }else{
            $this->db->where('po_bus.po_id !=', 1);
        }
        if (!empty($tanggal)) {
            $this->db->where('po_bus.tanggal', $tanggal);
        }

        $this->db->order_by('po_bus.id', 'DESC');
        return $this->db->get()->result_array();
    }

    public function tot_penumpang($tanggal = '',$po_id = '')
    {
        $this->db->select('IFNULL(SUM(jml_pnp), 0) as total_pnp');
        $this->db->from('po_bus');
        if (!empty($po_id)) {
            $this->db->where('po_id', $po_id);
        }else{
            $this->db->where('po_id !=', 1);
        }
        if (!empty($tanggal)) {
            $this->db->where('tanggal', $tanggal);
        }
        return $this->db->get()->row_array();
    }

    public function total_bus($tanggal = '',$po_id = '')
    {
        $this->db->select('id');
        if (!empty($po_id)) {
            $this->db->where('po_id', $po_id);
        }else{
            $this->db->where('po_id !=', 1);
        }
        if (!empty($tanggal)) {
            $this->db->where('tanggal', $tanggal);
        }

        return $this->db->get('po_bus')->num_rows();

        $query = $this->db->get();
        return $query->row_array();
    }

    public function barat($tanggal = '',$po_id = '')
    {
        $this->db->select('id');
        if (!empty($po_id)) {
            $this->db->where('po_id', $po_id);
        }else{
            $this->db->where('po_id !=', 1);
        }
        if (!empty($tanggal)) {
            $this->db->where('tanggal', $tanggal);
        }
        $this->db->where('kedatangan', 'Barat');

        return $this->db->get('po_bus')->num_rows();
        $query = $this->db->get();
        return $query->row_array();
    }

    public function timur($tanggal = '',$po_id = '')
    {
        $this->db->select('id');
        if (!empty($po_id)) {
            $this->db->where('po_id', $po_id);
        }else{
            $this->db->where('po_id !=', 1);
        }
        if (!empty($tanggal)) {
            $this->db->where('tanggal', $tanggal);
        }
        $this->db->where('kedatangan', 'Timur');

        return $this->db->get('po_bus')->num_rows();
        $query = $this->db->get();
        return $query->row_array();
    }
}