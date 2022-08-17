<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Merchant_model extends CI_Model {
	public function CountMerchantList($keyword,$type,$date_range,$loan_type,$dsaid,$record_type,$remark,$incomplete_status){
		$partnerpermission= PartnerPermission();
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,lender.company_name as lender_companyname";
		$this->db->select(TBL_USERS.'.user_id,dsa.company_name as dsa_name'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_USERS.' as dsa','dsa.user_id='.TBL_USERS.'.created_by','LEFT');
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.'.merchant_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join(TBL_USERS.' as lender','lender.user_id='.TBL_LENDER_ASSIGN.'.lender_id','LEFT');
		if($incomplete_status){
		    	$this->db->where(TBL_USERS.'.incomplete_status',$incomplete_status);
		}
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
		if(!empty($dsaid)){
			$this->db->where(TBL_USERS.'.created_by',$dsaid);
		}
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
		if(!empty($partnerpermission)){
			$this->db->where_in(TBL_USERS.'.created_by',$partnerpermission);
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
	public function MerchantList($limit,$offset,$keyword,$type,$date_range,$loan_type,$dsaid,$order_by="",$record_type,$remark,$incomplete_status){
		$partnerpermission= PartnerPermission();
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,lender.company_name as lender_companyname,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount";
		
		$this->db->select(TBL_USERS.'.*,dsa.company_name as dsa_name,dsa.file_id as dsa_id,'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_USERS.' as dsa','dsa.user_id='.TBL_USERS.'.created_by','LEFT');
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.'.merchant_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join(TBL_USERS.' as lender','lender.user_id='.TBL_LENDER_ASSIGN.'.lender_id','LEFT');
		if($incomplete_status){
		    	$this->db->where(TBL_USERS.'.incomplete_status',$incomplete_status);
		}
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

		if(!empty($dsaid)){
			$this->db->where(TBL_USERS.'.created_by',$dsaid);
		}
		if(!empty($partnerpermission)){
			$this->db->where_in(TBL_USERS.'.created_by',$partnerpermission);
		}
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
	    $this->db->select(TBL_USERS.'.full_name,mobile_number,email,age,company_name,created_by,file_id,case_status,status,loan_type,created_at,'.TBL_USER_DETAIL.'.*,IFNULL('.TBL_USER_DETAIL.'.user_id,'.TBL_USERS.'.user_id) as user_id,received_time,total_assigned,total_reject');
	    $this->db->from(TBL_USERS);
	    $this->db->join(TBL_USER_DETAIL,TBL_USER_DETAIL.'.user_id='.TBL_USERS.'.user_id','LEFT');
	    $this->db->where(TBL_USERS.'.user_id',$user_id);
		$data= $this->db->get()->row();
		$data->partner=$this->common_model->GetResult(TBL_USER_PARTNER,['user_id'=>$user_id]);
		$data->applicant=$this->common_model->GetResult(TBL_USER_COAPPLICANT,['user_id'=>$user_id]);
		if(!empty($data->created_by)){
			$data->dsa=$this->common_model->GetRow(TBL_USERS,['user_id'=>$data->created_by]);
		}else{
			$data->dsa=[];
		}
		$data->assign=$this->common_model->GetRow(TBL_LENDER_ASSIGN,['merchant_id'=>$data->user_id]);
		return $data;
	}
	public function GetUserDetail2($user_id){
	    $this->db->select(TBL_USERS.'.mobile_number,email,age,company_name,created_by,file_id,case_status,status,loan_type,created_at,user_detail.*,IFNULL(user_detail.user_id,'.TBL_USERS.'.user_id) as user_id,'.TBL_USERS.'.full_name,received_time,total_assigned,total_reject');
	    $this->db->from(TBL_USERS);
	    $this->db->join('user_detail','user_detail.user_id='.TBL_USERS.'.user_id','LEFT');
	    $this->db->where(TBL_USERS.'.user_id',$user_id);
		$data= $this->db->get()->row();
		if(!empty($data->created_by)){
			$data->dsa=$this->common_model->GetRow(TBL_USERS,['user_id'=>$data->created_by]);
		}else{
			$data->dsa=[];
		}
		$data->assign=$this->common_model->GetRow(TBL_LENDER_ASSIGN,['merchant_id'=>$data->user_id]);
		return $data;
	}
	public function GetMerchantResult($user_id){
	    $this->db->select(TBL_USERS.'.full_name,mobile_number,email,age,company_name,created_by,file_id,status,'.TBL_USERS.'.created_at,loan_type,'.TBL_USER_DETAIL.'.*,IFNULL('.TBL_USER_DETAIL.'.user_id,'.TBL_USERS.'.user_id) as user_id,received_time,short_close_time,assigned_time');
	    $this->db->from(TBL_USERS);
	    $this->db->join(TBL_USER_DETAIL,TBL_USER_DETAIL.'.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		if(!empty($user_id)){
			$this->db->where(TBL_USERS.'.user_id',$user_id);
		}
	    return $this->db->get()->result();
	}
	public function GetMerchantResult2($user_id){
	    $this->db->select(TBL_USERS.'.full_name,mobile_number,email,age,company_name,created_by,file_id,status,'.TBL_USERS.'.created_at,loan_type,user_detail.*,IFNULL(user_detail.user_id,'.TBL_USERS.'.user_id) as user_id,received_time,short_close_time,assigned_time');
	    $this->db->from(TBL_USERS);
	    $this->db->join('user_detail','user_detail.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		if(!empty($user_id)){
			$this->db->where(TBL_USERS.'.user_id',$user_id);
		}
	    return $this->db->get()->result();
	}
	public function GetExportFilter($filter,$partnerpermission=[]){
		$filter=(object)$filter;
		$from_date="";
		$to_date="";
		if(!empty($filter->rangepicker)){
			$explode=explode(' - ',$filter->rangepicker);
			$from_date=$explode[0];
			$to_date=end($explode);
		}
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,lender.company_name as lender_companyname,lender.file_id as lender_file_id,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,
			detail.*,detail.pan_number,IFNULL(detail.user_id,".TBL_USERS.".user_id) as user_id";
		
		$this->db->select(TBL_USERS.'.*,dsa.company_name as dsa_name,dsa.file_id as dsa_id,'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_USERS.' as dsa','dsa.user_id='.TBL_USERS.'.created_by','LEFT');
		$this->db->join(TBL_USER_DETAIL.' as detail','detail.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.'.merchant_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join(TBL_USERS.' as lender','lender.user_id='.TBL_LENDER_ASSIGN.'.lender_id','LEFT');
		$this->db->where(TBL_USERS.'.loan_type','Business');
		if(!empty($filter->lender_id)){
			$this->db->where('user_lender_assign.lender_id',$filter->lender_id);
		}
		if(!empty($filter->status) && $filter->status!='ALL'){
			if($filter->status=='INCOMPLETE'){
				$this->db->where(TBL_USERS.'.status','INCOMPLETE');
			}elseif($filter->status=='RECEIVED'){
				$this->db->where(TBL_USERS.'.status',null);
				$this->db->where('NOT EXISTS (SELECT * FROM user_lender_assign WHERE user_lender_assign.merchant_id='.TBL_USERS.'.user_id)', '', FALSE);
			}elseif($filter->status=='ASSIGNED'){
				$this->db->where('user_lender_assign.status','ASSIGNED');
			}elseif($filter->status=='LOGGED'){
				$this->db->where('user_lender_assign.status','LOGGED');
			}elseif($filter->status=='PENDING'){
				$this->db->where('user_lender_assign.status','PENDING');
			}elseif($filter->status=='APPROVED'){
				$this->db->where('user_lender_assign.status','APPROVED');
			}elseif($filter->status=='REJECTED'){
				$this->db->where('user_lender_assign.status','REJECTED');
			}elseif($filter->status=='DISBURSED'){
				$this->db->where('user_lender_assign.status','DISBURSED');
			}elseif($filter->status=='SHORTCLOSE'){
				$this->db->where('user_lender_assign.status','SHORTCLOSE');
			}

		}
		if(!empty($from_date) && !empty($to_date)){
			$this->db->where(['DATE('.TBL_USERS.'.created_at)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_USERS.'.created_at)<='=>date('Y-m-d',strtotime($to_date))]);
		}
		if(!empty($partnerpermission)){
			$this->db->where_in(TBL_USERS.'.created_by',$partnerpermission);
		}
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		if(!empty($filter->dsa_id)){
			$this->db->where(TBL_USERS.'.created_by',$filter->dsa_id);
		}
		return $this->db->get()->result();
	}
	public function GetExportFilter2($filter,$partnerpermission=[]){
		$filter=(object)$filter;
		$from_date="";
		$to_date="";
		if(!empty($filter->rangepicker)){
			$explode=explode(' - ',$filter->rangepicker);
			$from_date=$explode[0];
			$to_date=end($explode);
		}
		$select=",".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,lender.company_name as lender_companyname,lender.file_id as lender_file_id,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,
			detail.*,detail.pan_number,IFNULL(detail.user_id,".TBL_USERS.".user_id) as user_id,".TBL_USERS.".full_name";
		
		$this->db->select(TBL_USERS.'.*,dsa.company_name as dsa_name,dsa.file_id as dsa_id,'.$select);
		$this->db->from(TBL_USERS);
		$this->db->join(TBL_USERS.' as dsa','dsa.user_id='.TBL_USERS.'.created_by','LEFT');
		$this->db->join('user_detail as detail','detail.user_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join(TBL_LENDER_ASSIGN,TBL_LENDER_ASSIGN.'.merchant_id='.TBL_USERS.'.user_id','LEFT');
		$this->db->join(TBL_USERS.' as lender','lender.user_id='.TBL_LENDER_ASSIGN.'.lender_id','LEFT');
		if(!empty($filter->lender_id)){
			$this->db->where('user_lender_assign.lender_id',$filter->lender_id);
		}
		$this->db->where(TBL_USERS.'.loan_type','Salaried');
		if(!empty($filter->status) && $filter->status!='ALL'){
			if($filter->status=='INCOMPLETE'){
				$this->db->where(TBL_USERS.'.status','INCOMPLETE');
			}elseif($filter->status=='RECEIVED'){
				$this->db->where(TBL_USERS.'.status',null);
				$this->db->where('NOT EXISTS (SELECT * FROM user_lender_assign WHERE user_lender_assign.merchant_id='.TBL_USERS.'.user_id)', '', FALSE);
			}elseif($filter->status=='ASSIGNED'){
				$this->db->where('user_lender_assign.status','ASSIGNED');
			}elseif($filter->status=='LOGGED'){
				$this->db->where('user_lender_assign.status','LOGGED');
			}elseif($filter->status=='PENDING'){
				$this->db->where('user_lender_assign.status','PENDING');
			}elseif($filter->status=='APPROVED'){
				$this->db->where('user_lender_assign.status','APPROVED');
			}elseif($filter->status=='REJECTED'){
				$this->db->where('user_lender_assign.status','REJECTED');
			}elseif($filter->status=='DISBURSED'){
				$this->db->where('user_lender_assign.status','DISBURSED');
			}elseif($filter->status=='SHORTCLOSE'){
				$this->db->where('user_lender_assign.status','SHORTCLOSE');
			}

		}
		if(!empty($from_date) && !empty($to_date)){
			$this->db->where(['DATE('.TBL_USERS.'.created_at)>='=>date('Y-m-d',strtotime($from_date)),'DATE('.TBL_USERS.'.created_at)<='=>date('Y-m-d',strtotime($to_date))]);
		}
		if(!empty($partnerpermission)){
			$this->db->where_in(TBL_USERS.'.created_by',$partnerpermission);
		}
		$this->db->where(TBL_USERS.'.user_type','MERCHANT');
		if(!empty($filter->dsa_id)){
			$this->db->where(TBL_USERS.'.created_by',$filter->dsa_id);
		}
		return $this->db->get()->result();
	}
	public function GetLenderList($keyword){
		$this->db->select('*');
		$this->db->from(TBL_USERS);
		$this->db->where('user_type','LENDERS');
		if(!empty($keyword)){
			$this->db->group_start();
				$this->db->like('full_name',$keyword);
				$this->db->or_like('company_name',$keyword);
				$this->db->or_like('email',$keyword);
				$this->db->or_like('mobile_number',$keyword);
			$this->db->group_end();
		}
		return $this->db->get()->result();
	}
	public function GetAssignedLender($user_id){
		$this->db->select(TBL_USERS.'.full_name,company_name,'.TBL_LENDER_ASSIGN.'.status');
		$this->db->from(TBL_LENDER_ASSIGN);
		$this->db->join(TBL_USERS,TBL_USERS.'.user_id='.TBL_LENDER_ASSIGN.'.lender_id','LEFT');
		$this->db->where(TBL_LENDER_ASSIGN.'.merchant_id',$user_id);
		return $this->db->get()->row();
		
	}
	public function GetMultipleAssignedLender($user_id){
		$this->db->select(TBL_USERS.'.full_name,company_name,user_id as lender_id,'.TBL_LENDER_ASSIGN.'.status,'.TBL_LENDER_ASSIGN.'.disbursed_amount');
		$this->db->from(TBL_LENDER_ASSIGN);
		$this->db->join(TBL_USERS,TBL_USERS.'.user_id='.TBL_LENDER_ASSIGN.'.lender_id','LEFT');
		$this->db->where(TBL_LENDER_ASSIGN.'.merchant_id',$user_id);
		return $this->db->get()->result();
		
	}
	public function GetComments($merchant_id){
		$this->db->select('comments.*,'.TBL_USERS.'.company_name');
		$this->db->from('comments');
		$this->db->join(TBL_USERS,TBL_USERS.'.user_id=comments.comment_by','INNER');
		$this->db->where('comments.merchant_id',$merchant_id);
		return $this->db->get()->result();
	}
	public function GetLenderComments($merchant_id){
		$this->db->select('user_lender_comment.*,'.TBL_USERS.'.company_name');
		$this->db->from('user_lender_comment');
		$this->db->join(TBL_USERS,TBL_USERS.'.user_id=user_lender_comment.lender_id','INNER');
		$this->db->where('user_lender_comment.merchant_id',$merchant_id);
		return $this->db->get()->result();
	}
	public function GetLender($user_id){
        $this->db->select('user_lender_assign.*,users.company_name as lender_name');
        $this->db->from('user_lender_assign');
        $this->db->join('users','users.user_id=user_lender_assign.lender_id','INNER');
        $this->db->where('user_lender_assign.merchant_id',$user_id);
        return $this->db->get()->result();
    }
    public function GetIncompleteStatus(){
		$query = $this->db->get('incomplete_status');  
        return $query; 
	}
}