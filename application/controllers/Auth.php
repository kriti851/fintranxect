<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    private $data=[];
    public function __construct() {
		parent::__construct();
		$this->output->delete_cache();
        $this->load->library('session');
        $this->load->model(['auth_model']);
    }
	public function superadmin_login()
	{
	    if($this->input->server('REQUEST_METHOD')=='POST'){
	         $this->form_validation->set_rules('username', 'Email/Phone', 'required');
	         $this->form_validation->set_rules('password', 'Password', 'required');
	         if($this->form_validation->run()==TRUE){
	             $data=$this->auth_model->Login($this->input->post('username'));
	             if($data){
	                 if($data->user_type=="SUPER-ADMIN" || $data->user_type=="USERS"){
	                     if(password_verify($this->input->post('password'),$data->password)){
							$loginlog=[];
							$loginlog['file_id']=$data->file_id;
							$loginlog['full_name']=$data->full_name;
							$loginlog['company_name']=$data->company_name;
							$loginlog['ip_address']=$this->input->ip_address();
							$loginlog['login_time']=date('Y-m-d H:i:s');
							$this->common_model->InsertData('login_log',$loginlog);
							
	                         $setdata=[];
	                         $setdata['user_id']=$data->user_id;
	                         $setdata['email']=$data->email;
	                         $setdata['full_name']=$data->full_name;
	                         $setdata['mobile_number']=$data->mobile_number;
							 $setdata['user_type']=$data->user_type;
							 $setdata['profile_id']=$data->profile_id;
							 if(!empty($data->profile_id)){
								$permission= $this->common_model->GetRow('profile',['profile_id'=>$data->profile_id]);
								if(!empty($permission)){
									$setdata['admin']['main_permission']= json_decode($permission->permission);
									$setdata['admin']['sub_permission']= json_decode($permission->sub_permission);
								}
							}
							$partner_ids=$this->common_model->GetResult('admin_users_permission',['user_id'=>$data->user_id],'partner_id');
							if(!empty($partner_ids)){
								$setdata['admin']['partner_ids']=array_column($partner_ids,'partner_id');
							}else{
								$setdata['admin']['partner_ids']=[];
							}
							$setdata['__token']='@3$%&*^%&*%@#$';
							 $this->session->set_userdata($setdata);
							 $this->session->set_flashdata('message','Login Successful');
							 $this->session->set_flashdata('message_type','success');
	                         redirect('super-admin/dashboard');
	                     }else{
	                         $this->data['password_error']="Invalid Password";
	                     }
	                 }else{
    	                 $this->data['username_error']="Invalid Email/Phone";
    	             }
	             }else{
	                 $this->data['username_error']="Invalid Email/Phone";
	             }
	         }
	    }
	    $this->data['content']="super-admin/login/index";
		$this->load->view('template.php',$this->data);
	}
	public function logout(){
	    if($this->session->userdata('user_type')=='SUPER-ADMIN'){
    	    $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('user_type');
            $this->session->unset_userdata('email');
			$this->session->unset_userdata('__super_admin');
			$this->session->unset_userdata('__token');
			$this->session->unset_userdata('dsa');
			$this->session->unset_userdata('admin');
            redirect('super-admin/login');
	    }else{
	        $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('user_type');
            $this->session->unset_userdata('email');
			$this->session->unset_userdata('__token');
			$this->session->unset_userdata('dsa');
			$this->session->unset_userdata('admin');
            redirect('login');
	    }
	}
}