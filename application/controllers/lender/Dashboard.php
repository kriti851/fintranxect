<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
        $this->load->helper('lender');
        isLenderLogin();
    }
    public function index(){
        $userid=$this->session->userdata('user_id');
        $this->data['total_cases_']=$this->common_model->GetUserCountsForLender($userid);
        $this->data['assigned_case_']=$this->common_model->GetUserCountsForLender($userid,[TBL_LENDER_ASSIGN.'.status'=>'ASSIGNED']);
        $this->data['logged_case_']=$this->common_model->GetUserCountsForLender($userid,[TBL_LENDER_ASSIGN.'.status'=>'LOGGED']);
        $this->data['pending_case_']=$this->common_model->GetUserCountsForLender($userid,[TBL_LENDER_ASSIGN.'.status'=>'PENDING']);
        $this->data['reject_case_']=$this->common_model->GetUserCountsForLender($userid,[TBL_LENDER_ASSIGN.'.status'=>'REJECTED']);
        $this->data['disbursed_case_']=$this->common_model->GetUserCountsForLender($userid,[TBL_LENDER_ASSIGN.'.status'=>'DISBURSED']);
        $this->data['approved_case_']=$this->common_model->GetUserCountsForLender($userid,[TBL_LENDER_ASSIGN.'.status'=>'APPROVED']);
        
        $this->data['active_case_in_month']=$this->common_model->GetActiveCases(['lender_id'=>$userid,'MONTH(created_at)'=>date('m'),'YEAR(created_at)'=>date('Y')]);
        $this->data['active_case_in_year']=$this->common_model->GetActiveCases(['lender_id'=>$userid,'YEAR(created_at)'=>date('Y')]);
        $this->data['total_disbursed_']=$this->common_model->GetRow(TBL_LENDER_ASSIGN,['lender_id'=>$userid,'status'=>'DISBURSED'],'SUM(disbursed_amount) as amount');
        $this->data['content']="dashboard/index";
        $this->load->view('lender',$this->data);
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