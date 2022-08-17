<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model(['super-admin/user_model']);
        $this->load->helper('admin');
        isAdminLogin();
        if(!SubPermission(56)){
            redirect_admin('profile');
        }
    }
    public function index(){
        $per_page=10;
        $search=$keyword="";
		if($this->input->get('per_page')){
			$per_page=$this->input->get('per_page');
        }
		if(!empty($this->input->get('keyword'))){
		    $keyword=$this->input->get('keyword');
		    $search='?keyword='.$this->input->get('keyword');
		}
		$config=GetPagination($per_page);
		$config['base_url'] = admin_url("user/index".$search);	
		$config['total_rows'] = $this->user_model->CountUserList($keyword);
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$this->data['pagination']=$this->pagination->create_links();
		$page=$this->input->get('page');
		if($page > 1){
			$page=($page-1)*$config["per_page"];
		}else{
			$page=0;
		}
        $this->data['results']=$this->user_model->UserList($config['per_page'],$page,$keyword);
        $this->data['permission']=$this->common_model->GetResult(TBL_PROFILE,[],'profile_id,title');
        $this->data['dsalist']=$this->common_model->GetResult(TBL_USERS,['user_type'=>'DSA'],'file_id,user_id,company_name');
        $this->data['content']="users/index";
        $this->data['script']="users/script";
        $this->load->view('super-admin',$this->data);
    }
    public function phone_validation(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|numeric');
            if($this->form_validation->run()==TRUE){
                $mobile_number=$this->input->post('mobile_number');
                $data = $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$mobile_number]);
                if($data){
                    return response(['status'=>"fail",'message'=>'Mobile Number Already Exists']);
                }else{
                    return response(['status'=>"success",'message'=>'Successful']);
                }
            }else{
                return response(['status'=>"fail",'message'=>form_error('mobile_number')]);
            }
        }
    }
    public function email_validation(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            if($this->form_validation->run()==TRUE){
                $email=$this->input->post('email');
                $data = $this->common_model->GetRow(TBL_USERS,['email'=>$email]);
                if($data){
                    return response(['status'=>"fail",'message'=>'Email Already Exists']);
                }else{
                    return response(['status'=>"success",'message'=>'Successful']);
                }
            }else{
                return response(['status'=>"fail",'message'=>form_error('email')]);
            }
        }
    }
    public function add_user(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            
            $setdata=[];
            $lastsubfileid=1;
            $lastLender=$this->user_model->GetFileId();
            if($lastLender){
                $lastsubfileid = $lastLender->sub_id+1;
            }
            $setdata['sub_id']=$lastsubfileid;
            $setdata['user_type']='USERS';
            $file_id='FTU'.sprintf('%04u', $lastsubfileid);
            $setdata['file_id']=$file_id;
            $setdata['full_name']=$this->input->post('full_name');
            $setdata['email']=$this->input->post('email');
            $setdata['mobile_number']=$this->input->post('mobile_number');
            $setdata['address']=$this->input->post('address');
            $setdata['created_at']=date('Y-m-d');
            
            if($this->input->post('profile_id')){
                $profile=$this->common_model->GetRow(TBL_PROFILE,['profile_id'=>$this->input->post('profile_id')]);
                $setdata['profile_id']=$profile->profile_id;
                $setdata['profile_title']=$profile->title;
            }else{
                $setdata['user_type']='SUPER-ADMIN';
            }
            if($this->input->post('pan_number'))
            $setdata['pan_number']=$this->input->post('pan_number');

            $setdata['password']=password_hash($this->input->post('passwrod'),PASSWORD_DEFAULT);
            if($insertId =$this->common_model->InsertData(TBL_USERS,$setdata)){
                $partner_perm=[];
                if(!empty($this->input->post('dsa_id'))){
                    foreach($this->input->post('dsa_id') as $key=>$dsa){
                        $partner_perm[]=['user_id'=>$insertId,'partner_id'=>$dsa];
                    }
                    $this->common_model->InsertBatch('admin_users_permission',$partner_perm);
                }
                $setdata2=[];
                if($this->input->post('profile_id'))
                $setdata2['profile_id']=$this->input->post('profile_id');

                $setdata2['user_id']=$insertId;
                $this->common_model->InsertData(TBL_PROFILE_ASSIGN,$setdata2);
                return response(['status'=>'success','message'=>'Successful']);
            }else{
                return response(['status'=>'fail','message'=>'Failure']);
            }
        }
    }
    public function GetUserDetail(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data=$this->common_model->GetRow(TBL_USERS,['user_id'=>$this->input->post('user_id')]);
            $permission=$this->common_model->GetResult(TBL_PROFILE,[],'profile_id,title');
            $html='<option value="">Super Admin</option>';
            if($permission){
                foreach($permission as $perm){
                    $selected="";
                    if($perm->profile_id==$data->profile_id){
                        $selected="selected";
                    }
                    $html.='<option value="'.$perm->profile_id.'" '.$selected.'>'.$perm->title.'</option>';
                }
            }
            $data->permission=$html;
            
            $dsalist=$this->common_model->GetResult(TBL_USERS,['user_type'=>'DSA'],'file_id,user_id,company_name');
            $dsa_permission=$this->common_model->GetResult('admin_users_permission',['user_id'=>$this->input->post('user_id')],'partner_id');
            $permission_array = array_column($dsa_permission, 'partner_id');
            $selected="";
            if(count($dsalist)==count($dsa_permission)){
                $selected="checked";
            }
            $dsahtml='<div class="col-md-12">
                <label>Partner List</label>
                <small class="text-danger" id="partner_edit_error"></small>
                <div class="chiller_cb">
                    <input class="checkbox_lender" onclick="selectFunct(this)" '.$selected.' id="all-editselect"  type="checkbox">
                    <label for="all-editselect"><span>All</span></label>
                </div>
            </div>';
            //$dsahtml='';
            foreach($dsalist as $dsa){
                $selected="";
                if(in_array($dsa->user_id,$permission_array)){
                    $selected="checked";
                }
                $dsahtml.='<div class="col-md-6">
                    <div class="chiller_cb">
                        <input class="checkbox_lender" id="editselect-'.$dsa->user_id.'" name="multi_dsa_editid[]" '.$selected.' value="'.$dsa->user_id.'" type="checkbox">
                        <label for="editselect-'.$dsa->user_id.'"><span>'.$dsa->company_name.'</span></label>
                    </div>
                </div>';
            }
            $data->dsa_permission=$dsahtml;
            return response(['status'=>'Success','message'=>'Successful','data'=>$data]);
        }
    }
    public function edit_email_validation(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data = $this->common_model->GetRow(TBL_USERS,['user_id'=>$this->input->post('user_id')]);
			if($data->email==$this->input->post('email')){
                return response(['status'=>"success",'message'=>'Successful']);
            }else{
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                if($this->form_validation->run()==TRUE){
                    $email=$this->input->post('email');
                    $data = $this->common_model->GetRow(TBL_USERS,['email'=>$email]);
                    if($data){
                        return response(['status'=>"fail",'message'=>'Email Already Exists']);
                    }else{
                        return response(['status'=>"success",'message'=>'Successful']);
                    }
                }else{
                    return response(['status'=>"fail",'message'=>form_error('email')]);
                }
            }
        }
    }
    public function UpdateProfile(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['full_name']=$this->input->post('full_name');
            $setdata['email']=$this->input->post('email');
            $setdata['address']=$this->input->post('address');

            if($this->input->post('pan_number'))
            $setdata['pan_number']=$this->input->post('pan_number');
            
            if($this->input->post('password'))
            $setdata['password']=password_hash($this->input->post('password'),PASSWORD_DEFAULT);

            if($this->input->post('profile_id')){
                $profile=$this->common_model->GetRow(TBL_PROFILE,['profile_id'=>$this->input->post('profile_id')]);
                $setdata['profile_id']=$profile->profile_id;
                $setdata['profile_title']=$profile->title;
            }else{
                $setdata['profile_id']=null;
                $setdata['profile_title']=null;
                $setdata['user_type']='SUPER-ADMIN';
            }
            if($this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$this->input->post('user_id')])){
                $partner_perm=[];
                $this->common_model->DeleteData('admin_users_permission',['user_id'=>$this->input->post('user_id')]);
                if(!empty($this->input->post('dsa_id'))){
                    foreach($this->input->post('dsa_id') as $key=>$dsa){
                        $partner_perm[]=['user_id'=>$this->input->post('user_id'),'partner_id'=>$dsa];
                    }
                    $this->common_model->InsertBatch('admin_users_permission',$partner_perm);
                }
                $setdata2=[];
                if($this->input->post('profile_id'))
                $setdata2['profile_id']=$this->input->post('profile_id');
                else
                $setdata2['profile_id']=null;;

                $this->common_model->UpdateData(TBL_PROFILE_ASSIGN,$setdata2,['user_id'=>$this->input->post('user_id')]);
                return response(['status'=>'Success','message'=>'Successful']);
            }else{
                return response(['status'=>'fail','message'=>'Failure']);
            }
        }
    }
}