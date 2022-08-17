<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Report extends CI_Controller{
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
        $this->load->helper('dsa');
        $this->load->model(['dsa/report_model','dsa/merchant_model']);
        isDsaLogin();
        if(!MainPermission(5)){
            redirect_dsa('dashboard');
        }
    }
    public function merchant(){
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
		$dsaid=$this->session->userdata('user_id');
        $config=GetPagination($per_page);
		$config['base_url'] = dsa_url("report/merchant".$search);	
		$config['total_rows'] = $this->report_model->CountMerchantList($keyword,$type,$date_range,$loan_type,$dsaid);
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
		$this->data['results']=$this->report_model->MerchantList($config['per_page'],$page,$keyword,$type,$date_range,$loan_type,$dsaid);
        $this->data['content']="report/merchant/index";
        $this->load->view('dsa',$this->data);
    }
}