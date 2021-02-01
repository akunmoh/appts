<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    protected function user_validation()
    {
        $this->form_validation->set_rules('nama', 'nama', 'trim|required');
        $this->form_validation->set_rules('mobile_no', 'Mobile No', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('user_role', 'Role', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_unique_username');
    }

    public function index()
    {
        if (!get_permission('pengaturan_staff', 'is_view')) {
            access_denied();
        }

        if ($_POST) {
            if (!get_permission('pengaturan_staff', 'is_add')) {
                access_denied();
            }
            $this->user_validation();
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
            $this->form_validation->set_rules('retype_password', 'Retype Password', 'trim|required|matches[password]');
            if ($this->form_validation->run() !== false) {
                $post = $this->input->post();
                $user_id = $this->user_model->save($post);

                set_alert('success', 'Berhasil menambahkan user baru');
                redirect(base_url('user'));
            }
        }

        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/dropify/css/dropify.min.css',
            ),
            'js' => array(
                'js/employee.js',
                'vendor/dropify/js/dropify.min.js',
            ),
        );

        $this->data['title'] = 'User Admin';
        $this->data['sub_page'] = 'user/index';
        $this->data['main_menu'] = 'pengaturan';
        $this->data['stafflist'] = $this->user_model->getStaffList();
        $this->load->view('layout/index', $this->data);
    }

    public function profile($id = '')
    {
        if (!get_permission('pengaturan_staff', 'is_edit')) {
            access_denied();
        }
        if ($this->input->post('submit') == 'update') {
            $this->user_validation();
            if ($this->form_validation->run() == true) {
                $this->user_model->save($this->input->post());

                set_alert('success', 'Data telah berhasil diperbarui');
                $this->session->set_flashdata('profile_tab', 1);
                redirect(base_url('user/profile/' . $id));
            } else {
                $this->session->set_flashdata('profile_tab', 1);
            }
        }
        $this->data['staff'] = $this->user_model->getSingleStaff($id);
        $this->data['title'] = 'User Profil';
        $this->data['sub_page'] = 'user/profile';
        $this->data['main_menu'] = 'pengaturan';
        $this->data['headerelements'] = array(
            'css' => array(
                'vendor/dropify/css/dropify.min.css',
            ),
            'js' => array(
                'js/employee.js',
                'vendor/dropify/js/dropify.min.js',
            ),
        );
        $this->load->view('layout/index', $this->data);
    }

    public function delete($id = '')
    {
        if (!get_permission('pengaturan_staff', 'is_delete')) {
            access_denied();
        }
        $this->db->delete('staff', array('id' => $id));
        if ($this->db->affected_rows() > 0) {
            $this->db->where('user_id', $id);
            $this->db->where_not_in('role', array(1));
            $this->db->delete('login_credential');
        }
    }

    public function unique_username($nama)
    {
        $id = $this->input->post('staff_id');
        if (isset($id)) {
            $where = array('username' => $nama, 'user_id != ' => $id);
        } else {
            $where = array('username' => $nama);
        }
        $q = $this->db->get_where('login_credential', $where);
        if ($q->num_rows() > 0) {
            $this->form_validation->set_message("unique_username", "Username sudah digunakan.");
            return false;
        } else {
            return true;
        }
    }

    public function valid_role($id)
    {
        $restrictions = array(1);
        if (in_array($id, $restrictions)) {
            $this->form_validation->set_message("valid_role", 'Role tidak di boleh gunakan');
            return false;
        } else {
            return true;
        }
    }

    public function change_password()
    {
        if (!get_permission('pengaturan_staff', 'is_edit')) {
            ajax_access_denied();
        }
        if (!isset($_POST['authentication'])) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');
        } else {
            $this->form_validation->set_rules('password', 'Password', 'trim');
        }
        if ($this->form_validation->run() !== false) {
            $staffid = $this->input->post('staff_id');
            $password = $this->input->post('password');
            if (!isset($_POST['authentication'])) {
                $this->db->where_not_in('role', array(1));
                $this->db->where('user_id', $staffid);
                $this->db->update('login_credential', array('password' => $this->app_lib->pass_hashed($password)));
            }else{
                $this->db->where_not_in('role', array(1));
                $this->db->where('user_id', $staffid);
                $this->db->update('login_credential', array('active' => 0));
            }
            set_alert('success', 'Data telah berhasil diperbarui');
            $array  = array('status' => 'success');
        } else {
            $error = $this->form_validation->error_array();
            $array = array('status' => 'fail', 'error' => $error);
        }
        echo json_encode($array);
    }

}
