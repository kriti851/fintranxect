<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth_model extends CI_Model {
    public function Login($username){
		$this->db->select('*');
		$this->db->from(TBL_USERS);
		$this->db->where('email',$username);
		$this->db->or_where('mobile_number',$username);
		return $this->db->get()->row();
	}

}