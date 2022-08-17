<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Merchant_model extends CI_Model {
    public function CountMerchantList($keyword,$type,$date_range,$loan_type){
        $select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status";
		$this->db->select(TBL_USERS.'.user_id'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.'.merchant_id='.TBL_USERS.'.user_id AND '.TBL_LENDER_ASSIGN.'.lender_id='.$this->session->userdata('user_id'),'INNER');
		if($type=='logged'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','LOGGED');
		}elseif($type=='pending'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','PENDING');
		}elseif($type=='approved'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','APPROVED');
		}elseif($type=='rejected'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','REJECTED');
		}elseif($type=='disbursed'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','DISBURSED');
		}
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		if(!empty($loan_type)){
			$this->db->where(TBL_USERS.'.loan_type',$loan_type);
		}
		if(!empty($keyword)){
			$this->db->group_start();
				$this->db->like(TBL_USERS.'.full_name',$keyword);
				$this->db->or_like(TBL_USERS.'.company_name',$keyword);
				$this->db->or_like(TBL_USERS.'.email',$keyword);
				$this->db->or_like(TBL_USERS.'.mobile_number',$keyword);
				$this->db->or_like(TBL_USERS.'.website',$keyword);
				$this->db->or_like(TBL_USERS.'.gst_number',$keyword);
				$this->db->or_like(TBL_USERS.'.file_id',$keyword);
				$this->db->or_like('dsa.file_id',$keyword);
			$this->db->group_end();
		}
		$this->db->group_by(TBL_USERS.'.user_id');
		return $this->db->count_all_results();
	}
     public function MerchantList($limit,$offset,$keyword,$type,$date_range,$loan_type){
        $select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount";
		
		$this->db->select(TBL_USERS.'.*,'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.'.merchant_id='.TBL_USERS.'.user_id AND '.TBL_LENDER_ASSIGN.'.lender_id='.$this->session->userdata('user_id'),'INNER');
		if($type=='logged'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','LOGGED');
		}elseif($type=='pending'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','PENDING');
		}elseif($type=='approved'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','APPROVED');
		}elseif($type=='rejected'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','REJECTED');
		}elseif($type=='disbursed'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','DISBURSED');
		}
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		if(!empty($loan_type)){
			$this->db->where(TBL_USERS.'.loan_type',$loan_type);
		}
		if(!empty($keyword)){
			$this->db->group_start();
				$this->db->like(TBL_USERS.'.full_name',$keyword);
				$this->db->or_like(TBL_USERS.'.company_name',$keyword);
				$this->db->or_like(TBL_USERS.'.email',$keyword);
				$this->db->or_like(TBL_USERS.'.mobile_number',$keyword);
				$this->db->or_like(TBL_USERS.'.website',$keyword);
				$this->db->or_like(TBL_USERS.'.gst_number',$keyword);
				$this->db->or_like(TBL_USERS.'.file_id',$keyword);
				$this->db->or_like('dsa.file_id',$keyword);
			$this->db->group_end();
		}
		$this->db->group_by(TBL_USERS.'.user_id');
		return $this->db->get()->result();
	}
	public function GetUserDetail($user_id){
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,"
			.TBL_USER_DETAIL.".*,IFNULL(".TBL_USER_DETAIL.".user_id,".TBL_USERS.".user_id) as user_id,".TBL_LENDER_ASSIGN.".disbursed_amount";
		
		$this->db->select(TBL_USERS.'.*'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_USER_DETAIL,TBL_USER_DETAIL.'.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.'.merchant_id='.TBL_USERS.'.user_id AND '.TBL_LENDER_ASSIGN.'.lender_id='.$this->session->userdata('user_id'),'INNER');
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		$this->db->where(TBL_USERS.'.user_id',$user_id);
		$data= $this->db->get()->row();
		$data->partner=$this->common_model->GetResult(TBL_USER_PARTNER,['user_id'=>$user_id]);
		$data->applicant=$this->common_model->GetResult(TBL_USER_COAPPLICANT,['user_id'=>$user_id]);
		return $data;
	}
	public function GetUserDetail2($user_id){
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,
			user_detail.*,IFNULL(user_detail.user_id,".TBL_USERS.".user_id) as user_id,".TBL_LENDER_ASSIGN.".disbursed_amount";
		
		$this->db->select(TBL_USERS.'.*'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join('user_detail','user_detail.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.'.merchant_id='.TBL_USERS.'.user_id AND '.TBL_LENDER_ASSIGN.'.lender_id='.$this->session->userdata('user_id'),'INNER');
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		$this->db->where(TBL_USERS.'.user_id',$user_id);
		return $this->db->get()->row();

	}
	public function GetMerchantResult($user_id){
	    $this->db->select(TBL_USERS.'.full_name,mobile_number,email,age,company_name,created_by,file_id,status,'.TBL_USERS.'.created_at,loan_type,'.TBL_USER_DETAIL.'.*,IFNULL('.TBL_USER_DETAIL.'.user_id,'.TBL_USERS.'.user_id) as user_id');
	    $this->db->from(TBL_USERS);
	    $this->db->join(TBL_USER_DETAIL,TBL_USER_DETAIL.'.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		if(!empty($user_id)){
			$this->db->where(TBL_USERS.'.user_id',$user_id);
		}
	    return $this->db->get()->result();
	}
	public function GetMerchantResult2($user_id){
	    $this->db->select(TBL_USERS.'.mobile_number,email,age,company_name,created_by,file_id,status,'.TBL_USERS.'.created_at,loan_type,user_detail.*,IFNULL(user_detail.user_id,'.TBL_USERS.'.user_id) as user_id,'.TBL_USERS.'.full_name');
	    $this->db->from(TBL_USERS);
	    $this->db->join('user_detail','user_detail.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		if(!empty($user_id)){
			$this->db->where(TBL_USERS.'.user_id',$user_id);
		}
	    return $this->db->get()->result();
	}
}