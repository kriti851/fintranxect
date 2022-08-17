<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Follow_up_model extends CI_Model {
    public function CountGetFollowUp($form_date,$to_date,$status,$partner,$partnerpermission){
        $this->db->select('remark.remark_id,'.TBL_USERS.'.full_name,'.TBL_USERS.'.file_id');
        $this->db->from('remark');
        $this->db->join(TBL_USERS,TBL_USERS.'.user_id=remark.merchant_id','LEFT');
        $this->db->where('DATE(remark.follow_up)>=',date('Y-m-d',strtotime($form_date)));
        $this->db->where('DATE(remark.follow_up)<=',date('Y-m-d',strtotime($to_date)));
        if($partner){
            $this->db->where(TBL_USERS.'.created_by',$partner);
        }
        if(!empty($partnerpermission)){
            $this->db->where_in(TBL_USERS.'.created_by',$partnerpermission);
        }
        if(!empty($status)){
            if($status=='Pending'){
                $this->db->group_start();
                    $this->db->where('resolved','NO');
                    $this->db->or_where('resolved',NULL);
                $this->db->group_end();
            }elseif($status=='Resolved'){
                $this->db->group_start();
                    $this->db->where('resolved','YES');
                $this->db->group_end();
            }
        }
        return $this->db->count_all_results();
    }
    public function GetFollowUp($limit,$offset,$form_date,$to_date,$status,$partner,$partnerpermission){
        $this->db->select('remark.*,'.TBL_USERS.'.full_name,'.TBL_USERS.'.file_id');
        $this->db->from('remark');
        $this->db->join(TBL_USERS,TBL_USERS.'.user_id=remark.merchant_id','LEFT');
        $this->db->where('DATE(remark.follow_up)>=',date('Y-m-d',strtotime($form_date)));
        $this->db->where('DATE(remark.follow_up)<=',date('Y-m-d',strtotime($to_date)));
        if($partner){
            $this->db->where(TBL_USERS.'.created_by',$partner);
        }
        if(!empty($partnerpermission)){
            $this->db->where_in(TBL_USERS.'.created_by',$partnerpermission);
        }
        if(!empty($status)){
            if($status=='Pending'){
                $this->db->group_start();
                    $this->db->where('resolved','NO');
                    $this->db->or_where('resolved',NULL);
                $this->db->group_end();
            }elseif($status=='Resolved'){
                $this->db->group_start();
                    $this->db->where('resolved','YES');
                $this->db->group_end();
            }
        }
        $this->db->limit($limit,$offset);
        return $this->db->get()->result();
    }
    public function GetCurrentFolloup(){
        $minute=(date('i')+1);
        $this->db->select('remark.*,'.TBL_USERS.'.full_name,'.TBL_USERS.'.file_id');
        $this->db->from('remark');
        $this->db->join(TBL_USERS,TBL_USERS.'.user_id=remark.merchant_id','LEFT');
        $this->db->where('DATE(remark.follow_up)',date('Y-m-d'));
        $this->db->where('HOUR(remark.follow_up)',date('H'));
        $this->db->where('MINUTE(remark.follow_up)',$minute);
        return $this->db->get()->row();
        echo $this->db->last_query();die;
    }
}