<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Profile_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function staffUpdate($data)
    {
        $update_data = array(
            'nama' => $data['nama'],
            'mobileno' => $data['mobileno'],
            'alamat' => $data['alamat'],
            'photo' => $this->uploadImage('staff'),
            'email' => $data['email'],
        );

        $this->db->where('id', get_loggedin_user_id());
        $this->db->update('staff', $update_data);
    }

}
