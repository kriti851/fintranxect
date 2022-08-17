<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->output->delete_cache();
        $this->load->helper('dsa');
        isDsaLogin();
        if($this->session->userdata('user_type')!='DSA'){
            redirect_dsa('dashboard');
        }
    }
    public function index(){
        $this->data['results']=$this->common_model->GetResult('partner_profile',['dsa_id'=>$this->session->userdata('user_id')]);
        $this->data['content']="permission/index";
        $this->data['script']="permission/script";
        $this->load->view('dsa',$this->data);
    }
    public function add(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $permission=$this->common_model->GetResult('partner_permission');
            $html='<div class="form-row">
            <div class="col-12 col-sm-12">
                <small class="text-danger" id="permission_error"></small>
                <div class="table-responsive" style="overflow: hidden;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="25">Permission</th>
                                <th width="75">Sub Permission</th>
                            </tr>
                        </thead>
                        <tbody>';
                $i=0;
            foreach($permission as $perm_){
                $disabled="";
                if($i==0){
                    $disabled='disabled style="background:#4d8fd8"';
                    $i++;
                }
                $checked="";
                if($perm_->is_checked){
                    $checked="checked";
                }
                $html.='<tr>
                <td>
                    <div class="chiller_cb">
                        <input class="checkbox_lender" '.$disabled.'  id="select-permission-'.$perm_->id.'" name="main_permission[]" value="'.$perm_->id.'" '.$checked.' type="checkbox" />
                        <label for="select-permission-'.$perm_->id.'"></label>
                        <span>'.$perm_->title.'</span>
                    </div>
                </td><td><div class="row">';
                $subpermission=$this->common_model->GetResult('partner_subpermission',['permission_id'=>$perm_->id]);
                if(!empty($subpermission)){
                    foreach($subpermission as $sub_){
                        $checked="";
                        if($sub_->is_checked){
                            $checked="checked";
                        }

                        $html.='<div class="col-md-3">
                            <div class="chiller_cb">
                                <input class="checkbox_lender" id="select-sub-p-'.$sub_->id.'" name="sub_permission[]" value="'.$sub_->id.'" '.$checked.' type="checkbox" />
                                <label for="select-sub-p-'.$sub_->id.'"></label>
                                <span>'.$sub_->title.'</span>
                            </div>
                        </div>';
                    }
                }
                $html.='</div></td></tr>';
            }
            $html.='</tbody></table></div></div></div>';
            return response(['status'=>'success','html'=>$html]);
        }
    }
    public function addform(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['dsa_id']=$this->session->userdata('user_id');
            $setdata['title']=$this->input->post('title');
            $setdata['permission']=json_encode($this->input->post('main_permission'));
            $setdata['sub_permission']=json_encode($this->input->post('sub_permission'));
            if($this->common_model->InsertData('partner_profile',$setdata)){
                return response(['status'=>'success']);
            }else{
                return response(['status'=>'fail']);
            }
        }
    }
    public function edit(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $profile=$this->common_model->GetRow('partner_profile',['id'=>$this->input->post('id'),'dsa_id'=>$this->session->userdata('user_id')]);
            $main_permission=json_decode($profile->permission);
            $sub_permission=json_decode($profile->sub_permission);
            $permission=$this->common_model->GetResult('partner_permission');
            $html='<div class="form-row">
                <input type="hidden" id="id" value="'.$profile->id.'" />
                <div class="col-12 col-sm-12">
                    <label>Title</label>
                    <input class="multisteps-form__input form-control" type="text" id="title" placeholder="Permission Title" value="'.$profile->title.'" />
                </div>
            </div><div class="form-row">
            <div class="col-12 col-sm-12">
                <small class="text-danger" id="permission_error"></small>
                <div class="table-responsive" style="overflow: hidden;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="25">Permission</th>
                                <th width="75">Sub Permission</th>
                            </tr>
                        </thead>
                        <tbody>';
                $i=0;
            foreach($permission as $perm_){
                $disabled="";
                if($i==0){
                    $disabled='disabled style="background:#4d8fd8"';
                    $i++;
                }
                $checked="";
                if(in_array($perm_->id,$main_permission)){
                    $checked="checked";
                }
                $html.='<tr>
                <td>
                    <div class="chiller_cb">
                        <input class="checkbox_lender" '.$disabled.'  id="select-permission-'.$perm_->id.'" name="main_permission[]" value="'.$perm_->id.'" '.$checked.' type="checkbox" />
                        <label for="select-permission-'.$perm_->id.'"></label>
                        <span>'.$perm_->title.'</span>
                    </div>
                </td><td><div class="row">';
                $subpermission=$this->common_model->GetResult('partner_subpermission',['permission_id'=>$perm_->id]);
                if(!empty($subpermission)){
                    foreach($subpermission as $sub_){
                        $checked="";
                        if(in_array($sub_->id,$sub_permission)){
                            $checked="checked";
                        }

                        $html.='<div class="col-md-3">
                            <div class="chiller_cb">
                                <input class="checkbox_lender" id="select-sub-p-'.$sub_->id.'" name="sub_permission[]" value="'.$sub_->id.'" '.$checked.' type="checkbox" />
                                <label for="select-sub-p-'.$sub_->id.'"></label>
                                <span>'.$sub_->title.'</span>
                            </div>
                        </div>';
                    }
                }
                $html.='</div></td></tr>';
            }
            $html.='</tbody></table></div></div></div>';
            return response(['status'=>'success','html'=>$html]);
        }
    }
    public function updateform(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['title']=$this->input->post('title');
            $setdata['permission']=json_encode($this->input->post('main_permission'));
            $setdata['sub_permission']=json_encode($this->input->post('sub_permission'));
            if($this->common_model->UpdateData('partner_profile',$setdata,['id'=>$this->input->post('id'),'dsa_id'=>$this->session->userdata('user_id')])){
                return response(['status'=>'success']);
            }else{
                return response(['status'=>'fail']);
            }
        }
    }
}