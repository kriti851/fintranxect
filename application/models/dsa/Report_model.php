<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Report_model extends CI_Model{
    public function CountMerchantList($keyword,$type,$date_range,$loan_type,$dsaid){
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,lender.company_name as lender_companyname";
		$this->db->select(TBL_USERS.'.user_id,dsa.full_name as dsa_name'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_USERS.' as dsa','dsa.user_id='.TBL_USERS.'.created_by','LEFT');
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.".id=(SELECT id FROM user_lender_assign LEFT JOIN users as otheruser ON otheruser.user_id=user_lender_assign.merchant_id WHERE user_lender_assign.merchant_id=users.user_id order by (CASE WHEN user_lender_assign.disbursed_time IS NOT NULL THEN 6 WHEN user_lender_assign.approved_time IS NOT NULL THEN 5 WHEN user_lender_assign.pending_time IS NOT NULL THEN 4 WHEN user_lender_assign.logged_time IS NOT NULL THEN 3 WHEN otheruser.assigned_time IS NOT NULL THEN 2 WHEN user_lender_assign.reject_time IS NOT NULL THEN 0 ELSE 1 END) DESC LIMIT 1)",'LEFT');
		$this->db->join(TBL_USERS.' as lender','lender.user_id='.TBL_LENDER_ASSIGN.'.lender_id','LEFT');
		if($type=='short_close'){
			if(!empty($date_range)){
				$date=explode(' - ',$date_range);
				$from_date=$date[0];
				$to_date=end($date);
				$this->db->where(['DATE('.TBL_USERS.'.short_close_time)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_USERS.'.short_close_time)<='=>date('Y-m-d',strtotime($to_date))]);
			}
		}elseif($type=='incomplete' || $type=='all'){
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
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		if(!empty($loan_type)){
			$this->db->where(TBL_USERS.'.loan_type',$loan_type);
		}
		$this->db->where(TBL_USERS.'.created_by',$dsaid);
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
		return $this->db->count_all_results();
	}
	public function MerchantList($limit,$offset,$keyword,$type,$date_range,$loan_type,$dsaid){
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,lender.company_name as lender_companyname,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount";

		$this->db->select(TBL_USERS.'.*,dsa.full_name as dsa_name'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_USERS.' as dsa','dsa.user_id='.TBL_USERS.'.created_by','LEFT');
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.".id=(SELECT id FROM user_lender_assign LEFT JOIN users as otheruser ON otheruser.user_id=user_lender_assign.merchant_id WHERE user_lender_assign.merchant_id=users.user_id order by (CASE WHEN user_lender_assign.disbursed_time IS NOT NULL THEN 6 WHEN user_lender_assign.approved_time IS NOT NULL THEN 5 WHEN user_lender_assign.pending_time IS NOT NULL THEN 4 WHEN user_lender_assign.logged_time IS NOT NULL THEN 3 WHEN otheruser.assigned_time IS NOT NULL THEN 2 WHEN user_lender_assign.reject_time IS NOT NULL THEN 0 ELSE 1 END) DESC LIMIT 1)",'LEFT');
		$this->db->join(TBL_USERS.' as lender','lender.user_id='.TBL_LENDER_ASSIGN.'.lender_id','LEFT');
		if($type=='short_close'){
			if(!empty($date_range)){
				$date=explode(' - ',$date_range);
				$from_date=$date[0];
				$to_date=end($date);
				$this->db->where(['DATE('.TBL_USERS.'.short_close_time)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_USERS.'.short_close_time)<='=>date('Y-m-d',strtotime($to_date))]);
			}
		}elseif($type=='incomplete' || $type=='all'){
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
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		if(!empty($loan_type)){
			$this->db->where(TBL_USERS.'.loan_type',$loan_type);
		}
		$this->db->where(TBL_USERS.'.created_by',$dsaid);
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
		
		if($type=="incomplete"){
			$this->db->order_by(TBL_USERS.'.created_at','DESC');
		}elseif($type=="received"){
			$this->db->order_by(TBL_USERS.'.received_time','DESC');
		}elseif($type=="assigned"){
			$this->db->order_by(TBL_USERS.'.assigned_time','DESC');
		}elseif($type=="logged"){
			$this->db->order_by(TBL_LENDER_ASSIGN.'.logged_time','DESC');
		}elseif($type=="short_close"){
			$this->db->order_by(TBL_USERS.'.short_close_time','DESC');
		}elseif($type=="pending"){
			$this->db->order_by(TBL_LENDER_ASSIGN.'.pending_time','DESC');
		}elseif($type=="approved"){
			$this->db->order_by(TBL_LENDER_ASSIGN.'.approved_time','DESC');
		}elseif($type=="rejected"){
			$this->db->order_by(TBL_LENDER_ASSIGN.'.reject_time','DESC');
		}elseif($type=="disbursed"){
			$this->db->order_by(TBL_LENDER_ASSIGN.'.disbursed_time','DESC');
		}else{
			$this->db->order_by(TBL_USERS.'.updated_at','DESC');
		}
		
		$this->db->limit($limit,$offset);
		return $this->db->get()->result();
	}
}