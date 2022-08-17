<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Log_model extends CI_Model {
    public function CountCaseLog($date_range){
		if(!empty($date_range)){
			$date=explode(' - ',$date_range);
			$from_date=$date[0];
			$to_date=end($date);
			$this->db->where('DATE(created_at)>=',date('Y-m-d',strtotime($from_date)));
			$this->db->where('DATE(created_at)<=',date('Y-m-d',strtotime($to_date)));
		}
		return $this->db->count_all_results('case_log');
	}
     public function CaseLog($limit,$offset,$date_range){
        $this->db->select('case_log.*,'.TBL_USERS.'.full_name,'.TBL_USERS.'.file_id');
        $this->db->from('case_log');
        $this->db->join(TBL_USERS,TBL_USERS.'.user_id=case_log.merchant_id','LEFT');
	    if(!empty($date_range)){
			$date=explode(' - ',$date_range);
			$from_date=$date[0];
			$to_date=end($date);
			$this->db->where('DATE(case_log.created_at)>=',date('Y-m-d',strtotime($from_date)));
			$this->db->where('DATE(case_log.created_at)<=',date('Y-m-d',strtotime($to_date)));
        }
        $this->db->order_by('id','DESC');
		$this->db->limit($limit,$offset);	
        return $this->db->get()->result();
    }
    public function GetCaseLog(){
		$from_date=date('Y-m-d', strtotime('-3 month'));
        $this->db->select('case_log.*,'.TBL_USERS.'.full_name,'.TBL_USERS.'.file_id');
        $this->db->from('case_log');
        $this->db->join(TBL_USERS,TBL_USERS.'.user_id=case_log.merchant_id','LEFT');
		$this->db->where('DATE(case_log.created_at)>=',date('Y-m-d',strtotime($from_date)));
		$this->db->where('DATE(case_log.created_at)<=',date('Y-m-d'));
        $this->db->order_by('id','DESC');
        return $this->db->get()->result();
    }
}