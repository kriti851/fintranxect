<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model(['super-admin/user_model','super-admin/profile_model']);
        $this->load->helper('admin');
        isAdminLogin();
        
    }
    public function index(){
		$this->data['results']=$this->common_model->GetResult(TBL_PROFILE);
		$this->data['permission_list']=$this->profile_model->GetPermissionList();
        $this->data['content']="profile/index";
        $this->data['script']="profile/script";
        $this->load->view('super-admin',$this->data);
    }
    public function unique_title(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data =$this->common_model->GetRow(TBL_PROFILE,['title'=>$this->input->post('title')]);
            if(!empty($data)){
                return response(['status'=>'fail','message'=>'Title Already Exists']);
            }else{
                return response(['status'=>'success','message'=>'Success']);
            }
        }
    }
    public function edit_unique_title(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data =$this->common_model->GetRow(TBL_PROFILE,['title'=>$this->input->post('title')]);
            if(!empty($data)){
                if($data->profile_id!=$this->input->post('profile_id')){
                    return response(['status'=>'fail','message'=>'Title Already Exists']);
                }else{
                    return response(['status'=>'success','message'=>'Success']);
                }
            }else{
                return response(['status'=>'success','message'=>'Success']);
            }
        }
    }
    public function AddProfile(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['title']=$this->input->post('title');
            $setdata['permission']=json_encode($this->input->post('main_permission'));
            $setdata['sub_permission']=json_encode($this->input->post('sub_permission'));
            if($this->common_model->InsertData(TBL_PROFILE,$setdata)){
                return response(['status'=>'success','message'=>'Success']);
            }else{
                return response(['status'=>'fail','message'=>'Something Wrong']);
            }
        }
    }
    public function UpdateProfile(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['title']=$this->input->post('title');
            $setdata['permission']=json_encode($this->input->post('main_permission'));
            $setdata['sub_permission']=json_encode($this->input->post('sub_permission'));
            if($this->common_model->UpdateData(TBL_PROFILE,$setdata,['profile_id'=>$this->input->post('profile_id')])){
                return response(['status'=>'success','message'=>'Success']);
            }else{
                return response(['status'=>'fail','message'=>'Something Wrong']);
            }
        }
    }
    public function GetProfile(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $profile =$this->common_model->GetRow(TBL_PROFILE,['profile_id'=>$this->input->post('profile_id')]);
            $this->data['profile']=$profile;
            $this->data['results']=$this->common_model->GetResult(TBL_PROFILE);
            $this->data['permission_list']=$this->profile_model->GetPermissionList();
            $this->load->view('super-admin/profile/edit',$this->data);
        }
    }
    public function OldPasswordCheck(){
        if($this->input->post('old_password')){
            $profile=$this->common_model->GetRow(TBL_USERS,['user_id'=>$this->session->userdata('user_id')]);
            if(password_verify($this->input->post('old_password'),$profile->password)){
                return true;
            }else{
                $this->form_validation->set_message('OldPasswordCheck', 'The Old Password Not Match');
                return false;
            }
        }else{
            $this->form_validation->set_message('OldPasswordCheck', 'The Old Password field is required');
            return false;
        }
    }
    public function change_password(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('old_password', 'Old Password', 'callback_OldPasswordCheck');
            $this->form_validation->set_rules('new_password', 'New Password', 'required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
            if($this->form_validation->run()==TRUE){
                $setdata=[];
                $setdata['password']=password_hash($this->input->post('new_password'),PASSWORD_DEFAULT);
                $this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$this->session->userdata('user_id')]);

                $this->session->set_flashdata('message','Password Updated Successfully');
                $this->session->set_flashdata('message_type','success');
                redirect_admin('profile/change_password');
            }
        }
        $this->data['content']="change-password/index";
        $this->load->view('super-admin',$this->data);
    }
}