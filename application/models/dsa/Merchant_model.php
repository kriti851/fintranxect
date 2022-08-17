<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Merchant_model extends CI_Model {
    public function CountMerchantList($keyword,$type,$date_range,$loan_type,$record_type){
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,lender.company_name as lender_companyname";
		$this->db->select(TBL_USERS.'.user_id,'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.".id=(SELECT id FROM user_lender_assign LEFT JOIN users as otheruser ON otheruser.user_id=user_lender_assign.merchant_id WHERE user_lender_assign.merchant_id=users.user_id order by (CASE WHEN user_lender_assign.disbursed_time IS NOT NULL THEN 6 WHEN user_lender_assign.approved_time IS NOT NULL THEN 5 WHEN user_lender_assign.pending_time IS NOT NULL THEN 4 WHEN user_lender_assign.logged_time IS NOT NULL THEN 3 WHEN otheruser.assigned_time IS NOT NULL THEN 2 WHEN user_lender_assign.reject_time IS NOT NULL THEN 0 ELSE 1 END) DESC LIMIT 1)",'LEFT');
		$this->db->join(TBL_USERS.' as lender','lender.user_id='.TBL_LENDER_ASSIGN.'.lender_id','LEFT');
		if($type=='short_close'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','SHORTCLOSE');
		}elseif($type=='incomplete'){
			$this->db->where(TBL_USERS.'.status','INCOMPLETE');
			$this->db->where('NOT EXISTS (SELECT * FROM user_lender_assign WHERE user_lender_assign.merchant_id='.TBL_USERS.'.user_id)', '', FALSE);
		}elseif($type=='received'){
			$this->db->where(TBL_USERS.'.status',NULL);
			$this->db->where('NOT EXISTS (SELECT * FROM user_lender_assign WHERE user_lender_assign.merchant_id='.TBL_USERS.'.user_id)', '', FALSE);
		}elseif($type=='assigned'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','ASSIGNED');
		}elseif($type=='logged'){
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
		$this->db->where(TBL_USERS.'.created_by',$this->session->userdata('user_id'));
		
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
	public function MerchantList($limit,$offset,$keyword,$type,$date_range,$loan_type,$order_by="",$record_type){
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,lender.company_name as lender_companyname,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount";
		
		$this->db->select(TBL_USERS.'.*'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.".id=(SELECT id FROM user_lender_assign LEFT JOIN users as otheruser ON otheruser.user_id=user_lender_assign.merchant_id WHERE user_lender_assign.merchant_id=users.user_id order by (CASE WHEN user_lender_assign.disbursed_time IS NOT NULL THEN 6 WHEN user_lender_assign.approved_time IS NOT NULL THEN 5 WHEN user_lender_assign.pending_time IS NOT NULL THEN 4 WHEN user_lender_assign.logged_time IS NOT NULL THEN 3 WHEN otheruser.assigned_time IS NOT NULL THEN 2 WHEN user_lender_assign.reject_time IS NOT NULL THEN 0 ELSE 1 END) DESC LIMIT 1)",'LEFT');
		$this->db->join(TBL_USERS.' as lender','lender.user_id='.TBL_LENDER_ASSIGN.'.lender_id','LEFT');
		if($type=='short_close'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','SHORTCLOSE');
		}elseif($type=='incomplete'){
			$this->db->where(TBL_USERS.'.status','INCOMPLETE');
			$this->db->where('NOT EXISTS (SELECT * FROM user_lender_assign WHERE user_lender_assign.merchant_id='.TBL_USERS.'.user_id)', '', FALSE);
		}elseif($type=='received'){
			$this->db->where(TBL_USERS.'.status',NULL);
			$this->db->where('NOT EXISTS (SELECT * FROM user_lender_assign WHERE user_lender_assign.merchant_id='.TBL_USERS.'.user_id)', '', FALSE);
		}elseif($type=='assigned'){
			$this->db->where(TBL_LENDER_ASSIGN.'.status','ASSIGNED');
		}elseif($type=='logged'){
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
		$this->db->where(TBL_USERS.'.created_by',$this->session->userdata('user_id'));
	
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
		if(!empty($order_by) && $order_by!="Update"){
			if($order_by=='Comment'){
				$this->db->order_by(TBL_USERS.'.comment_time','DESC');
			}elseif($order_by=='Status'){
				if($type=="incomplete"){
					$this->db->order_by(TBL_USERS.'.created_at','DESC');
				}elseif($type=="assigned"){
					$this->db->order_by(TBL_USERS.'.assigned_time','DESC');
				}elseif($type=="received"){
					$this->db->order_by(TBL_USERS.'.received_time','DESC');
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
			}
		}else{
			$this->db->order_by(TBL_USERS.'.updated_at','DESC');
		}
		$this->db->group_by(TBL_USERS.'.user_id');
		$this->db->limit($limit,$offset);
		return $this->db->get()->result();
	}
	public function GetUserDetail($user_id){
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,"
			.TBL_USER_DETAIL.".*,IFNULL(".TBL_USER_DETAIL.".user_id,".TBL_USERS.".user_id) as user_id,".TBL_LENDER_ASSIGN.".disbursed_amount";
		
		$this->db->select(TBL_USERS.'.*'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_USER_DETAIL,TBL_USER_DETAIL.'.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.".id=(SELECT id FROM user_lender_assign LEFT JOIN users as otheruser ON otheruser.user_id=user_lender_assign.merchant_id WHERE user_lender_assign.merchant_id=users.user_id order by (CASE WHEN user_lender_assign.disbursed_time IS NOT NULL THEN 6 WHEN user_lender_assign.approved_time IS NOT NULL THEN 5 WHEN user_lender_assign.pending_time IS NOT NULL THEN 4 WHEN user_lender_assign.logged_time IS NOT NULL THEN 3 WHEN otheruser.assigned_time IS NOT NULL THEN 2 WHEN user_lender_assign.reject_time IS NOT NULL THEN 0 ELSE 1 END) DESC LIMIT 1)",'LEFT');
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		$this->db->where(TBL_USERS.'.user_id',$user_id);
		$this->db->where(TBL_USERS.'.created_by',$this->session->userdata('user_id'));
		$data= $this->db->get()->row();
		$data->partner=$this->common_model->GetResult(TBL_USER_PARTNER,['user_id'=>$user_id]);
		$data->applicant=$this->common_model->GetResult(TBL_USER_COAPPLICANT,['user_id'=>$user_id]);
		return $data;
	}
	public function GetUserDetail2($user_id){
	    $select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,"
			."user_detail.*,IFNULL(user_detail.user_id,".TBL_USERS.".user_id) as user_id,".TBL_LENDER_ASSIGN.".disbursed_amount";
		
		$this->db->select(TBL_USERS.'.*'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join('user_detail','user_detail.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.".id=(SELECT id FROM user_lender_assign LEFT JOIN users as otheruser ON otheruser.user_id=user_lender_assign.merchant_id WHERE user_lender_assign.merchant_id=users.user_id order by (CASE WHEN user_lender_assign.disbursed_time IS NOT NULL THEN 6 WHEN user_lender_assign.approved_time IS NOT NULL THEN 5 WHEN user_lender_assign.pending_time IS NOT NULL THEN 4 WHEN user_lender_assign.logged_time IS NOT NULL THEN 3 WHEN otheruser.assigned_time IS NOT NULL THEN 2 WHEN user_lender_assign.reject_time IS NOT NULL THEN 0 ELSE 1 END) DESC LIMIT 1)",'LEFT');
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		$this->db->where(TBL_USERS.'.user_id',$user_id);
		$this->db->where(TBL_USERS.'.created_by',$this->session->userdata('user_id'));
		$data= $this->db->get()->row();
		return $data;
	}
	public function GetMerchantResult($user_id){
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,
			detail.*,detail.pan_number,IFNULL(detail.user_id,".TBL_USERS.".user_id) as user_id";

		$this->db->select(TBL_USERS.'.*'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.".id=(SELECT id FROM user_lender_assign LEFT JOIN users as otheruser ON otheruser.user_id=user_lender_assign.merchant_id WHERE user_lender_assign.merchant_id=users.user_id order by (CASE WHEN user_lender_assign.disbursed_time IS NOT NULL THEN 6 WHEN user_lender_assign.approved_time IS NOT NULL THEN 5 WHEN user_lender_assign.pending_time IS NOT NULL THEN 4 WHEN user_lender_assign.logged_time IS NOT NULL THEN 3 WHEN otheruser.assigned_time IS NOT NULL THEN 2 WHEN user_lender_assign.reject_time IS NOT NULL THEN 0 ELSE 1 END) DESC LIMIT 1)",'LEFT');
		$this->db->join(TBL_USER_DETAIL.' as detail','detail.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		$this->db->where(TBL_USERS.'.user_id',$user_id);
		$this->db->group_by(TBL_USERS.'.user_id');
		return $this->db->get()->result();
	}
	public function GetMerchantResult2($user_id){
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,
			detail.*,detail.pan_number,IFNULL(detail.user_id,".TBL_USERS.".user_id) as user_id,".TBL_USERS.".full_name";
		$this->db->select(TBL_USERS.'.*'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.".id=(SELECT id FROM user_lender_assign LEFT JOIN users as otheruser ON otheruser.user_id=user_lender_assign.merchant_id WHERE user_lender_assign.merchant_id=users.user_id order by (CASE WHEN user_lender_assign.disbursed_time IS NOT NULL THEN 6 WHEN user_lender_assign.approved_time IS NOT NULL THEN 5 WHEN user_lender_assign.pending_time IS NOT NULL THEN 4 WHEN user_lender_assign.logged_time IS NOT NULL THEN 3 WHEN otheruser.assigned_time IS NOT NULL THEN 2 WHEN user_lender_assign.reject_time IS NOT NULL THEN 0 ELSE 1 END) DESC LIMIT 1)",'LEFT');
		$this->db->join('user_detail as detail','detail.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		$this->db->where(TBL_USERS.'.user_id',$user_id);
		$this->db->group_by(TBL_USERS.'.user_id');
		return $this->db->get()->result();
	}
	public function GetComments($merchant_id){
		$this->db->select('*');
		$this->db->from('comments');
		$this->db->where('merchant_id',$merchant_id);
		$this->db->where('comment_for','PARTNER');
		$this->db->where('comment_by',$this->session->userdata('user_id'));
		return $this->db->get()->result();
	}
	public function GetExportFilter($filter){
		$filter=(object)$filter;
		$from_date="";
		$to_date="";
		if(!empty($filter->rangepicker)){
			$explode=explode(' - ',$filter->rangepicker);
			$from_date=$explode[0];
			$to_date=end($explode);
		}
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,
			detail.*,detail.pan_number,IFNULL(detail.user_id,".TBL_USERS.".user_id) as user_id";

		$this->db->select(TBL_USERS.'.*'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.".id=(SELECT id FROM user_lender_assign LEFT JOIN users as otheruser ON otheruser.user_id=user_lender_assign.merchant_id WHERE user_lender_assign.merchant_id=users.user_id order by (CASE WHEN user_lender_assign.disbursed_time IS NOT NULL THEN 6 WHEN user_lender_assign.approved_time IS NOT NULL THEN 5 WHEN user_lender_assign.pending_time IS NOT NULL THEN 4 WHEN user_lender_assign.logged_time IS NOT NULL THEN 3 WHEN otheruser.assigned_time IS NOT NULL THEN 2 WHEN user_lender_assign.reject_time IS NOT NULL THEN 0 ELSE 1 END) DESC LIMIT 1)",'LEFT');
		$this->db->join(TBL_USER_DETAIL.' as detail','detail.user_id='.TBL_USERS.'.user_id','LEFT');
		if(!empty($filter->status) && $filter->status!='ALL'){
			if($filter->status=='SHORTCLOSE'){
				$this->db->where(TBL_LENDER_ASSIGN.'.status','SHORTCLOSE');
			}elseif($filter->status=='INCOMPLETE'){
				$this->db->where(TBL_USERS.'.status','INCOMPLETE');
				$this->db->where('NOT EXISTS (SELECT * FROM user_lender_assign WHERE user_lender_assign.merchant_id='.TBL_USERS.'.user_id)', '', FALSE);
			}elseif($filter->status=='RECEIVED'){
				$this->db->where(TBL_USERS.'.status',NULL);
				$this->db->where('NOT EXISTS (SELECT * FROM user_lender_assign WHERE user_lender_assign.merchant_id='.TBL_USERS.'.user_id)', '', FALSE);
			}elseif($filter->status=='ASSIGNED'){
				$this->db->where(TBL_LENDER_ASSIGN.'.status','ASSIGNED');
			}elseif($filter->status=='LOGGED'){
				$this->db->where(TBL_LENDER_ASSIGN.'.status','LOGGED');
			}elseif($filter->status=='PENDING'){
				$this->db->where(TBL_LENDER_ASSIGN.'.status','PENDING');
			}elseif($filter->status=='APPROVED'){
				$this->db->where(TBL_LENDER_ASSIGN.'.status','APPROVED');
			}elseif($filter->status=='REJECTED'){
				$this->db->where(TBL_LENDER_ASSIGN.'.status','REJECTED');
			}elseif($filter->status=='DISBURSED'){
				$this->db->where(TBL_LENDER_ASSIGN.'.status','DISBURSED');
			}
		}
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		$this->db->where(TBL_USERS.'.loan_type','Business');
		$this->db->where(TBL_USERS.'.created_by',$this->session->userdata('user_id'));
		$this->db->group_by(TBL_USERS.'.user_id');
		return $this->db->get()->result();
	}
	public function GetExportFilter2($filter){
		$filter=(object)$filter;
		$from_date="";
		$to_date="";
		if(!empty($filter->rangepicker)){
			$explode=explode(' - ',$filter->rangepicker);
			$from_date=$explode[0];
			$to_date=end($explode);
		}
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,
			detail.*,detail.pan_number,IFNULL(detail.user_id,".TBL_USERS.".user_id) as user_id,".TBL_USERS.".full_name";
		$this->db->select(TBL_USERS.'.*'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.".id=(SELECT id FROM user_lender_assign LEFT JOIN users as otheruser ON otheruser.user_id=user_lender_assign.merchant_id WHERE user_lender_assign.merchant_id=users.user_id order by (CASE WHEN user_lender_assign.disbursed_time IS NOT NULL THEN 6 WHEN user_lender_assign.approved_time IS NOT NULL THEN 5 WHEN user_lender_assign.pending_time IS NOT NULL THEN 4 WHEN user_lender_assign.logged_time IS NOT NULL THEN 3 WHEN otheruser.assigned_time IS NOT NULL THEN 2 WHEN user_lender_assign.reject_time IS NOT NULL THEN 0 ELSE 1 END) DESC LIMIT 1)",'LEFT');
		$this->db->join('user_detail as detail','detail.user_id='.TBL_USERS.'.user_id','LEFT');
		if(!empty($filter->status) && $filter->status!='ALL'){
			if($filter->status=='SHORTCLOSE'){
				$this->db->where(TBL_LENDER_ASSIGN.'.status','SHORTCLOSE');
			}elseif($filter->status=='INCOMPLETE'){
				$this->db->where(TBL_USERS.'.status','INCOMPLETE');
				$this->db->where('NOT EXISTS (SELECT * FROM user_lender_assign WHERE user_lender_assign.merchant_id='.TBL_USERS.'.user_id)', '', FALSE);
			}elseif($filter->status=='RECEIVED'){
				$this->db->where(TBL_USERS.'.status',NULL);
				$this->db->where('NOT EXISTS (SELECT * FROM user_lender_assign WHERE user_lender_assign.merchant_id='.TBL_USERS.'.user_id)', '', FALSE);
			}elseif($filter->status=='ASSIGNED'){
				$this->db->where(TBL_LENDER_ASSIGN.'.status','ASSIGNED');
			}elseif($filter->status=='LOGGED'){
				$this->db->where(TBL_LENDER_ASSIGN.'.status','LOGGED');
			}elseif($filter->status=='PENDING'){
				$this->db->where(TBL_LENDER_ASSIGN.'.status','PENDING');
			}elseif($filter->status=='APPROVED'){
				$this->db->where(TBL_LENDER_ASSIGN.'.status','APPROVED');
			}elseif($filter->status=='REJECTED'){
				$this->db->where(TBL_LENDER_ASSIGN.'.status','REJECTED');
			}elseif($filter->status=='DISBURSED'){
				$this->db->where(TBL_LENDER_ASSIGN.'.status','DISBURSED');
			}
		}
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		$this->db->where(TBL_USERS.'.loan_type','Salaried');
		$this->db->where(TBL_USERS.'.created_by',$this->session->userdata('user_id'));
		$this->db->group_by(TBL_USERS.'.user_id');
		return $this->db->get()->result();
	}
}