<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
        $this->load->helper('admin');
        isAdminLogin();
    }
    public function index(){
        $partnerpermission= PartnerPermission();
        $this->data['total_cases_']=$this->common_model->CountResults(TBL_USERS,['user_type'=>'MERCHANT']);
        $this->data['total_businessvolume_']=$this->common_model->GetDisbursed(TBL_LENDER_ASSIGN,['status'=>'DISBURSED']);
        $this->data['total_disbursed_']=$this->common_model->CountResults(TBL_LENDER_ASSIGN,['status'=>'DISBURSED']);
        $this->data['incomplete_current']=$this->common_model->CountIncompleteCase([],$partnerpermission);
        $this->data['shortclose_current']=$this->common_model->GetStatusCount([TBL_LENDER_ASSIGN.'.status'=>'SHORTCLOSE'],$partnerpermission);
        $this->data['received_total']=$this->common_model->CountReceivedCase([],$partnerpermission);
        $this->data['assigned_current']=$this->common_model->GetStatusCount([TBL_LENDER_ASSIGN.'.status'=>'ASSIGNED'],$partnerpermission);
        $this->data['logged_current']=$this->common_model->GetStatusCount([TBL_LENDER_ASSIGN.'.status'=>'LOGGED'],$partnerpermission);
        $this->data['pending_current']=$this->common_model->GetStatusCount([TBL_LENDER_ASSIGN.'.status'=>'PENDING'],$partnerpermission);
        $this->data['approved_current']=$this->common_model->GetStatusCount([TBL_LENDER_ASSIGN.'.status'=>'APPROVED'],$partnerpermission);
        $this->data['reject_current']=$this->common_model->GetStatusCount([TBL_LENDER_ASSIGN.'.status'=>'REJECTED'],$partnerpermission);
        $this->data['content']="dashboard/index";
        $this->load->view('super-admin',$this->data);
    }
}