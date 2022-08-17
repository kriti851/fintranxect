<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Query_builder_model extends CI_Model{
    public function Get($limit,$offset,$query){
        $query=$query." LIMIT ".$limit." OFFSET ".$offset;
        return $this->db->query($query)->result();
    }
    public function GetLender($user_id){
        $this->db->select('user_lender_assign.*,users.company_name as lender_name');
        $this->db->from('user_lender_assign');
        $this->db->join('users','users.user_id=user_lender_assign.lender_id','INNER');
        $this->db->where('user_lender_assign.merchant_id',$user_id);
        return $this->db->get()->result();
    }
    public function GetRecord($query){
        return $this->db->query($query)->result();
    }
}