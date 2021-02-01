<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gudang extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('gudang_model');
    }

    public function index()
    {
        $this->barang();
    }

    // --------------------------------------------------------------------
    // BAGIAN DATA BARANG
    // --------------------------------------------------------------------
    public function barang()
    {
        if (!get_permission('data_barang', 'is_view')) {
            access_denied();
        }

        $this->data['baranglist'] = $this->gudang_model->barang_list();
        $this->data['kategorilist'] = $this->app_lib->getSelectList('barang_kategori');
        $this->data['unitlist'] = $this->app_lib->getSelectList('barang_unit');
        $this->data['title'] = 'Data Barang';
        $this->data['sub_page'] = 'gudang/barang';
        $this->data['main_menu'] = 'gudang';
        $this->load->view('layout/index', $this->data);
    }

    public function get_barang()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $query = $this->db->get('barang');
        $result = $query->row_array();
        echo json_encode($result);
    }

    public function submit_barang($action = '', $id = '')
    {
        if ($action == 'save') {
            if (!get_permission('data_barang', 'is_add')) {
                access_denied();
            }

            $this->form_validation->set_rules('nama', 'Nama barang', 'trim|required');
            $this->form_validation->set_rules('kode', 'Kode barang', 'trim|required');
            $this->form_validation->set_rules('kategori', 'Kategori', 'trim|required');
            $this->form_validation->set_rules('unit', 'Unit', 'trim|required');
            $this->form_validation->set_rules('stock_min', 'Min stock', 'trim|required');
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $this->gudang_model->save_barang($post);
                set_alert('success', 'Berhasil menambahkan data');
                redirect(base_url('gudang/barang'));
            }
        }
        if ($action == 'delete') {
            if (!get_permission('data_barang', 'is_delete')) {
                access_denied();
            }
            $this->db->where('id', $id);
            $this->db->delete('barang');
        }
    }

    // --------------------------------------------------------------------
    // BAGIAN BARANG MASUK
    // --------------------------------------------------------------------
    public function barangmasuk()
    {
        if (!get_permission('barang_masuk', 'is_view')) {
            access_denied();
        }
        if (isset($_POST['search'])) {
            $tanggal = $this->input->post('tanggal');
            $this->data['stocklist'] = $this->gudang_model->stock_list($tanggal);
        } else {
            $tanggal = date('Y-m-d');
            $this->data['stocklist'] = $this->gudang_model->stock_list($tanggal);
        }
        
        $this->data['kategorilist'] = $this->app_lib->getSelectList('barang_kategori');
        $this->data['title'] = 'Barang Masuk';
        $this->data['sub_page'] = 'gudang/barangmasuk';
        $this->data['main_menu'] = 'gudang';
        $this->load->view('layout/index', $this->data);
    }

    public function get_barangmasuk()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $query = $this->db->get('barang_stock');
        $result = $query->row_array();
        echo json_encode($result);
    }

    public function submit_barangmasuk($action = '', $id = '')
    {
        if ($action == 'save') {
            if (!get_permission('barang_masuk', 'is_add')) {
                access_denied();
            }

            $this->form_validation->set_rules('kategori_id', 'Kategori barang', 'trim|required');
            $this->form_validation->set_rules('barang_id', 'Barang', 'trim|required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
            $this->form_validation->set_rules('stock_qty', 'Stock Qty', 'trim|required');
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $this->gudang_model->save_stock($post);
                set_alert('success', 'Berhasil menambahkan data');
                redirect(base_url('gudang/barangmasuk'));
            }
        }
        if ($action == 'delete') {
            if (!get_permission('barang_masuk', 'is_delete')) {
                access_denied();
            }
            $getStock = $this->db->get_where('barang_stock', array('id' => $id))->row_array();
            $this->gudang_model->stock_upgrade($getStock['stock_qty'], $getStock['barang_id'], false);
            $this->db->where('id', $id);
            $this->db->delete('barang_stock');
        }
    }

    public function barangmasuk_edit()
    {
        $id = $this->input->post('barang_id');
        $this->data['stock'] = $this->gudang_model->get_list('barang_stock', array('id' => $id), true);
        $this->data['kategorilist'] = $this->app_lib->getSelectList('barang_kategori');
        $this->load->view('gudang/barangmasuk_edit', $this->data);
    }

    // --------------------------------------------------------------------
    // BAGIAN BARANG KELUAR 
    // --------------------------------------------------------------------
    public function keluar()
    {
        if (!get_permission('barang_keluar', 'is_view')) {
            access_denied();
        }
        if (isset($_POST['search'])) {
            $tanggal = $this->input->post('tanggal');
            $this->data['keluarlist'] = $this->gudang_model->keluar_list($tanggal);
        } else {
            $tanggal = date('Y-m-d');
            $this->data['keluarlist'] = $this->gudang_model->keluar_list($tanggal);
        }
        
        $this->data['baranglist'] = $this->gudang_model->get_list('barang', '', false, 'id,stock,nama');
        $this->data['lokasilist'] = $this->app_lib->getSelectList('pegawai_lokasi');
        $this->data['title'] = 'Barang Keluar';
        $this->data['sub_page'] = 'gudang/keluar';
        $this->data['main_menu'] = 'gudang';
        $this->load->view('layout/index', $this->data);
    }

    public function barangkeluar_edit()
    {
        $id = $this->input->post('id');
        $this->data['barangkeluarlist'] = $this->gudang_model->get_list('barang_keluar', array('id' => $id), true);
        $this->data['baranglist'] = $this->gudang_model->get_list('barang', "", false, 'id,stock,nama');
        $this->data['lokasilist'] = $this->app_lib->getSelectList('pegawai_lokasi');
        $this->load->view('gudang/keluar_edit', $this->data);
    }

    public function barangkeluar_save() {
        if (!get_permission('barang_keluar', 'is_add')) {
            access_denied();
        }
        if ($_POST) {
            $this->form_validation->set_rules('lokasi_id', 'Lokasi Tujuan', 'trim|required');
            $this->form_validation->set_rules('no_nota', 'No. Nota', 'trim|required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');

            $items = $this->input->post('barangkeluar');
            foreach ($items as $key => $value) {
                $this->form_validation->set_rules('barangkeluar[' . $key . '][barang]', 'Barang', 'trim|required');
                $this->form_validation->set_rules('barangkeluar[' . $key . '][jumlah]', 'Jumlah', 'trim|required');
            }
            if ($this->form_validation->run() == false) {
                $msg = array(
                    'lokasi_id' => form_error('lokasi_id'),
                    'no_nota' => form_error('no_nota'),
                    'tanggal' => form_error('tanggal'),
                );
                foreach ($items as $key => $value) {
                    $msg['barang' . $key] = form_error('barangkeluar[' . $key . '][barang]');
                    $msg['jumlah' . $key] = form_error('barangkeluar[' . $key . '][jumlah]');
                }
                $array = array('status' => 'fail', 'url' => '', 'error' => $msg);
            } else {
                $data = $this->input->post();
                $this->gudang_model->barangkeluar_save($data);
                $url = base_url('gudang/keluar');
                set_alert('success', 'Berhasil menambahkan data');
                $array = array('status' => 'success', 'url' => $url, 'error' => '');
            }
            echo json_encode($array);
        }
    }
    
    public function keluar_edit_save() {
        if (!get_permission('barang_keluar', 'is_edit')) {
            access_denied();
        }
        if ($_POST) {
            $this->form_validation->set_rules('lokasi_id', 'Lokasi Tujuan', 'trim|required');
            $this->form_validation->set_rules('no_nota', 'No Nota', 'trim|required');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
            $items = $this->input->post('barangkeluar');
            foreach ($items as $key => $value) {
                $this->form_validation->set_rules('barangkeluar[' . $key . '][barang]', 'Barang', 'trim|required');
                $this->form_validation->set_rules('barangkeluar[' . $key . '][jumlah]', 'Jumlah', 'trim|required');
            }
            if ($this->form_validation->run() == false) {
                $msg = array(
                    'lokasi_id' => form_error('lokasi_id'),
                    'no_nota' => form_error('no_nota'),
                    'tanggal' => form_error('tanggal'),
                );
                foreach ($items as $key => $value) {
                    $msg['barang' . $key] = form_error('barangkeluar[' . $key . '][barang]');
                    $msg['jumlah' . $key] = form_error('barangkeluar[' . $key . '][jumlah]');
                }
                $array = array('status' => 'fail', 'url' => '', 'error' => $msg);
            } else {
                $barangkeluar_id = $this->input->post('barangkeluar_id');
                $lokasi_id = $this->input->post('lokasi_id');
                $no_nota = $this->input->post('no_nota');
                $total = $this->input->post('qty_total');
                $tanggal = $this->input->post('tanggal');
                $keterangan = $this->input->post('keterangan');
                $array_invoice = array(
                    'lokasi_id' => $lokasi_id,
                    'no_nota' => $no_nota,
                    'keterangan' => $keterangan,
                    'total' => $total,
                    'hash' => app_generate_hash(),
                    'tanggal' => date('Y-m-d', strtotime($tanggal)),
                    'diubah_oleh' => get_loggedin_user_id(),
                );
                $this->db->where('id', $barangkeluar_id);
                $this->db->update('barang_keluar', $array_invoice);

                $barangkeluar = $this->input->post('barangkeluar');
                foreach ($barangkeluar as $key => $value) {
                    $array_barang = array(
                        'barangkeluar_id' => $barangkeluar_id,
                        'barang_id' => $value['barang'],
                        'jumlah' => $value['jumlah'],
                    );

                    if(isset($value['old_keluar_details_id'])){
                        if($value['old_barang_id'] == $value['barang']){
                            if($value['jumlah'] > $value['old_jumlah']){ //jika barang di tambahkan dari sebelumnya
                                $stock = floatval($value['jumlah'] - $value['old_jumlah']); //cari selisih
                                $this->gudang_model->stock_upgrade($stock, $value['barang'], false); //kurangkan stock
                            }elseif($value['jumlah'] < $value['old_jumlah']){ //jika barang di kurangkan dari sebelumnya
                                $stock = floatval($value['old_jumlah'] - $value['jumlah']); // cari selisih
                                $this->gudang_model->stock_upgrade($stock, $value['barang']); //tambahkan stok
                            }
                        } elseif($value['old_barang_id'] != $value['barang']){ //jika ada perubahan barang (ganti barang)
                            $stock = floatval($value['old_jumlah']);
                            $this->gudang_model->stock_upgrade($stock, $value['old_barang_id']); //balikin stok salah produk
                            $this->gudang_model->stock_upgrade($value['jumlah'], $value['barang'], false); //tambah perubahan produk
                        }
                    }

                    if (isset($value['old_keluar_details_id'])) {
                        $this->db->where('id', $value['old_keluar_details_id']);
                        $this->db->update('barang_keluar_detail', $array_barang);
                    } else {
                        $this->gudang_model->stock_upgrade($value['jumlah'], $value['barang'], false);
                        $this->db->insert('barang_keluar_detail', $array_barang);
                    }
                }
                $url = base_url('gudang/keluar');
                set_alert('success', 'Data telah berhasil diperbarui');
                $array = array('status' => 'success', 'url' => $url, 'error' => '');
            }
            // echo json_encode($array);
            redirect(base_url('gudang/keluar'));
        }
    }

    public function keluar_delete($id)
    {
        if (!get_permission('barang_keluar', 'is_delete')) {
            access_denied();
        }
        // Balikin dulu stock ke barang
        $barang = $this->gudang_model->get_list('barang_keluar_detail', array('barangkeluar_id' => $id), false);
        foreach ($barang as $item):
            $this->gudang_model->stock_upgrade($item['jumlah'], $item['barang_id']);
        endforeach;
        //Proses hapus
        $this->db->where('id', $id);
        $this->db->delete('barang_keluar');
        $this->db->where('barangkeluar_id', $id);
        $this->db->delete('barang_keluar_detail');
    }

    public function keluar_detail($id = '', $hash = '')
    {
        if (!get_permission('barang_keluar', 'is_view')) {
            access_denied();
        }
        check_hash_restrictions('barang_keluar', $id, $hash);
        $this->data['datakeluar'] = $this->gudang_model->get_invoice($id);
        $this->data['title'] = 'Detail Barang Keluar';
        $this->data['sub_page'] = 'gudang/keluar_detail';
        $this->data['main_menu'] = 'gudang';
        $this->load->view('layout/index', $this->data);
    }

    // --------------------------------------------------------------------
    // BAGIAN PENGATURAN GUDANG
    // --------------------------------------------------------------------
    public function pengaturan($action = 'kategori')
    {
        if (!get_permission('pengaturan_gudang', 'is_view')) {
            access_denied();
        }

        if ($_POST) {
            if (!get_permission('pengaturan_gudang', 'is_edit')) {
                access_denied();
            }
        }

        if ($this->input->post('submit') == 'kategori') {
            $this->form_validation->set_rules('nama', 'Nama Kategori', 'trim|required|callback_unique_kategori');
            if ($this->form_validation->run() !== false) {
                $this->db->insert('barang_kategori', array('nama' => $this->input->post('nama')));
                set_alert('success', 'Berhasil menambahkan data');
                redirect(base_url('gudang/pengaturan/kategori'));
            } else {
                $this->data['validation_error'] = true;
                $this->session->set_flashdata('form_modal', 1);
            }
        }

        if ($this->input->post('submit') == 'unit') {
            $this->form_validation->set_rules('nama', 'Nama Unit', 'trim|required|callback_unique_unit');
            if ($this->form_validation->run() !== false) {
                $this->db->insert('barang_unit', array('nama' => $this->input->post('nama')));
                set_alert('success', 'Berhasil menambahkan data');
                redirect(base_url('gudang/pengaturan/unit'));
            } else {
                $this->data['validation_error'] = true;
                $this->session->set_flashdata('form_modal', 1);
            }
        }

        if ($action == 'kategori') {
            $this->data['inside_subview'] = 'kategori';
        } elseif ($action == 'unit') {
            $this->data['inside_subview'] = 'unit';
        }

        $this->data['kategorilist'] = $this->gudang_model->get_list('barang_kategori');
        $this->data['unitlist'] = $this->gudang_model->get_list('barang_unit');

        $this->data['title'] = 'Pengaturan Gudang';
        $this->data['sub_page'] = 'gudang/pengaturan';
        $this->data['main_menu'] = 'pengaturan';
        $this->load->view('layout/index', $this->data);
    }

    // --------------------------------------------------------------------
    // BAGIAN KATEGORI BARANG
    // --------------------------------------------------------------------
    public function kategori_edit()
    {
        $id = $this->input->post('kategori_id');
        $this->data['kategori'] = $this->gudang_model->get_list('barang_kategori', array('id' => $id), true);
        $this->load->view('gudang/kategori_edit', $this->data);
    }

    public function kategori_edit_post()
    {
        if (!get_permission('kategori_barang', 'is_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('nama', 'Nama Kategori', 'trim|required|callback_unique_kategori');
        if ($this->form_validation->run() !== false) {
            $kategori_id = $this->input->post('kategori_id');
            $this->db->where('id', $kategori_id);
            $this->db->update('barang_kategori', array('nama' => $this->input->post('nama')));
            set_alert('success', 'Data telah berhasil diperbarui');
        }
        redirect(base_url('gudang/pengaturan/kategori'));
    }

    public function kategori_delete($id)
    {
        if (!get_permission('kategori_barang', 'is_delete')) {
            access_denied();
        }
        $this->db->where('id', $id);
        $this->db->delete('barang_kategori');
    }

    public function unique_kategori($nama)
    {
        $kategori_id = $this->input->post('kategori_id');
        if (!empty($kategori_id)) {
            $this->db->where_not_in('id', $kategori_id);
        }
        $this->db->where('nama', $nama);
        $query = $this->db->get('barang_kategori');
        if ($query->num_rows() > 0) {
            if (!empty($kategori_id)) {
                set_alert('error', "Nama kategori sudah ada, silahkan gunakan nama lain.");
            } else {
                $this->form_validation->set_message("unique_kategori", "Nama kategori sudah ada, silahkan gunakan nama lain.");
            }
            return false;
        } else {
            return true;
        }
    }

    // --------------------------------------------------------------------
    // BAGIAN UNIT BARANG
    // --------------------------------------------------------------------
    public function unit_edit()
    {
        $id = $this->input->post('unit_id');
        $this->data['unit'] = $this->gudang_model->get_list('barang_unit', array('id' => $id), true);
        $this->load->view('gudang/unit_edit', $this->data);
    }

    public function unit_edit_post()
    {
        if (!get_permission('barang_unit', 'is_edit')) {
            access_denied();
        }
        $this->form_validation->set_rules('nama', 'Nama Unit', 'trim|required|callback_unique_unit');
        if ($this->form_validation->run() !== false) {
            $unit_id = $this->input->post('unit_id');
            $this->db->where('id', $unit_id);
            $this->db->update('barang_unit', array('nama' => $this->input->post('nama')));
            set_alert('success', 'Data telah berhasil diperbarui');
        }
        redirect(base_url('gudang/pengaturan/unit'));
    }

    public function unit_delete($id)
    {
        if (!get_permission('barang_unit', 'is_delete')) {
            access_denied();
        }
        $this->db->where('id', $id);
        $this->db->delete('barang_unit');
    }

    public function unique_unit($nama)
    {
        $unit_id = $this->input->post('unit_id');
        if (!empty($unit_id)) {
            $this->db->where_not_in('id', $unit_id);
        }
        $this->db->where('nama', $nama);
        $query = $this->db->get('barang_unit');
        if ($query->num_rows() > 0) {
            if (!empty($unit_id)) {
                set_alert('error', "Nama unit sudah ada, silahkan gunakan nama lain.");
            } else {
                $this->form_validation->set_message("unique_unit", "Nama unit sudah ada, silahkan gunakan nama lain.");
            }
            return false;
        } else {
            return true;
        }
    }

}
