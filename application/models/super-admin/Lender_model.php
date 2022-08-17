<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Lender_model extends CI_Model {
    public function CountLenderList($keyword,$date_range){
		$this->db->where('user_type','LENDERS');
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
				$this->db->or_like('file_id',$keyword);
		    $this->db->group_end();
		}
		return $this->db->count_all_results(TBL_USERS);
	}
     public function LenderList($limit,$offset,$keyword,$date_range){
        $this->db->select('*');
        $this->db->from(TBL_USERS);
	    $this->db->where('user_type','LENDERS');
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
				$this->db->or_like('file_id',$keyword);
		    $this->db->group_end();
		}
		$this->db->limit($limit,$offset);
		return $this->db->get()->result();
	}
	public function CountMerchantList($keyword,$type,$date_range,$loan_type,$id,$record_type,$remark){
		$partnerpermission= PartnerPermission();
		$this->db->select(TBL_USERS.'.*,'.TBL_LENDER_ASSIGN.'.lender_id');
		$this->db->from(TBL_LENDER_ASSIGN);
		$this->db->join(TBL_USERS,TBL_USERS.'.user_id='.TBL_LENDER_ASSIGN.'.merchant_id','INNER');
		$this->db->group_start();
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
		if(!empty($partnerpermission)){
			$this->db->where_in(TBL_USERS.'.created_by',$partnerpermission);
		}
		if(!empty($loan_type)){
			$this->db->where(TBL_USERS.'.loan_type',$loan_type);
		}
		if(!empty($loan_type)){
			$this->db->where(TBL_USERS.'.loan_type',$loan_type);
		}
		if(!empty($remark)){
			if(!empty($remark)){
				if($remark=='no remark'){
					$this->db->where(TBL_USERS.'.remark_time',NULL);
				}elseif($remark=='3 days'){
					$this->db->where("DATE(".TBL_USERS.".remark_time) NOT BETWEEN '".date('Y-m-d',strtotime('-3 days'))."' AND '".date('Y-m-d')."'",null,false);
					$this->db->where("DATE(".TBL_USERS.".remark_time) >=",date('Y-m-d',strtotime('-5 days')));
				}elseif($remark=='5 days'){
					$this->db->where("DATE(".TBL_USERS.".remark_time) NOT BETWEEN '".date('Y-m-d',strtotime('-5 days'))."' AND '".date('Y-m-d')."'",null,false);
					$this->db->where("DATE(".TBL_USERS.".remark_time) >=",date('Y-m-d',strtotime('-10 days')));
				}elseif($remark=='10 days'){
					$this->db->where('DATE('.TBL_USERS.'.remark_time)<',date('Y-m-d',strtotime('-10 days')));
				}
			}
		}
		$this->db->where(TBL_LENDER_ASSIGN.'.lender_id',$id);
		$this->db->group_end();
		if(!empty($keyword)){
			$this->db->group_start();
				$this->db->like(TBL_USERS.'.full_name',$keyword);
				$this->db->or_like(TBL_USERS.'.company_name',$keyword);
				$this->db->or_like(TBL_USERS.'.email',$keyword);
				$this->db->or_like(TBL_USERS.'.mobile_number',$keyword);
				$this->db->or_like(TBL_USERS.'.website',$keyword);
				$this->db->or_like(TBL_USERS.'.gst_number',$keyword);
				$this->db->or_like(TBL_USERS.'.file_id',$keyword);
			$this->db->group_end();
		}
		return $this->db->count_all_results();
		
	}
    public function MerchantList($limit,$offset,$keyword,$type,$date_range,$loan_type,$id,$order_by,$record_type,$remark){
		$partnerpermission= PartnerPermission();
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,lender.company_name as lender_companyname,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount";
		$this->db->select(TBL_USERS.'.*,dsa.file_id as dsa_id,dsa.company_name as dsa_name'.$select);
		$this->db->from(TBL_LENDER_ASSIGN);
		$this->db->join(TBL_USERS,TBL_USERS.'.user_id='.TBL_LENDER_ASSIGN.'.merchant_id','INNER');
		$this->db->join(TBL_USERS.' as lender','lender.user_id='.TBL_LENDER_ASSIGN.'.lender_id','INNER');
		$this->db->join(TBL_USERS.' as dsa','dsa.user_id='.TBL_USERS.'.created_by','LEFT');
		$this->db->group_start();
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
		if(!empty($loan_type)){
			$this->db->where(TBL_USERS.'.loan_type',$loan_type);
		}
		if(!empty($partnerpermission)){
			$this->db->where_in(TBL_USERS.'.created_by',$partnerpermission);
		}
		if(!empty($remark)){
			if(!empty($remark)){
				if($remark=='no remark'){
					$this->db->where(TBL_USERS.'.remark_time',NULL);
				}elseif($remark=='3 days'){
					$this->db->where("DATE(".TBL_USERS.".remark_time) NOT BETWEEN '".date('Y-m-d',strtotime('-3 days'))."' AND '".date('Y-m-d')."'",null,false);
					$this->db->where("DATE(".TBL_USERS.".remark_time) >=",date('Y-m-d',strtotime('-5 days')));
				}elseif($remark=='5 days'){
					$this->db->where("DATE(".TBL_USERS.".remark_time) NOT BETWEEN '".date('Y-m-d',strtotime('-5 days'))."' AND '".date('Y-m-d')."'",null,false);
					$this->db->where("DATE(".TBL_USERS.".remark_time) >=",date('Y-m-d',strtotime('-10 days')));
				}elseif($remark=='10 days'){
					$this->db->where('DATE('.TBL_USERS.'.remark_time)<',date('Y-m-d',strtotime('-10 days')));
				}
			}
		}
		$this->db->where(TBL_LENDER_ASSIGN.'.lender_id',$id);
		$this->db->group_end();
		if(!empty($keyword)){
			$this->db->group_start();
				$this->db->like(TBL_USERS.'.full_name',$keyword);
				$this->db->or_like(TBL_USERS.'.company_name',$keyword);
				$this->db->or_like(TBL_USERS.'.email',$keyword);
				$this->db->or_like(TBL_USERS.'.mobile_number',$keyword);
				$this->db->or_like(TBL_USERS.'.website',$keyword);
				$this->db->or_like(TBL_USERS.'.gst_number',$keyword);
				$this->db->or_like(TBL_USERS.'.file_id',$keyword);
			$this->db->group_end();
		}
		if(!empty($order_by) && $order_by!='Update'){
			if($order_by=='Comment'){
				$this->db->order_by(TBL_USERS.'.comment_time','DESC');
			}elseif($order_by=='Status'){
				if($type=="logged"){
					$this->db->order_by(TBL_USERS.'.logged_time','DESC');
				}elseif($type=="pending"){
					$this->db->order_by(TBL_USERS.'.pending_time','DESC');
				}elseif($type=="approved"){
					$this->db->order_by(TBL_USERS.'.approved_time','DESC');
				}elseif($type=="rejected"){
					$this->db->order_by(TBL_USERS.'.reject_time','DESC');
				}elseif($type=="disbursed"){
					$this->db->order_by(TBL_USERS.'.disbursed_time','DESC');
				}else{
					$this->db->order_by(TBL_USERS.'.updated_at','DESC');
				}
			}
		}else{
			$this->db->order_by(TBL_USERS.'.updated_at','DESC');
		}
		$this->db->limit($limit,$offset);
		return $this->db->get()->result();
	}
	public function GetMerchantResult($lender_id){
		$this->db->select(TBL_USERS.'.full_name,mobile_number,email,gst_number,pan_number,age,company_name,'.TBL_USER_DETAIL.'.*,'.TBL_LENDER_ASSIGN.'.notification');
		$this->db->from(TBL_LENDER_ASSIGN);
		$this->db->join(TBL_USERS,TBL_USERS.'.user_id='.TBL_LENDER_ASSIGN.'.merchant_id','INNER');
		$this->db->join(TBL_USER_DETAIL,TBL_USER_DETAIL.'.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->where(TBL_LENDER_ASSIGN.'.lender_id',$lender_id);
		return $this->db->get()->result();
	}
}