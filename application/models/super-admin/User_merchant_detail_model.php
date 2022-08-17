<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_merchant_detail_model extends CI_Model {
    public function CountList($keyword,$id,$date_range){
		$this->db->where('created_by',$id);
		if(!empty($date_range)){
			$date=explode(' - ',$date_range);
			$from_date=$date[0];
			$to_date=end($date);
			$this->db->where(['DATE('.TBL_USERS.'.created_at)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_USERS.'.created_at)<='=>date('Y-m-d',strtotime($to_date))]);
		}
		if(!empty($keyword)){
		    $this->db->group_start();
		        $this->db->like('full_name',$keyword);
		        $this->db->or_like('company_name',$keyword);
		        $this->db->or_like('email',$keyword);
		        $this->db->or_like('mobile_number',$keyword);
		        $this->db->or_like('website',$keyword);
		        $this->db->or_like('gst_number',$keyword);
		    $this->db->group_end();
		}
		return $this->db->count_all_results(TBL_USERS);
	}
     public function MerchantList($limit,$offset,$keyword,$id,$date_range){
        $this->db->select('*');
        $this->db->from(TBL_USERS);
		$this->db->where('created_by',$id);
		if(!empty($date_range)){
			$date=explode(' - ',$date_range);
			$from_date=$date[0];
			$to_date=end($date);
			$this->db->where(['DATE('.TBL_USERS.'.created_at)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_USERS.'.created_at)<='=>date('Y-m-d',strtotime($to_date))]);
		}
		if(!empty($keyword)){
		    $this->db->group_start();
				$this->db->like('full_name',$keyword);
				$this->db->or_like('company_name',$keyword);
				$this->db->or_like('email',$keyword);
				$this->db->or_like('mobile_number',$keyword);
				$this->db->or_like('website',$keyword);
				$this->db->or_like('gst_number',$keyword);
		    $this->db->group_end();
		}
		$this->db->limit($limit,$offset);
		return $this->db->get()->result();
	}

}