<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('admin');
        isAdminLogin();
        if(!MainPermission(11)){
            redirect_admin('dashboard');
        }
    }
    public function index(){
        $this->data['results']=$this->common_model->GetResult('incomplete_status');
        $this->data['content']='setting/incomplete-status/index';
        $this->data['script']='setting/incomplete-status/script';
        $this->load->view('super-admin',$this->data);
    }
    public function StatusEdit(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            if($this->input->post('id')){
                $record = $this->common_model->GetRow('incomplete_status',['id'=>$this->input->post('id')]);
                if($record){
                    if($this->input->post('title')==$record->title){
                        return response(['status'=>'success']);
                    }else{
                        $this->form_validation->set_rules('title','Title','required');
                        if($this->form_validation->run()==TRUE){
                            $this->common_model->UpdateData('incomplete_status',['title'=>$this->input->post('title')],['id'=>$record->id]);
                            return response(['status'=>'success']);
                        }else{
                            return response(['status'=>'fail','error'=>strip_tags(form_error('title'))]);
                        }
                    }
                }else{
                    return response(['status'=>'fail','error'=>'Something Wrong!']);
                }
            }else{
                $this->form_validation->set_rules('title','Title','required');
                if($this->form_validation->run()==TRUE){
                    $this->common_model->InsertData('incomplete_status',['title'=>$this->input->post('title')]);
                    return response(['status'=>'success']);
                }else{
                    return response(['status'=>'fail','error'=>strip_tags(form_error('title'))]);
                }
            }
        }
    }
}