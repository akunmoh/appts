<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class App_lib
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function get_pendidikan()
    {
        $pendidikan = array(
            '' => 'Pilih',
            'SD/MI' => "SD/MI",
            'SMP/MTS' => "SMP/MTS",
            'SMA/SMK' => "SMA/SMK",
            'D3/Diploma' => "D3/Diploma",
            'S1/Sarjana' => "S1/Sarjana",
            'S2/Magister' => "S2/Magister",
        );
        return $pendidikan;
    }

    public function get_gender()
    {
        $gender = array(
            '' => 'Pilih',
            'Laki-Laki' => "Laki-Laki",
            'Perempuan' => "Perempuan",
        );
        return $gender;
    }

    public function get_agama()
    {
        $agama = array(
            '' => 'Pilih',
            'ISLAM' => "ISLAM",
            'KRISTEN' => "KRISTEN",
            'HINDU' => "HINDU",
            'BUDHA' => "BUDHA",
        );
        return $agama;
    }

    public function get_pernikahan()
    {
        $pernikahan = array(
            '' => 'Pilih',
            'BELUM KAWIN' => "BELUM KAWIN",
            'KAWIN' => "KAWIN",
            'CERAI HIDUP' => "CERAI HIDUP",
            'CERAI MATI' => "CERAI MATI",
        );
        return $pernikahan;
    }

	function get_months_list($m)
	{
		$months = array(
		    '01' => 'January',
		    '02' => 'February',
		    '03' => 'March',
		    '04' => 'April',
		    '05' => 'May',
		    '06' => 'June',
		    '07' => 'July ',
		    '08' => 'August',
		    '09' => 'September',
		    '10' => 'October',
		    '11' => 'November',
		    '12' => 'December',
		);
		return $months[$m];
	}

    public function get_credential_id($user_id, $staff = 'staff')
    {
        $this->CI->db->select('id');
        if ($staff == 'staff') {
            $this->CI->db->where_not_in('role', array(6, 7));
        } elseif ($staff == 'parent') {
            $this->CI->db->where('role', 6);
        } elseif ($staff == 'student') {
            $this->CI->db->where('role', 7);
        }
        $this->CI->db->where('user_id', $user_id);
        $result = $this->CI->db->get('login_credential')->row_array();
        return $result['id'];
    }

    function get_nota_no($table)
    {
        $result = $this->CI->db->select("max(no_nota) as id")->get($table)->row_array();
        $id = $result["id"];
        if (!empty($id)) {
            $bill = $id + 1;
        } else {
            $bill = 1;
        }
        return str_pad($bill, 4, '0', STR_PAD_LEFT);
    }

    function get_kode($table)
    {
        $result = $this->CI->db->select("max(id) as id")->get($table)->row_array();
        $id = $result["id"];
        if (!empty($id)) {
            $bill = $id + 1;
        } else {
            $bill = 1;
        }
        return str_pad($bill, 6, 'GD00', STR_PAD_LEFT);
    }

    function get_table($table, $id = NULL, $single = FALSE)
    {
        if ($single == TRUE) {
            $method = 'row_array';
        } else {
            $this->CI->db->order_by('id', 'ASC');
            $method = 'result_array';
        }
        if ($id != NULL) {
            $this->CI->db->where('id', $id);
        }
        $query = $this->CI->db->get($table);
        return $query->$method();
    }

    function getTable($table, $where = "", $single = FALSE)
    {
        if ($where != NULL) {
            $this->CI->db->where($where);
        }
        if ($single == TRUE) {
            $method = "row_array";
        } else {
            $this->CI->db->order_by("id", "asc");
            $method = "result_array";
        }
        $query = $this->CI->db->get($table);
        return $query->$method();
    }

    public function check_branch_restrictions($table, $id = '') {
        if (empty($id)) {
             access_denied();
        }
        if (!is_superadmin_loggedin()) {
            $query = $this->CI->db->select('id,branch_id')->from($table)->where('id', $id)->limit(1)->get();
            if ($query->num_rows() != 0) {
                $branch_id = $query->row()->branch_id;
                if ($branch_id != $this->CI->session->userdata('loggedin_branch')) {
                    access_denied();
                }
            }
        }
    }

    public function pass_hashed($password)
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        return $hashed;
    }

    public function verify_password($password, $encrypt_password)
    {
        $hashed = password_verify($password, $encrypt_password);
        return $hashed;
    }

    public function getStaffList($branch_id = '', $role='')
    {
        $this->CI->db->select('s.id,s.nama,s.staff_id');
        $this->CI->db->from('staff as s');
        $this->CI->db->join('login_credential as l', 'l.user_id = s.id and l.role != 6 and l.role != 7', 'inner');
        if (!empty($branch_id)) {
            $this->CI->db->where('s.branch_id', $branch_id);
        }
        if (!empty($role)) {
            $this->CI->db->where_in('l.role', array($role));
        }
        $result = $this->CI->db->get()->result();
        $array = array('' => 'Pilih');
        foreach ($result as $row) {
            $array[$row->id] = $row->nama . ' (' . $row->staff_id . ')';
        }
        return $array;
    }

    public function getSelectList($table, $all = '')
    {
        
        if ($all == 'all') {
            $arrayData['all'] = 'Pilih Semua';
        }else{
            $arrayData = array('' => 'Pilih');
        }
        $result = $this->CI->db->get($table)->result();
        foreach ($result as $row) {
            $arrayData[$row->id] = $row->nama;
        }
        return $arrayData;
    }

    public function getRoles($arra_id = [1])
    {
        if ($arra_id !='all') {
            $this->CI->db->where_not_in('id', $arra_id);
        }
        $rolelist = $this->CI->db->get('roles')->result();
        $role_array = array('' => 'Pilih');
        foreach ($rolelist as $role) {
            $role_array[$role->id] = $role->nama;
        }
        return $role_array;
    }

    public function getPo($arra_id = [1])
    {
        if ($arra_id !='all') {
            $this->CI->db->where_not_in('id', $arra_id);
        }
        $rolelist = $this->CI->db->get('po_nama')->result();
        $role_array = array('' => 'Pilih');
        foreach ($rolelist as $role) {
            $role_array[$role->id] = $role->nama;
        }
        return $role_array;
    }

    public function generateCSRF()
    {
        return '<input type="hidden" name="' . $this->CI->security->get_csrf_token_name() . '" value="' . $this->CI->security->get_csrf_hash() . '" />';
    }

    public function get_document_category()
    {
        $category = array(
            '' => 'Pilih',
            '1' => "Resume File",
            '2' => "Offer Letter",
            '3' => "Joining Letter",
            '4' => "Experience Certificate",
            '5' => "Resignation Letter",
            '6' => "Other Documents",
        );
        return $category;
    }

    public function getAnimationslist()
    {
        $animations = array(
            'fadeIn' => "fadeIn",
            'fadeInUp' => "fadeInUp",
            'fadeInDown' => "fadeInDown",
            'fadeInLeft' => "fadeInLeft",
            'fadeInRight' => "fadeInRight",
            'bounceIn' => "bounceIn",
            'rotateInUpLeft' => "rotateInUpLeft",
            'rotateInDownLeft' => "rotateInDownLeft",
            'rotateInUpRight' => "rotateInUpRight",
            'rotateInDownRight' => "rotateInDownRight",
        );
        return $animations;
    }

    public function getMonthslist($m)
    {
        $months = array(
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July ',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        );
        return $months[$m];
    }

    public function getDateformat()
    {
        $date = array(
            "Y-m-d" => "yyyy-mm-dd",
            "Y/m/d" => "yyyy/mm/dd",
            "Y.m.d" => "yyyy.mm.dd",
            "d-M-Y" => "dd-mmm-yyyy",
            "d/M/Y" => "dd/mmm/yyyy",
            "d.M.Y" => "dd.mmm.yyyy",
            "d-m-Y" => "dd-mm-yyyy",
            "d/m/Y" => "dd/mm/yyyy",
            "d.m.Y" => "dd.mm.yyyy",
            "m-d-Y" => "mm-dd-yyyy",
            "m/d/Y" => "mm/dd/yyyy",
            "m.d.Y" => "mm.dd.yyyy",
        );
        return $date;
    }

    function timezone_list()
    {
        static $timezones = null;
        if ($timezones === null) {
            $timezones = [];
            $offsets = [];
            $now = new DateTime('now', new DateTimeZone('UTC'));
                foreach (DateTimeZone::listIdentifiers() as $timezone) {
                $now->setTimezone(new DateTimeZone($timezone));
                $offsets[] = $offset = $now->getOffset();
                $timezones[$timezone] = '(' . $this->format_GMT_offset($offset) . ') ' . $this->format_timezone_name($timezone);
            }
            array_multisort($offsets, $timezones);
        }
        return $timezones;
    }

    function format_GMT_offset($offset)
    {
        $hours = intval($offset / 3600);
        $minutes = abs(intval($offset % 3600 / 60));
        return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
    }

    function format_timezone_name($name)
    {
        $name = str_replace('/', ', ', $name);
        $name = str_replace('_', ' ', $name);
        $name = str_replace('St ', 'St. ', $name);
        return $name;
    }

}
