<?php
class Api extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->output->delete_cache();
        $this->load->helper('dsa');
        isDsaLogin();
        if(!MainPermission(6)){
            redirect_dsa('dashboard');
        }
    }
    public function index(){
        $this->data['profile']=$this->common_model->GetRow(TBL_USERS,['user_id'=>$this->session->userdata('user_id')]);
        $this->data['ip']=$this->common_model->GetResult('white_list_ips',['user_id'=>$this->session->userdata('user_id')]);
        $this->data['content']="api/index";
        $this->data['script']="api/script";
        $this->load->view('dsa',$this->data);
    }
    public function generate_key(){
        $key=md5(time());
        $this->common_model->UpdateData(TBL_USERS,['secret_key'=>$key],['user_id'=>$this->session->userdata('user_id')]);
        redirect_dsa('api');
    }
    public function change_ip(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            if($this->input->post('ip_id')){
                $this->common_model->UpdateData('white_list_ips',['ip_address'=>$this->input->post('ip_address')],['id'=>$this->input->post('ip_id')]);
            }else{
                $setdata=[];
                $setdata['user_id']=$this->session->userdata('user_id');
                $setdata['ip_address']=$this->input->post('ip_address');
                $this->common_model->InsertData('white_list_ips',$setdata);
            }
            return response(['status'=>'success']);
        }
    }
}