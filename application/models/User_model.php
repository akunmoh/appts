<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function save($data, $role = null, $id = null)
    {
        $inser_data1 = array(
            'nama' => $data["nama"],
            'alamat' => $data["alamat"],
            'mobileno' => $data["mobile_no"],
            'email' => $data["email"],
            'photo' => $this->uploadImage('staff'),
        );

        $inser_data2 = array(
            'username' => $data["username"],
            'role' => $data["user_role"],
        );

        if (!isset($data['staff_id']) && empty($data['staff_id'])) {
            // RANDOM STAFF ID GENERATE
            $inser_data1['staff_id'] = substr(app_generate_hash(), 3, 7);
            // SAVE EMPLOYEE INFORMATION IN THE DATABASE
            $this->db->insert('staff', $inser_data1);
            $employeeID = $this->db->insert_id();

            // SAVE EMPLOYEE LOGIN CREDENTIAL INFORMATION IN THE DATABASE
            $inser_data2['active'] = 1;
            $inser_data2['user_id'] = $employeeID;
            $inser_data2['password'] = $this->app_lib->pass_hashed($data["password"]);
            $this->db->insert('login_credential', $inser_data2);

            return $employeeID;
        } else {
            // UPDATE ALL INFORMATION IN THE DATABASE
            $this->db->where('id', $data['staff_id']);
            $this->db->update('staff', $inser_data1);
            // UPDATE LOGIN CREDENTIAL INFORMATION IN THE DATABASE
            $this->db->where('user_id', $data['staff_id']);
            $this->db->update('login_credential', $inser_data2);
        }
    }

    // GET SINGLE EMPLOYEE DETAILS
    public function getSingleStaff($id = '')
    {
        $this->db->select('staff.*,login_credential.role as role_id,login_credential.active,login_credential.username, roles.nama as role');
        $this->db->from('staff');
        $this->db->join('login_credential', 'login_credential.user_id = staff.id', 'inner');
        $this->db->join('roles', 'roles.id = login_credential.role', 'left');
        $this->db->where('staff.id', $id);

        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            show_404();
        }
        return $query->row_array();
    }

    public function getStaffList($active = 1)
    {
        $this->db->select('staff.*,login_credential.role as role_id, roles.nama as role');
        $this->db->from('staff');
        $this->db->join('login_credential', 'login_credential.user_id = staff.id', 'inner');
        $this->db->join('roles', 'roles.id = login_credential.role', 'left');
        $this->db->where_not_in('login_credential.id', array(1));
        $this->db->order_by('staff.id', 'ASC');
        return $this->db->get()->result();
    }

}
