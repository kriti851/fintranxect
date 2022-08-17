<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->output->delete_cache();
        $this->load->helper('dsa');
        isDsaLogin();
    }
    public function index(){
        if($this->session->userdata('user_type')!='DSA'){
            redirect_dsa('dashboard');
        }
		$this->data['results']=$this->common_model->GetResult(TBL_USERS,['partner_id'=>$this->session->userdata('user_id'),'user_type'=>'SUB-DSA']);
        $this->data['content']="users/index";
        $this->data['script']="users/script";
        $this->load->view('dsa',$this->data);
    }
    public function add_(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data = $this->common_model->GetResult('partner_profile',['dsa_id'=>$this->session->userdata('user_id')],'id,title');
            $html='<option value="">All</option>';
            if(!empty($data)){
                foreach($data as $row){
                    $html.='<option value="'.$row->id.'">'.$row->title.'</option>';
                }
            }
            return response(['status'=>'success','html'=>$html]);
        }
    }
    public function adduser(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('full_name','Full Name','trim|required');
            $this->form_validation->set_rules('company_name','Company Name','trim|required');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('mobile_number','Mobile Number','trim|required|is_unique[users.mobile_number]');
            $this->form_validation->set_rules('address','Address','trim|required');
            $this->form_validation->set_rules('password','Password','trim|required');
            if($this->form_validation->run()==TRUE){
                $setdata=[];
                $setdata['full_name']=$this->input->post('full_name');
                $setdata['company_name']=$this->input->post('company_name');
                $setdata['email']=$this->input->post('email');
                $setdata['mobile_number']=$this->input->post('mobile_number');
                $setdata['address']=$this->input->post('address');
                $setdata['password']=password_hash($this->input->post('password'),PASSWORD_DEFAULT);
                $lastsubfileid=1;
                $lastMerchant=$this->common_model->GetOrderByRow(TBL_USERS,['user_id','DESC'],['user_type'=>'SUB-DSA']);
                if($lastMerchant){
                    $lastsubfileid = $lastMerchant->sub_id+1;
                }
                $setdata['sub_id']=$lastsubfileid;
                $setdata['partner_id']=$this->session->userdata('user_id');
                $setdata['file_id']='FTPU'.sprintf('%04u', $lastsubfileid);
                $setdata['user_type']='SUB-DSA';
                $setdata['created_at']=date('Y-m-d H:i:s');
                if($insertId=$this->common_model->InsertData(TBL_USERS,$setdata)){
                    $this->common_model->InsertData('partner_profile_assign',['user_id'=>$insertId,'profile_id'=>$this->input->post('permission')]);
                    return response(['status'=>'success','message'=>'User Added Successfully']);
                }else{
                    return response(['status'=>'failure','message'=>'Something Wrong!']);
                }
            }else{
                $error="";
                if(form_error('full_name')){
                    $error=form_error('full_name');
                }elseif(form_error('company_name')){
                    $error=form_error('company_name');
                }elseif(form_error('email')){
                    $error=form_error('email');
                }elseif(form_error('mobile_number')){
                    $error=form_error('mobile_number');
                }elseif(form_error('mobile_number')){
                    $error=form_error('mobile_number');
                }elseif(form_error('address')){
                    $error=form_error('address');
                }elseif(form_error('password')){
                    $error=form_error('password');
                }
                return response(['status'=>'failure','message'=>strip_tags($error)]);
            }
        }
    }
    public function getuser(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $record = $this->common_model->GetRow(TBL_USERS,['user_id'=>$this->input->post('user_id'),'user_type'=>'SUB-DSA']);
            $data = $this->common_model->GetResult('partner_profile',['dsa_id'=>$this->session->userdata('user_id')],'id,title');
            $profile_assign=$this->common_model->GetRow('partner_profile_assign',['user_id'=>$record->user_id],'profile_id');
            $html='<option value="">All</option>';
            if(!empty($data)){
                foreach($data as $row){
                    $echo ="";
                    if(!empty($profile_assign) && $profile_assign->profile_id==$row->id){
                        $echo ="selected";
                    }
                    $html.='<option '.$echo.' value="'.$row->id.'">'.$row->title.'</option>';
                }
            }
            $record->select=$html;
            return response(['status'=>'success','data'=>$record]);
        }
    }
    public function ValidEmail($str,$val){
        if(!empty($str)){
           $record= $this->common_model->GetRow(TBL_USERS,['email'=>$str,'user_id!='=>$this->input->post('user_id')]);
            if($record){
                $this->form_validation->set_message('ValidEmail','Email already Exists');
                return false;
            }else{
                return true;
            }
        }
    }
    public function ValidMobile($str,$val){
        if(!empty($str)){
           $record= $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$str,'user_id!='=>$this->input->post('user_id')]);
            if($record){
                $this->form_validation->set_message('ValidMobile','Mobile Number Already Exists');
                return false;
            }else{
                return true;
            }
        }
    }
    public function updateuser(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('full_name','Full Name','trim|required');
            $this->form_validation->set_rules('company_name','Company Name','trim|required');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|callback_ValidEmail');
            $this->form_validation->set_rules('mobile_number','Mobile Number','trim|required|callback_ValidMobile');
            $this->form_validation->set_rules('address','Address','trim|required');
            if($this->form_validation->run()==TRUE){
                $setdata=[];
                $setdata['full_name']=$this->input->post('full_name');
                $setdata['company_name']=$this->input->post('company_name');
                $setdata['email']=$this->input->post('email');
                $setdata['mobile_number']=$this->input->post('mobile_number');
                $setdata['address']=$this->input->post('address');
                $setdata['updated_at']=date('Y-m-d H:i:s');
                if(!empty($this->input->post('password'))){
                    $setdata['password']=password_hash($this->input->post('password'),PASSWORD_DEFAULT);
                }
                if($this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$this->input->post('user_id'),'partner_id'=>$this->session->userdata('user_id')])){
                    $this->common_model->DeleteData('partner_profile_assign',['user_id'=>$this->input->post('user_id')]);
                    if(!empty($this->input->post('permission'))){
                        $this->common_model->InsertData('partner_profile_assign',['user_id'=>$this->input->post('user_id'),'profile_id'=>$this->input->post('permission')]);
                    }
                    return response(['status'=>'success','message'=>'User Updated Successfully']);
                }else{
                    return response(['status'=>'failure','message'=>'Something Wrong!']);
                }
            }else{
                $error="";
                if(form_error('full_name')){
                    $error=form_error('full_name');
                }elseif(form_error('company_name')){
                    $error=form_error('company_name');
                }elseif(form_error('email')){
                    $error=form_error('email');
                }elseif(form_error('mobile_number')){
                    $error=form_error('mobile_number');
                }elseif(form_error('mobile_number')){
                    $error=form_error('mobile_number');
                }elseif(form_error('address')){
                    $error=form_error('address');
                }elseif(form_error('password')){
                    $error=form_error('password');
                }
                return response(['status'=>'failure','message'=>strip_tags($error)]);
            }
        }
    }
}