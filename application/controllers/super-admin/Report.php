<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
        $this->load->model(['super-admin/report_model','super-admin/merchant_model']);
        $this->load->helper('admin');
        isAdminLogin();
    }
    public function dropout(){
        $per_page=10;
        $search=$keyword="";
		if($this->input->get('per_page')){
			$per_page=$this->input->get('per_page');
		}
        if($this->input->get('keyword')){
            $keyword=trim($this->input->get('keyword'));
            $search='?keyword='.trim($this->input->get('keyword'));
        }
        $config=GetPagination($per_page);
		$config['base_url'] = admin_url("report/dropout".$search);	
		$config['total_rows'] = $this->report_model->CountCaseReport($keyword);
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$this->data['pagination']=$this->pagination->create_links();
		$page=$this->input->get('page');
		if($page > 1){
			$page=($page-1)*$config["per_page"];
		}else{
			$page=0;
		}
		$this->data['results']=$this->report_model->CaseReport($config['per_page'],$page,$keyword);
        $this->data['content']="report/dropout/index";
        $this->load->view('super-admin',$this->data);
    }
    public function merchant(){
        if(!MainPermission(5)){
			redirect_admin('dashboard');
        }
        $partnerpermission= PartnerPermission();
        $per_page=10;
        $search=$keyword="";
		if($this->input->get('per_page')){
			$per_page=$this->input->get('per_page');
		}
        $type=$this->input->get('type');
        if(empty($type)){
            $type='all';
        }
        $this->data['type']=$type;
        $keyword=trim($this->input->get('keyword'));
        $date_range=$this->input->get('date_range');
        if(empty($date_range)){
            $date_range=date('m/01/Y').' - '.date('m/t/Y');
        }
        $loan_type=$this->input->get('loan_type');
        if($this->input->server('REQUEST_METHOD')=='GET'){
            $search="?date_range=".$date_range;
            if(!empty($type)){
                $search.='&type='.$type;
            }
            if(!empty($keyword)){
                $search.='&keyword='.$keyword;
            }
            if(!empty($loan_type)){
                $search.='&loan_type='.$loan_type;
            }
        }
		$dsaid="";
        $config=GetPagination($per_page);
		$config['base_url'] = admin_url("report/merchant".$search);	
		$config['total_rows'] = $this->report_model->CountMerchantList($keyword,$type,$date_range,$loan_type,$dsaid,$partnerpermission);
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
		$this->data['results']=$this->report_model->MerchantList($config['per_page'],$page,$keyword,$type,$date_range,$loan_type,$dsaid,$partnerpermission);
        $this->data['dsa']=$this->common_model->GetWhereWithIn(TBL_USERS,['user_type'=>'DSA'],'user_id',$partnerpermission,'user_id,company_name,full_name');
        $this->data['lenderlist']=$this->common_model->GetResult(TBL_USERS,['user_type'=>'LENDERS']);
        $this->data['content']="report/merchant/index";
        $this->data['script']="report/merchant/script";
        $this->load->view('super-admin',$this->data);
    }
    public function PartnerWiseReport(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $partnerpermission= PartnerPermission();
            $dsalist=$this->common_model->GetWhereWithIn(TBL_USERS,['user_type'=>'DSA'],'user_id',$partnerpermission,'user_id,company_name,full_name');
            $html='<div class="form-row mt-4">
                <div class="col-md-12">
                    <label>Partner List</label>
                    <small class="text-danger" id="partner_error"></small>
                    <div class="chiller_cb">
                        <input class="checkbox_lender" id="select-all-partners" onclick="CheckExtraReport(this)" type="checkbox">
                        <label for="select-all-partners"><span>All</span></label>
                    </div>
                </div>';
                foreach($dsalist as $dsa){
                    $html.='<div class="col-md-6">
                        <div class="chiller_cb">
                            <input class="checkbox_lender" id="select-'.$dsa->user_id.'" name="multi_extrareport_ids[]" value="'.$dsa->user_id.'" type="checkbox">
                            <label for="select-'.$dsa->user_id.'"><span>'.$dsa->company_name.'</span></label>
                        </div>
                    </div>';
                }
            $html.='</div>';
            return response(['status'=>'success','html'=>$html]);
        }
    }
    public function LenderWiseReport(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $partnerpermission= PartnerPermission();
            $lenderlist=$this->common_model->GetResult(TBL_USERS,['user_type'=>'LENDERS']);
            $html='<div class="form-row mt-4">
                <div class="col-md-12">
                    <label>Partner List</label>
                    <small class="text-danger" id="partner_error"></small>
                    <div class="chiller_cb">
                        <input class="checkbox_lender" id="select-all-lenders" onclick="CheckExtraReport(this)" type="checkbox">
                        <label for="select-all-lenders"><span>All</span></label>
                    </div>
                </div>';
                foreach($lenderlist as $lender){
                    $html.='<div class="col-md-6">
                        <div class="chiller_cb">
                            <input class="checkbox_lender" id="select-'.$lender->user_id.'" name="multi_extrareport_ids[]" value="'.$lender->user_id.'" type="checkbox">
                            <label for="select-'.$lender->user_id.'"><span>'.$lender->company_name.'</span></label>
                        </div>
                    </div>';
                }
            $html.='</div>';
            return response(['status'=>'success','html'=>$html]);
        }
    }
    public function partner_wise(){
        if(!MainPermission(5)){
			redirect_admin('dashboard');
        }
        $partnerpermission= PartnerPermission();
        $per_page=10;
        $search=$keyword="";
		if($this->input->get('per_page')){
			$per_page=$this->input->get('per_page');
		}
        $type=$this->input->get('type');
        if(empty($type)){
            $type='all';
        }
        $this->data['type']=$type;
        $keyword=trim($this->input->get('keyword'));
        $date_range=$this->input->get('date_range');
        if(empty($date_range)){
            $date_range=date('m/01/Y').' - '.date('m/t/Y');
        }
        $loan_type=$this->input->get('loan_type');
        if($this->input->server('REQUEST_METHOD')=='GET'){
            $search="?date_range=".$date_range;
            if(!empty($type)){
                $search.='&type='.$type;
            }
            if(!empty($keyword)){
                $search.='&keyword='.$keyword;
            }
            if(!empty($loan_type)){
                $search.='&loan_type='.$loan_type;
            }
        }
		$dsaid="";
        $config=GetPagination($per_page);
		$config['base_url'] = admin_url("report/partner_wise".$search);	
		$config['total_rows'] = $this->report_model->CountWiseList($keyword,$type,$date_range,$loan_type,$dsaid,$partnerpermission);
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
		$this->data['results']=$this->report_model->WiseList($config['per_page'],$page,$keyword,$type,$date_range,$loan_type,$dsaid,$partnerpermission);
        $this->data['dsalist']=$this->common_model->GetWhereWithIn(TBL_USERS,['user_type'=>'DSA'],'user_id',$partnerpermission,'user_id,company_name,full_name');
        $this->data['content']="report/partner-wise/index";
        $this->data['script']="report/merchant/script";
        $this->load->view('super-admin',$this->data);
    }
    public function lender_wise(){
        if(!MainPermission(5)){
			redirect_admin('dashboard');
        }
        $partnerpermission= PartnerPermission();
        $per_page=10;
        $search=$keyword="";
		if($this->input->get('per_page')){
			$per_page=$this->input->get('per_page');
		}
        $type=$this->input->get('type');
        if(empty($type)){
            $type='all';
        }
        $this->data['type']=$type;
        $keyword=trim($this->input->get('keyword'));
        $date_range=$this->input->get('date_range');
        if(empty($date_range)){
            $date_range=date('m/01/Y').' - '.date('m/t/Y');
        }
        $loan_type=$this->input->get('loan_type');
        if($this->input->server('REQUEST_METHOD')=='GET'){
            $search="?date_range=".$date_range;
            if(!empty($type)){
                $search.='&type='.$type;
            }
            if(!empty($keyword)){
                $search.='&keyword='.$keyword;
            }
            if(!empty($loan_type)){
                $search.='&loan_type='.$loan_type;
            }
        }
		$dsaid="";
        $config=GetPagination($per_page);
		$config['base_url'] = admin_url("report/lender_wise".$search);	
		$config['total_rows'] = $this->report_model->CountWiseList($keyword,$type,$date_range,$loan_type,$dsaid,$partnerpermission,'lender_wise');
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
		$this->data['results']=$this->report_model->WiseList($config['per_page'],$page,$keyword,$type,$date_range,$loan_type,$dsaid,$partnerpermission,'lender_wise');
        $this->data['lenderlist']=$this->common_model->GetResult(TBL_USERS,['user_type'=>'LENDERS']);
        $this->data['content']="report/lender-wise/index";
        $this->data['script']="report/merchant/script";
        $this->load->view('super-admin',$this->data);
    }    
    public function disbursed(){
        if(!MainPermission(5)){
			redirect_admin('dashboard');
        }
        $partnerpermission= PartnerPermission();
        $per_page=10;
        $search=$keyword="";
		if($this->input->get('per_page')){
			$per_page=$this->input->get('per_page');
		}
       
        $keyword=trim($this->input->get('keyword'));
        $loan_type=$this->input->get('loan_type');
        if($this->input->server('REQUEST_METHOD')=='GET'){
            $search="?loan_type=".$loan_type;
            if(!empty($keyword)){
                $search.='&keyword='.$keyword;
            }
        }
		$dsaid="";
        $config=GetPagination($per_page);
		$config['base_url'] = admin_url("report/disbursed".$search);	
		$config['total_rows'] = $this->report_model->CountDisbursedMerchantList($keyword,$loan_type,$partnerpermission);
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
		$this->data['results']=$this->report_model->DisbursedMerchantList($config['per_page'],$page,$keyword,$loan_type,$partnerpermission);
        $this->data['content']="report/disbursed/index";
        $this->data['script']="report/merchant/script";
        $this->load->view('super-admin',$this->data);
    }
    
    public function query_builder(){
        $this->data['content']="report/builder/index";
        $this->data['script']="report/builder/script";
        $this->load->view('super-admin',$this->data);
    }
}