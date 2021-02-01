<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends Authentication_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (is_loggedin()) {
            redirect(base_url('dashboard'));
        }

        if ($_POST) {
            $rules = array(
                array(
                    'field' => 'username',
                    'label' => "Username",
                    'rules' => 'trim|required',
                ),
                array(
                    'field' => 'password',
                    'label' => "Password",
                    'rules' => 'trim|required',
                ),
            );
            $this->form_validation->set_rules($rules);

            if ($this->form_validation->run() !== false) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $login_credential = $this->authentication_model->login_credential($username, $password);

                if ($login_credential) {
                    if ($login_credential->active) {
                        $getUser = $this->application_model->getUserNameByRoleID($login_credential->role, $login_credential->user_id);

                        $sessionData = array(
                            'nama' => $getUser['nama'],
                            'logger_photo' => $getUser['photo'],
                            'loggedin_id' => $login_credential->id,
                            'loggedin_userid' => $login_credential->user_id,
                            'loggedin_role_id' => $login_credential->role,
                            'loggedin' => true,
                        );

                        $this->session->set_userdata($sessionData);
                        $this->db->update('login_credential', array('last_login' => date('Y-m-d H:i:s')), array('id' => $login_credential->id));

                        if ($this->session->has_userdata('redirect_url')) {
                            redirect($this->session->userdata('redirect_url'));
                        } else {
                            redirect(base_url('beranda'));
                        }

                    } else {
                        set_alert('error', 'Maaf akun telah di blok, silahkan hubungi admin');
                        redirect(base_url('login'));
                    }
                } else {
                    set_alert('error', 'Username atau password salah, silahkan ulangi kembali');
                    redirect(base_url('login'));
                }
            }
        }
        $this->load->view('authentication/login', $this->data);
    }

    public function logout()
    {
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('logger_photo');
        $this->session->unset_userdata('loggedin_id');
        $this->session->unset_userdata('loggedin_userid');
        $this->session->unset_userdata('loggedin');
        $this->session->sess_destroy();
        redirect(base_url(), 'refresh');
    }
}
