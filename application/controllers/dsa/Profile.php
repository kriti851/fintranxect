<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->output->delete_cache();
        $this->load->helper('dsa');
        isDsaLogin();
        if(!MainPermission(4)){
            redirect_dsa('dashboard');
        }
    }
    public function index(){
        $user_id=$this->session->userdata('user_id');
        if(!empty($this->session->userdata('sub_user_id'))){
            $user_id=$this->session->userdata('sub_user_id');
        }
        $this->data['profile']=$this->common_model->GetRow(TBL_USERS,['user_id'=>$user_id]);
        $this->data['content']="profile/index";
        //$this->data['script']="profile/script";
        $this->load->view('dsa',$this->data);
    }
    public function AddIp(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->common_model->UpdateData(TBL_USERS,['whitelist_ip'=>$this->input->post('ip')],['user_id'=>$this->session->userdata('user_id')]);
            return response(['status'=>'success']);
        }
    }
    
    public function pan_gstvalidation(){
        $data=$this->input->post('gst_number');
        //echo $data;die;
        if(strlen($data)==10){
            return true;
        }elseif(strlen($data)==15){
            return true;
        }else{
            $this->form_validation->set_message('pan_gstvalidation', 'Please Enter Valid PAN/GST Number');
            return FALSE;
        }
    }
    public function edit(){
        $user_id=$this->session->userdata('user_id');
        if(!empty($this->session->userdata('sub_user_id'))){
            $user_id=$this->session->userdata('sub_user_id');
        }
        $this->data['profile']=$this->common_model->GetRow(TBL_USERS,['user_id'=>$user_id]);
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('full_name', 'Full Name', 'required');
            $this->form_validation->set_rules('company_name', 'Company Name', 'required');
            if($this->data['profile']->email!=$this->input->post('email')){
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            }
            
            $this->form_validation->set_rules('gst_number', 'GST/PAN Number', 'required|callback_pan_gstvalidation');
            $this->form_validation->set_rules('address', 'Address', 'required');
            if($this->form_validation->run()==TRUE){
                $setdata=[];
                $setdata['full_name']=$this->input->post('full_name');
                $setdata['company_name']=$this->input->post('company_name');
                $setdata['email']=$this->input->post('email');
                $setdata['website']=$this->input->post('website');
                $setdata['gst_number']=$this->input->post('gst_number');
                $setdata['address']=$this->input->post('address');
                $setdata['pan_number']=$this->input->post('pan_number');
                
                if($this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$user_id])){
                    $this->session->set_flashdata('message','Profile Updated Successfully');
                    $this->session->set_flashdata('message_type','success');
                    redirect_dsa('profile');
                }
            }
        }
        $this->data['content']="profile/edit";
        $this->load->view('dsa',$this->data);
    }
    public function OldPasswordCheck(){
        if($this->input->post('old_password')){
            $user_id=$this->session->userdata('user_id');
            if(!empty($this->session->userdata('sub_user_id'))){
                $user_id=$this->session->userdata('sub_user_id');
            }
            $profile=$this->common_model->GetRow(TBL_USERS,['user_id'=>$user_id]);
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
                $user_id=$this->session->userdata('user_id');
                if(!empty($this->session->userdata('sub_user_id'))){
                    $user_id=$this->session->userdata('sub_user_id');
                }
                $this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$user_id]);
                $this->session->set_flashdata('message','Password Updated Successfully');
                $this->session->set_flashdata('message_type','success');
                redirect_dsa('profile');
            }
        }
        $this->data['content']="profile/change_password";
        //$this->data['content']="profile/edit_script";
        $this->load->view('dsa',$this->data);
    }
    public function upload(){
        if(!empty($_FILES['profile_pic'])){
            $extension=pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);	
            $_FILES['profile_pic']['name']=time().".".$extension;
            $config['upload_path']          = 'uploads/profile';
            $config['allowed_types']        = 'png|jpeg|jpg|gif';
            $this->load->library('upload',$config);
            $this->upload->initialize($config);
            if($this->upload->do_upload('profile_pic'))
            {
                $image = $this->upload->data();
                $setdata=[];
                $setdata['profile_pic']=$image['file_name'];
                 if($this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$this->session->userdata('user_id')])){
                    $this->session->set_flashdata('message','Profile Pic Updated Successfully');
                    $this->session->set_flashdata('message_type','Success');
                    redirect_dsa('profile');
                }
            }else{
                echo $this->upload->display_errors();die;
                $this->session->set_flashdata('message', $this->upload->display_errors());
                $this->session->set_flashdata('message_type','Fail');
                redirect_dsa('profile/edit');
            }
        }else{
            redirect('profile/edit');
        }
    }
}