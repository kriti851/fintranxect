<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
        $this->load->helper('dsa');
        isDsaLogin();
       
    }
    public function index(){
        $userid=$this->session->userdata('user_id');
        $this->data['total_cases_in_year']=$this->common_model->CountResults(TBL_USERS,['user_type'=>'merchant','created_by'=>$userid]);
        $this->data['incomplete_current']=$this->common_model->CountIncompleteCase(['created_by'=>$userid]);

        $this->data['shortclose_current']=$this->common_model->GetStatusCount(['dsa_id'=>$userid,TBL_LENDER_ASSIGN.'.status'=>'SHORTCLOSE']);
        $this->data['received_total']=$this->common_model->CountReceivedCase(['created_by'=>$userid]);
        $this->data['assigned_current']=$this->common_model->GetStatusCount(['dsa_id'=>$userid,TBL_LENDER_ASSIGN.'.status'=>'ASSIGNED']);
        $this->data['logged_current']=$this->common_model->GetStatusCount(['dsa_id'=>$userid,TBL_LENDER_ASSIGN.'.status'=>'LOGGED']);
        $this->data['pending_current']=$this->common_model->GetStatusCount(['dsa_id'=>$userid,TBL_LENDER_ASSIGN.'.status'=>'PENDING']);
        $this->data['approved_current']=$this->common_model->GetStatusCount(['dsa_id'=>$userid,TBL_LENDER_ASSIGN.'.status'=>'APPROVED']);
        $this->data['reject_current']=$this->common_model->GetStatusCount(['dsa_id'=>$userid,TBL_LENDER_ASSIGN.'.status'=>'REJECTED']);
        $this->data['total_disbursed_']=$this->common_model->CountResults(TBL_LENDER_ASSIGN,['dsa_id'=>$userid,'status'=>'DISBURSED']);
       $this->data['total_businessvolume_']=$this->common_model->GetRow(TBL_LENDER_ASSIGN,['dsa_id'=>$userid,'status'=>'DISBURSED'],'SUM(disbursed_amount) as disbursed_amount');
        $this->data['content']="dashboard/index2";
        $this->load->view('dsa',$this->data);
    }
    public function GetYourRm(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data = $this->common_model->GetRow('assign_member',['user_id'=>$this->session->userdata('user_id')]);
            if(!empty($data)){
                if($data->sale_id){
                   $data->sales= $this->common_model->GetRow(TBL_USERS,['user_id'=>$data->user_id]);
                }else{
                    $data->sales=[];
                }
                if($data->operation_id){
                    $data->operation= $this->common_model->GetRow(TBL_USERS,['user_id'=>$data->operation_id]);
                }else{
                    $data->operation=[];
                }
                return response(['status'=>'success','message'=>'RM Found','data'=>$data]);
            }else{
                return response(['status'=>'fail','message'=>'No RM Found']);
            }
        }
    }
}