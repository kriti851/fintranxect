<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lender extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model(['super-admin/lender_model','super-admin/merchant_model']);
		$this->load->helper('admin');
		$this->output->delete_cache();
		isAdminLogin();
		if(!MainPermission(3)){
			redirect_admin('dashboard');
		}
    }
    public function index(){
        $per_page=10;
        $search=$keyword="";
		if($this->input->get('per_page')){
			$per_page=$this->input->get('per_page');
        }
        $date_range=$this->input->get('date_range');
        $keyword=$this->input->get('keyword');
        if($this->input->server('REQUEST_METHOD')=='GET'){
            $search="?date_range=".$this->input->get('date_range');
            if(!empty($type)){
                $search.='&type='.$type;
            }
            if(!empty($keyword)){
                $search.='&keyword='.$keyword;
            }
        }
		$config=GetPagination($per_page);
		$config['base_url'] = admin_url("lender".$search);	
		$config['total_rows'] = $this->lender_model->CountLenderList($keyword,$date_range);
		$this->data['total_rows']=$config['total_rows'];
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$this->data['pagination']=$this->pagination->create_links();
		$page=$this->input->get('page');
		if($page > 1){
			$page=($page-1)*$config["per_page"];
		}else{
			$page=0;
		}
		$this->data['mtd_lender']=$this->common_model->CountResults(TBL_USERS,['user_type'=>'LENDERS','MONTH(created_at)'=>date('m'),'YEAR(created_at)'=>date('Y')]);
		$this->data['ytd_lender']=$this->common_model->CountResults(TBL_USERS,['user_type'=>'LENDERS','DATE(created_at)>='=>date('Y').'-04-01','DATE(created_at)<'=>(date('Y')+1).'-04-01']);
        $this->data['results']=$this->lender_model->LenderList($config['per_page'],$page,$keyword,$date_range);
        //$this->common_model->UpdateData(TBL_USERS,['is_new'=>1],['user_type'=>'LENDERS','is_new'=>0]);
        $this->data['content']="lender/index";
        $this->data['script']="lender/script";
        $this->load->view('super-admin',$this->data);
    }
    public function GetUserDetail(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data = $this->common_model->GetRow(TBL_USERS,['user_id'=>$this->input->post('user_id')]);
            if($data){
				$userid=$this->input->post('user_id');
				$data->total_cases_=$this->common_model->GetUserCountsForLender($userid);
				$data->assigned_case_=$this->common_model->GetUserCountsForLender($userid,[TBL_LENDER_ASSIGN.'.status'=>'ASSIGNED']);
				$data->logged_case_=$this->common_model->GetUserCountsForLender($userid,[TBL_LENDER_ASSIGN.'.status'=>'LOGGED']);
				$data->pending_case_=$this->common_model->GetUserCountsForLender($userid,[TBL_LENDER_ASSIGN.'.status'=>'PENDING']);
				$data->reject_case_=$this->common_model->GetUserCountsForLender($userid,[TBL_LENDER_ASSIGN.'.status'=>'REJECTED']);
				$data->disbursed_case_=$this->common_model->GetUserCountsForLender($userid,[TBL_LENDER_ASSIGN.'.status'=>'DISBURSED']);
				$data->approved_case_=$this->common_model->GetUserCountsForLender($userid,[TBL_LENDER_ASSIGN.'.status'=>'APPROVED']);
				$data->total_disbursed_=$this->common_model->GetRow(TBL_LENDER_ASSIGN,['lender_id'=>$userid,'status'=>'DISBURSED'],'SUM(disbursed_amount) as amount');
				
                return response(['status'=>'Success','message'=>'Successful','data'=>$data]);
            }else{
                return response(['status'=>'Fail','message'=>'Opps Something Wrong']);
            }
        }
    }
    public function UpdateProfile(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            if($this->input->post('company_name'))
                $setdata['company_name']=$this->input->post('company_name');
            if($this->input->post('full_name'))
                $setdata['full_name']=$this->input->post('full_name');
            if($this->input->post('email'))
                $setdata['email']=$this->input->post('email');
            if($this->input->post('mobile_number'))
                $setdata['mobile_number']=$this->input->post('mobile_number');
            if($this->input->post('address'))
                $setdata['address']=$this->input->post('address');
            if($this->input->post('pan_number'))
                $setdata['pan_number']=$this->input->post('pan_number');
            
            if($this->input->post('gst_number'))
                $setdata['gst_number']=$this->input->post('gst_number');
            
            $setdata['updated_at']=date('Y-m-d H:i:s');
            if($this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$this->input->post('user_id')])){
                return response(['status'=>'Success','message'=>'Success']);
            }else{
                return response(['status'=>'Fail','message'=>'failure']);
            }
        }
    }
    public function associate_merchants($id){
        $per_page=10;
        $search=$keyword="";
		if($this->input->get('per_page')){
			$per_page=$this->input->get('per_page');
		}
        $type=$this->input->get('type');
        $keyword=trim($this->input->get('keyword'));
        $date_range=$this->input->get('date_range');
        $loan_type=$this->input->get('loan_type');
        $order_by=$this->input->get('order_by');
        $record_type=$this->input->get('record_type');
        $remark=$this->input->get('remark');
        if($this->input->server('REQUEST_METHOD')=='GET'){
            $search="?record_type=".$this->input->get('record_type');
            if(!empty($type)){
                $search.='&type='.$type;
            }
            if(!empty($keyword)){
                $search.='&keyword='.$keyword;
            }
            if(!empty($loan_type)){
                $search.='&loan_type='.$loan_type;
            }
            if(!empty($order_by)){
                $search.='&order_by='.$order_by;
            }
            if(!empty($remark)){
                $search.='&remark='.$remark;
            }
        }
		
        $config=GetPagination($per_page);
		$config['base_url'] = admin_url("lender/associate_merchants/".$id.$search);	
		$config['total_rows'] = $this->lender_model->CountMerchantList($keyword,$type,$date_range,$loan_type,$id,$record_type,$remark);
		$this->data['total_rows']=$config['total_rows'];
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$this->data['pagination']=$this->pagination->create_links();
		$page=$this->input->get('page');
		if($page > 1){
			$page=($page-1)*$config["per_page"];
		}else{
			$page=0;
		}
		$this->data['results']=$this->lender_model->MerchantList($config['per_page'],$page,$keyword,$type,$date_range,$loan_type,$id,$order_by,$record_type,$remark);
		$this->data['disabled_incomplete']=true;
		$this->data['disabled_received']=true;
		$this->data['lender_case']=true;
        $this->data['content']="merchant/index";
        $this->data['script']="merchant/script";
        $this->load->view('super-admin',$this->data);
        
    }
	public function GetAssignMember(){
		if($this->input->server('REQUEST_METHOD')=='POST'){
			$data = $this->common_model->GetRow('assign_member',['user_id'=>$this->input->post('user_id')]);
			$salelist=$this->common_model->GetResult(TBL_USERS,['profile_title'=>'Sales']);
			$operationlist=$this->common_model->GetResult(TBL_USERS,['profile_title'=>'Operations']);
			if(!empty($data)){
				$html1='<option value="">Select Sale Member</option>';
				if($salelist){
					foreach($salelist as $sale){
						$select="";
						if($sale->user_id==$data->sale_id){
							$select="selected";
						}
						$html1.='<option value="'.$sale->user_id.'" '.$select.'>'.$sale->full_name.'</option>';
					}
				}
				$html2='<option value="">Select Operation Member</option>';
				if($operationlist){
					foreach($operationlist as $operation){
						$select="";
						if($operation->user_id==$data->operation_id){
							$select="selected";
						}
						$html2.='<option value="'.$operation->user_id.'" '.$select.'>'.$operation->full_name.'</option>';
					}
				}
				$data->salelist=$html1;
				$data->operationlist=$html2;
			}else{
				$data=new stdClass;
				$data->user_id=$this->input->post('user_id');
				$html1='<option value="">Select Sale Member</option>';
				if($salelist){
					foreach($salelist as $sale){
						$html1.='<option value="'.$sale->user_id.'" >'.$sale->full_name.'</option>';
					}
				}
				$html2='<option value="">Select Operation Member</option>';
				if($operationlist){
					foreach($operationlist as $operation){
						$html2.='<option value="'.$operation->user_id.'" >'.$operation->full_name.'</option>';
					}
				}
				$data->salelist=$html1;
				$data->operationlist=$html2;
			}
			return response(['status'=>'success','data'=>$data]);
		}
	}
	public function AssignRm(){
		if($this->input->server('REQUEST_METHOD')=='POST'){
			$setdata=[];
			if($this->input->post('operation_id'))
				$setdata['operation_id']=$this->input->post('operation_id');
				
			if($this->input->post('sale_id'))
				$setdata['sale_id']=$this->input->post('sale_id');
		
			if(!empty($setdata)){
				$data = $this->common_model->GetRow('assign_member',['user_id'=>$this->input->post('user_id')]);
				if($data){
					$setdata['updated_at']=date('Y-m-d H:i:s');
					$this->common_model->UpdateData('assign_member',$setdata,['user_id'=>$this->input->post('user_id')]);
				}else{
					$setdata['user_id']=$this->input->post('user_id');
					$setdata['created_at']=date('Y-m-d H:i:s');
					$this->common_model->InsertData('assign_member',$setdata);
				}
				$this->session->set_flashdata('message','Member Assigned Successfully');
				$this->session->set_flashdata('message_type','success');
				return response(['status'=>'success']);
			}else{
				$this->session->set_flashdata('message','Failure');
				$this->session->set_flashdata('message_type','danger');
				return response(['status'=>'fail']);
			}
		}
	}
}