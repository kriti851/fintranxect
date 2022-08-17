<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Newgrowth_model extends CI_Model {
    public function getdocuments($user_id){
        $this->db->select('*');
        $this->db->from('newgrowth_doctype');
        $docs= $this->db->get()->result();
        if($docs){
            foreach($docs as $key=>$doc){
               $uploaded=  $this->db->select('document_id')->from('newgrowth_documents')->where('user_id',$user_id)->where('type_id',$doc->id)->get()->row();
                if($uploaded){
                    $docs[$key]->document_id=$uploaded->document_id;
                }else{
                    $docs[$key]->document_id="";
                }
            }
        }
        return $docs;
    }
}