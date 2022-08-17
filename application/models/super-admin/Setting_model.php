<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting_model extends CI_Model {
    public function CountCityList($keyword){
        $this->db->join('states','states.id=cities.state_id','LEFT');
        if(!empty($keyword)){
            $this->db->group_start();
                $this->db->like('states.name',$keyword);
                $this->db->or_like('cities.name',$keyword);
            $this->db->group_end();
        }
        return $this->db->count_all_results('cities');
    }
    public function CityList($limit,$offset,$keyword){
        $this->db->select('states.name as statename,cities.name,cities.id');
        $this->db->from('cities');
        $this->db->join('states','states.id=cities.state_id','LEFT');
        if(!empty($keyword)){
            $this->db->group_start();
                $this->db->like('states.name',$keyword);
                $this->db->or_like('cities.name',$keyword);
            $this->db->group_end();
        }
        $this->db->limit($limit,$offset);
        return $this->db->get()->result();
    }
    public function CountPincodeList($keyword){
        $this->db->join('states','states.id=pincode.state_id','LEFT');
        if(!empty($keyword)){
            $this->db->group_start();
                $this->db->like('pincode.pincode',$keyword);
                $this->db->or_like('pincode.city',$keyword);
                $this->db->or_like('states.name',$keyword);
            $this->db->group_end();
        }
        return $this->db->count_all_results('pincode');
    }
    public function PincodeList($limit,$offset,$keyword){
        $this->db->select('pincode.*,states.name as statename');
        $this->db->from('pincode');
        $this->db->join('states','states.id=pincode.state_id','LEFT');
        if(!empty($keyword)){
            $this->db->group_start();
                $this->db->like('pincode.pincode',$keyword);
                $this->db->or_like('pincode.city',$keyword);
                $this->db->or_like('states.name',$keyword);
            $this->db->group_end();
        }
        $this->db->limit($limit,$offset);
        return $this->db->get()->result();
    }
}