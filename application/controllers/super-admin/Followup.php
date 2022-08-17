<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Followup extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->output->delete_cache();
        $this->load->model(['super-admin/follow_up_model']);
        $this->load->helper('admin');
        isAdminLogin();
        if(!MainPermission(10)){ 
			redirect_admin('dashboard');
		}
    }
    public function index(){
        $partnerpermission= PartnerPermission();
        $per_page=10;
        $search=$keyword="";
		if($this->input->get('per_page')){
			$per_page=$this->input->get('per_page');
        }
        $date_range=$this->input->get('date_range');
        $status=$this->input->get('status');
        $partner=$this->input->get('partner');
        $from_date=date('Y-m-d');
        $to_date=date('Y-m-d');
        if(!empty($date_range)){
            $explode=explode(' - ',$date_range);
            $from_date=$explode[0];
            $to_date=end($explode);
        }
        if($this->input->server('REQUEST_METHOD')=='GET'){
            $search="?date_range=".$this->input->get('date_range');
            if(!empty($partner)){
                $search.='&partner='.$partner;
            }
            if(!empty($status)){
                $search.='&status='.$status;
            }
        }
		$config=GetPagination($per_page);
		$config['base_url'] = admin_url("followup".$search);	
		$config['total_rows'] = $this->follow_up_model->CountGetFollowUp($from_date,$to_date,$status,$partner,$partnerpermission);
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
		
        $this->data['results']=$this->follow_up_model->GetFollowUp($config['per_page'],$page,$from_date,$to_date,$status,$partner,$partnerpermission);
        $this->data['partners']=$this->common_model->GetWhereWithIn(TBL_USERS,['user_type'=>'DSA'],'user_id',$partnerpermission,'user_id,company_name');
        $this->data['content']="follow-up/index";
        $this->data['script']="follow-up/script";
        $this->load->view('super-admin',$this->data);
    }
    public function show_notification(){
        $data = $this->follow_up_model->GetCurrentFolloup();
        if($data){
            return response(['status'=>'success','data'=>$data]);
        }else{
            return response(['status'=>'fail']);
        }
    }
}