<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!get_permission('pengaturan', 'is_view')) {
            access_denied();
        }

        if ($_POST) {
            if (!get_permission('pengaturan', 'is_edit')) {
                access_denied();
            }
        }

        $config = array();
        if ($this->input->post('submit') == 'setting') {
            foreach ($this->input->post() as $input => $value) {
                if ($input == 'submit') {
                    continue;
                }
                $config[$input] = $value;
            }
            $this->db->where('id', 1);
            $this->db->update('pengaturan_app', $config);
            set_alert('success', 'Data telah berhasil diperbarui');
            redirect(current_url());
        }

        if ($this->input->post('submit') == 'theme') {
            foreach ($this->input->post() as $input => $value) {
                if ($input == 'submit') {
                    continue;
                }
                $config[$input] = $value;
            }
            $this->db->where('id', 1);
            $this->db->update('theme_settings', $config);
            set_alert('success', 'Data telah berhasil diperbarui');
            $this->session->set_flashdata('active', 2);
            redirect(current_url());
        }

        if ($this->input->post('submit') == 'logo') {
            move_uploaded_file($_FILES['logo_file']['tmp_name'], 'uploads/app_image/logo.png');
            move_uploaded_file($_FILES['text_logo']['tmp_name'], 'uploads/app_image/logo-small.png');
            move_uploaded_file($_FILES['print_file']['tmp_name'], 'uploads/app_image/printing-logo.png');
            move_uploaded_file($_FILES['report_card']['tmp_name'], 'uploads/app_image/report-card-logo.png');

            move_uploaded_file($_FILES['slider_1']['tmp_name'], 'uploads/login_image/slider_1.jpg');
            move_uploaded_file($_FILES['slider_2']['tmp_name'], 'uploads/login_image/slider_2.jpg');
            move_uploaded_file($_FILES['slider_3']['tmp_name'], 'uploads/login_image/slider_3.jpg');

            set_alert('success', 'Data telah berhasil diperbarui');
            $this->session->set_flashdata('active', 3);
            redirect(current_url());
        }

        $this->data['title'] = 'Pengaturan';
        $this->data['sub_page'] = 'pengaturan/index';
        $this->data['main_menu'] = 'pengaturan';
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/dropify/css/dropify.min.css',
            ),
            'js' => array(
                'vendor/dropify/js/dropify.min.js',
            ),
        );
        $this->load->view('layout/index', $this->data);
    }

}
