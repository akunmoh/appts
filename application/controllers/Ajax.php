<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ajax_model');
    }

    // --------------------------------------------------------------------
    // AJAX GUDANG
    // --------------------------------------------------------------------
    public function kategori_barang()
    {
        if (get_permission('kategori_barang', 'is_edit')) {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $query = $this->db->get('barang_kategori');
            $result = $query->row_array();
            echo json_encode($result);
        }
    }

    public function unit()
    {
        if (get_permission('barang_unit', 'is_edit')) {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $query = $this->db->get('barang_unit');
            $result = $query->row_array();
            echo json_encode($result);
        }
    }

    public function get_harga_barang()
    {
        $id = $this->input->post('id');
        $price = $this->db->select('ifnull(harga,0) as harga_barang')->where('id', $id)->get('barang')->row_array();
        echo $price['harga_barang'];
    }

    public function get_barang_by_kategori()
    {
        $kategori_id = $this->input->post('kategori_id');
        $selected_id = (isset($_POST['barang_id']) ? $_POST['barang_id'] : 0);
        $baranglist = $this->ajax_model->get_list('barang', array('kategori_id' => $kategori_id), false, 'id,nama,kode');
        $html = "<option value=''>Pilih</option>";
        foreach ($baranglist as $barang) {
            $selected = (($barang['id'] == $selected_id) ? 'selected' : '');
            $html .= "<option value='" . $barang['id'] . "' " . $selected . ">" . $barang['nama'] . " (" . $barang['kode'] . ")</option>";
        }
        echo $html;
    }

    // --------------------------------------------------------------------

}
