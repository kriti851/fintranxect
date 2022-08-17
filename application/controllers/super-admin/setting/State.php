<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State extends CI_Controller {
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
        $this->data['results']=$this->common_model->GetResult('states');
        $this->data['content']='setting/state/index';
        $this->data['script']='setting/state/script';
        $this->load->view('super-admin',$this->data);
    }
    public function StateEdit(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            if($this->input->post('stateid')){
                $record = $this->common_model->GetRow('states',['id'=>$this->input->post('stateid')]);
                if($record){
                    if($this->input->post('statename')==$record->name){
                        return response(['status'=>'success']);
                    }else{
                        $this->form_validation->set_rules('statename','State Name','required|is_unique[states.name]');
                        if($this->form_validation->run()==TRUE){
                            $this->common_model->UpdateData('states',['name'=>$this->input->post('statename')],['id'=>$record->id]);
                            return response(['status'=>'success']);
                        }else{
                            return response(['status'=>'fail','error'=>strip_tags(form_error('statename'))]);
                        }
                    }
                }else{
                    return response(['status'=>'fail','error'=>'Something Wrong!']);
                }
            }else{
                $this->form_validation->set_rules('statename','State Name','required|is_unique[states.name]');
                if($this->form_validation->run()==TRUE){
                    $this->common_model->InsertData('states',['name'=>$this->input->post('statename'),'country_id'=>'101']);
                    return response(['status'=>'success']);
                }else{
                    return response(['status'=>'fail','error'=>strip_tags(form_error('statename'))]);
                }
            }
        }
    }
}