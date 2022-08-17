<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_model extends CI_Model{
    public function MerchantList($filter_type,$date_range,$type,$dsa_id,$lender_id,$partnerpermission){
        if($filter_type=='Business'){
            $select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,lender.company_name as lender_companyname,lender.file_id as lender_file_id,".
			TBL_USERS.".assigned_time,".TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,
			detail.*,detail.pan_number,IFNULL(detail.user_id,".TBL_USERS.".user_id) as user_id";
			$this->db->select(TBL_USERS.'.*,dsa.company_name as dsa_name,dsa.file_id as dsa_id'.$select);
			$this->db->from(TBL_USERS);
			$this->db->join(TBL_USERS.' as dsa','dsa.user_id='.TBL_USERS.'.created_by','LEFT');
			$this->db->join(TBL_USER_DETAIL.' as detail','detail.user_id='.TBL_USERS.'.user_id','LEFT');
			$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.'.merchant_id='.TBL_USERS.'.user_id','LEFT');
			$this->db->join(TBL_USERS.' as lender','lender.user_id='.TBL_LENDER_ASSIGN.'.lender_id','LEFT');
			$this->db->where(TBL_USERS.'.loan_type','Business');
        }else{
            $select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,lender.company_name as lender_companyname,lender.file_id as lender_file_id,".
			TBL_USERS.".assigned_time,".TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,
			detail.*,detail.pan_number,IFNULL(detail.user_id,".TBL_USERS.".user_id) as user_id";
			$this->db->select(TBL_USERS.'.*,dsa.company_name as dsa_name,dsa.file_id as dsa_id'.$select);
			$this->db->from(TBL_USERS);
			$this->db->join(TBL_USERS.' as dsa','dsa.user_id='.TBL_USERS.'.created_by','LEFT');
			$this->db->join('user_detail as detail','detail.user_id='.TBL_USERS.'.user_id','LEFT');
			$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.'.merchant_id='.TBL_USERS.'.user_id','LEFT');
			$this->db->join(TBL_USERS.' as lender','lender.user_id='.TBL_LENDER_ASSIGN.'.lender_id','LEFT');
        }
        $this->db->where(TBL_USERS.'.user_type','MERCHANT');
        $this->db->where(TBL_USERS.'.loan_type',$filter_type);
        if(!empty($dsa_id)){
			$this->db->where(TBL_USERS.'.created_by',$dsa_id);
		}
        if(!empty($lender_id)){
			$this->db->where(TBL_LENDER_ASSIGN.'.lender_id',$lender_id);
		}
		if(!empty($partnerpermission)){
			$this->db->where_in(TBL_USERS.'.created_by',$partnerpermission);
		}
		if($type=='short_close'){
			if(!empty($date_range)){
				$date=explode(' - ',$date_range);
				$from_date=$date[0];
				$to_date=end($date);
				$this->db->where(['DATE('.TBL_USERS.'.short_close_time)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_USERS.'.short_close_time)<='=>date('Y-m-d',strtotime($to_date))]);
			}
		}elseif($type=='incomplete'  || $type=='all'){
			if(!empty($date_range)){
				$date=explode(' - ',$date_range);
				$from_date=$date[0];
				$to_date=end($date);
				$this->db->where(['DATE('.TBL_USERS.'.created_at)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_USERS.'.created_at)<='=>date('Y-m-d',strtotime($to_date))]);
			}
		}elseif($type=='received'){
			if(!empty($date_range)){
				$date=explode(' - ',$date_range);
				$from_date=$date[0];
				$to_date=end($date);
				$this->db->where(['DATE('.TBL_USERS.'.received_time)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_USERS.'.received_time)<='=>date('Y-m-d',strtotime($to_date))]);
			}
		}elseif($type=='assigned'){
			if(!empty($date_range)){
				$date=explode(' - ',$date_range);
				$from_date=$date[0];
				$to_date=end($date);
				$this->db->where(['DATE('.TBL_USERS.'.assigned_time)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_USERS.'.assigned_time)<='=>date('Y-m-d',strtotime($to_date))]);
			}
		}elseif($type=='logged'){
			if(!empty($date_range)){
				$date=explode(' - ',$date_range);
				$from_date=$date[0];
				$to_date=end($date);
				$this->db->where(['DATE('.TBL_LENDER_ASSIGN.'.logged_time)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_LENDER_ASSIGN.'.logged_time)<='=>date('Y-m-d',strtotime($to_date))]);
			}
		}elseif($type=='pending'){
			if(!empty($date_range)){
				$date=explode(' - ',$date_range);
				$from_date=$date[0];
				$to_date=end($date);
				$this->db->where(['DATE('.TBL_LENDER_ASSIGN.'.pending_time)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_LENDER_ASSIGN.'.pending_time)<='=>date('Y-m-d',strtotime($to_date))]);
			}
		}elseif($type=='approved'){
			if(!empty($date_range)){
				$date=explode(' - ',$date_range);
				$from_date=$date[0];
				$to_date=end($date);
				$this->db->where(['DATE('.TBL_LENDER_ASSIGN.'.approved_time)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_LENDER_ASSIGN.'.approved_time)<='=>date('Y-m-d',strtotime($to_date))]);
			}
		}elseif($type=='rejected'){
			if(!empty($date_range)){
				$date=explode(' - ',$date_range);
				$from_date=$date[0];
				$to_date=end($date);
				$this->db->where(['DATE('.TBL_LENDER_ASSIGN.'.reject_time)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_LENDER_ASSIGN.'.reject_time)<='=>date('Y-m-d',strtotime($to_date))]);
			}
		}elseif($type=='disbursed'){
			if(!empty($date_range)){
				$date=explode(' - ',$date_range);
				$from_date=$date[0];
				$to_date=end($date);
				$this->db->where(['DATE('.TBL_LENDER_ASSIGN.'.disbursed_time)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_LENDER_ASSIGN.'.disbursed_time)<='=>date('Y-m-d',strtotime($to_date))]);
			}
		}
		return $this->db->get()->result();
	}
	public function MerchantLinderWiseList($filter){
		$filter=(object)$filter;
		$type=$filter->status;
        $select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,lender.company_name as lender_companyname,lender.file_id as lender_file_id,".
		TBL_USERS.".assigned_time,".TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,
		user_detail.residence_city,".TBL_USER_DETAIL.".city";
		$this->db->select(TBL_USERS.'.*,'.$select);
		$this->db->from(TBL_USERS);
		//$this->db->join(TBL_USERS.' as dsa','dsa.user_id='.TBL_USERS.'.created_by','LEFT');
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.'.merchant_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join(TBL_USERS.' as lender','lender.user_id='.TBL_LENDER_ASSIGN.'.lender_id','LEFT');
		$this->db->join(TBL_USER_DETAIL,TBL_USER_DETAIL.'.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join('user_detail','user_detail.user_id='.TBL_USERS.'.user_id','LEFT');
        $this->db->where(TBL_USERS.'.user_type','MERCHANT');
		$this->db->where(TBL_LENDER_ASSIGN.'.lender_id!=',NULL);
		$this->db->where(TBL_LENDER_ASSIGN.'.status!=','DISBURSED');
        if(!empty($filter->multi_extrareport_ids)){
			$this->db->where_in(TBL_LENDER_ASSIGN.'.lender_id',$filter->multi_extrareport_ids);
		}
		if($type=="all"){
			$this->db->where(TBL_LENDER_ASSIGN.'.logged_time!=',NULL);
		}elseif($type=='logged'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','LOGGED');
		}elseif($type=='pending'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','PENDING');
		}elseif($type=='approved'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','APPROVED');
		}elseif($type=='rejected'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','REJECTED');
		}
		return $this->db->get()->result();
	}
	public function MerchantPartnerWiseList($filter){
		$filter=(object)$filter;
		$type=$filter->status;
        $select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,".
		TBL_USERS.".assigned_time,".TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,
		user_detail.residence_city,".TBL_USER_DETAIL.".city";
		$this->db->select(TBL_USERS.'.*,dsa.company_name as dsa_name,dsa.file_id as dsa_id'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_USERS.' as dsa','dsa.user_id='.TBL_USERS.'.created_by','LEFT');
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.'.merchant_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join(TBL_USER_DETAIL,TBL_USER_DETAIL.'.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join('user_detail','user_detail.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
        if(!empty($filter->multi_extrareport_ids)){
			$this->db->where_in(TBL_USERS.'.created_by',$filter->multi_extrareport_ids);
		}
		if($type=="all"){
			$this->db->where(TBL_USERS.'.received_time!=',NULL);
		}elseif($type=='received'){
			$this->db->where(TBL_USERS.'.status',NULL);
			$this->db->where('NOT EXISTS (SELECT * FROM user_lender_assign WHERE user_lender_assign.merchant_id='.TBL_USERS.'.user_id)', '', FALSE);
		}elseif($type=='assigned'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','ASSiGNED');
		}elseif($type=='logged'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','LOGGED');
		}elseif($type=='pending'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','PENDING');
		}elseif($type=='approved'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','APPROVED');
		}elseif($type=='rejected'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','REJECTED');
		}
		return $this->db->get()->result();
		
	}
	public function DisbursedCase(){
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,lender.company_name as lender_companyname,lender.file_id as lender_file_id,".
		TBL_USERS.".assigned_time,".TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,
		user_detail.residence_city,".TBL_USER_DETAIL.".city";
		$this->db->select(TBL_USERS.'.*,dsa.company_name as dsa_name,dsa.user_id as dsa_id'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_USERS.' as dsa','dsa.user_id='.TBL_USERS.'.created_by','LEFT');
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.'.merchant_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join(TBL_USERS.' as lender','lender.user_id='.TBL_LENDER_ASSIGN.'.lender_id','LEFT');
		$this->db->join(TBL_USER_DETAIL,TBL_USER_DETAIL.'.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join('user_detail','user_detail.user_id='.TBL_USERS.'.user_id','LEFT');
        $this->db->where(TBL_USERS.'.user_type','MERCHANT');
		$this->db->where(TBL_LENDER_ASSIGN.'.lender_id!=',NULL);
		$this->db->where(TBL_LENDER_ASSIGN.'.status','DISBURSED');
		return $this->db->get()->result();
	}
}