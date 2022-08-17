<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile_model extends CI_Model {
   
    public function GetPermissionList(){
        $data = $this->db->get('permission')->result();
        foreach($data as $key=>$row){
            $data[$key]->sub_permission=$this->db->get_where('sub_permission',['permission_id'=>$row->id])->result();
        }
        return $data;
    }
    
}