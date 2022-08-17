<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Loginlog_model extends CI_Model {
    public function CountLoginLog($date_range){
		if(!empty($date_range)){
			$date=explode(' - ',$date_range);
			$from_date=$date[0];
			$to_date=end($date);
			$this->db->where('DATE(login_time)>=',date('Y-m-d',strtotime($from_date)));
			$this->db->where('DATE(login_time)<=',date('Y-m-d',strtotime($to_date)));
		}
		return $this->db->count_all_results('login_log');
	}
     public function LoginLog($limit,$offset,$date_range){
        $this->db->select('*');
        $this->db->from('login_log');
	    if(!empty($date_range)){
			$date=explode(' - ',$date_range);
			$from_date=$date[0];
			$to_date=end($date);
			$this->db->where('DATE(login_time)>=',date('Y-m-d',strtotime($from_date)));
			$this->db->where('DATE(login_time)<=',date('Y-m-d',strtotime($to_date)));
        }
        $this->db->order_by('id','DESC');
		$this->db->limit($limit,$offset);	
        return $this->db->get()->result();
    }
    public function GetLog(){
        $this->db->select('*');
        $this->db->from('login_log');
        $this->db->order_by('id','DESC');
        return $this->db->get()->result();
    }
}