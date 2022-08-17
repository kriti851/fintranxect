<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile_model extends CI_Model {
	public function GetUserDetail($user_id){
	    $this->db->select(TBL_USERS.'.full_name,mobile_number,email,gst_number,pan_number,age,company_name,'.TBL_USER_DETAIL.'.*');
	    $this->db->from(TBL_USERS);
	    $this->db->join(TBL_USER_DETAIL,TBL_USER_DETAIL.'.user_id='.TBL_USERS.'.user_id','LEFT');
	    $this->db->where(TBL_USERS.'.user_id',$user_id);
		$data= $this->db->get()->row();
		$data->partner=$this->common_model->GetResult(TBL_USER_PARTNER,['user_id'=>$user_id]);
		$data->applicant=$this->common_model->GetResult(TBL_USER_COAPPLICANT,['user_id'=>$user_id]);
		return $data;
	}

}