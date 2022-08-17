<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Common_model extends CI_Model {
    public function GetResult($table,$where=array(),$field="*"){
		$this->db->select($field);
		$this->db->from($table);
		if(!empty($where)){
			$this->db->where($where);
		}
		return $this->db->get()->result();
	}
	public function GetRow($table,$where=array(),$field="*"){
		$this->db->select($field);
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->get()->row();
	}
	public function GetOrderByRow($table,$orderBy,$where=array()){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($orderBy[0],$orderBy[1]);
		return $this->db->get()->row();
	}
	public function GetOrderByResult($table,$orderBy,$where=array(),$field="*"){
		$this->db->select($field);
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($orderBy[0],$orderBy[1]);
		return $this->db->get()->result();
	}
	public function GetWhereIn($table,$where,$in,$field="*"){
		$this->db->select($field);
		$this->db->from($table);
		$this->db->where_in($where,$in);
		return $this->db->get()->result();
	}
	public function GetWhereWithIn($table,$where,$where_text,$in,$field="*"){
		$this->db->select($field);
		$this->db->from($table);
		$this->db->where($where);
		if(!empty($in)){
			$this->db->where_in($where_text,$in);
		}
		return $this->db->get()->result();
	}
	public function CountResults($table,$where=array()){
		if(!empty($where)){
			$this->db->where($where);
		}
		return $this->db->count_all_results($table);
	}
	public function DeleteData($table,$where){
		$this->db->where($where);
		return  $this->db->delete($table);
	}
	public function InsertBatch($table,$data){
		return  $this->db->insert_batch($table,$data);
	}
	public function InsertData($table,$data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	public function UpdateData($table,$data,$where){
		$this->db->where($where);
	return  $this->db->update($table,$data);
		    
	}
	public function UpdateWhereIn($table,$data,$where,$in){
		$this->db->where_in($where,$in);
		return  $this->db->update($table,$data);
	}
	public function GetActiveCases($where){
		if(!empty($where)){
			$this->db->where($where);
		}
		$this->db->group_start();
			$this->db->where('status','LOGGED');
			$this->db->or_where('status','PENDING');
		$this->db->group_end();
		return $this->db->count_all_results(TBL_LENDER_ASSIGN);
	}
	public function GetDisbursed($table,$where,$partnerpermission=[]){
		$this->db->select('SUM(disbursed_amount) as disbursed_amount');
		$this->db->from($table);
		if(!empty($where)){
			$this->db->where($where);
		}
		if(!empty($partnerpermission)){
			$this->db->where_in(TBL_USERS.'.created_by',$partnerpermission);
		}
		return $this->db->get()->row();
	}
	public function CountReceivedCase($where=[],$partnerpermission=[]){
		$this->db->group_start();
		if(!empty($where)){
			$this->db->where($where);
		}
		$this->db->where('user_type','MERCHANT');
		$this->db->where('status',null);
		if(!empty($partnerpermission)){
			$this->db->where_in(TBL_USERS.'.created_by',$partnerpermission);
		}
		$this->db->group_end();
		$this->db->where('NOT EXISTS (SELECT * FROM user_lender_assign WHERE user_lender_assign.merchant_id='.TBL_USERS.'.user_id)', '', FALSE);
		return $this->db->count_all_results(TBL_USERS);
	}
	public function CountIncompleteCase($where=[],$partnerpermission=[]){
		$this->db->group_start();
		if(!empty($where)){
			$this->db->where($where);
		}
		$this->db->where('user_type','MERCHANT');
		$this->db->where('status','INCOMPLETE');
		$this->db->group_end();
		$this->db->where('NOT EXISTS (SELECT * FROM user_lender_assign WHERE user_lender_assign.merchant_id='.TBL_USERS.'.user_id)', '', FALSE);
		if(!empty($partnerpermission)){
			$this->db->where_in(TBL_USERS.'.created_by',$partnerpermission);
		}
		return $this->db->count_all_results(TBL_USERS);
	}
	public function GetStatusCount($where,$partnerpermission=[]){
		$this->db->select(TBL_LENDER_ASSIGN.'.id');
		$this->db->from(TBL_LENDER_ASSIGN);
		$this->db->join(TBL_USERS,TBL_USERS.'.user_id='.TBL_LENDER_ASSIGN.'.merchant_id','INNER');
		$this->db->group_start();
		if(!empty($where)){
			$this->db->where($where);
		}
		if(!empty($partnerpermission)){
			$this->db->where_in(TBL_USERS.'.created_by',$partnerpermission);
		}
		$this->db->group_end();
		$this->db->group_by(TBL_USERS.'.user_id');
		return $this->db->count_all_results();
	}
	public function GetUserCountsForLender($lenderId,$where=array()){
		$this->db->select(TBL_LENDER_ASSIGN.'.id');
		$this->db->from(TBL_LENDER_ASSIGN);
		$this->db->join(TBL_USERS,TBL_USERS.'.user_id='.TBL_LENDER_ASSIGN.'.merchant_id','INNER');
		$this->db->group_start();
		$this->db->where(TBL_LENDER_ASSIGN.'.lender_id',$lenderId);
		if(!empty($where)){
			$this->db->where($where);
		}
		$this->db->group_end();
		return $this->db->count_all_results();
	}
}