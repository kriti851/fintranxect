<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('admin');
        $this->load->model('super-admin/setting_model','setting_model');
        isAdminLogin();
        if(!MainPermission(11)){
            redirect_admin('dashboard');
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
		$config['base_url'] = admin_url("setting/city".$search);	
		$config['total_rows'] = $this->setting_model->CountCityList($keyword);
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$this->data['pagination']=$this->pagination->create_links();
		$page=$this->input->get('page');
		if($page > 1){
			$page=($page-1)*$config["per_page"];
		}else{
			$page=0;
		}
        $this->data['results']=$this->setting_model->CityList($config['per_page'],$page,$keyword);
        $this->data['content']='setting/city/index';
        $this->load->view('super-admin',$this->data);
    }
    public function edit($id=""){
       
        if($id){
            if(!SubPermission(44)){
                redirect_admin('dashboard');
            }
            $this->data['row']=$this->common_model->GetRow('cities',['id'=>$id]);
        }else{
            if(!SubPermission(43)){
                redirect_admin('dashboard');
            }
        }
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('state_id','State','required');
            $this->form_validation->set_rules('city','City','required');
            if($this->form_validation->run()==TRUE){
                $setdata=[];
                $setdata['name']=$this->input->post('city');
                $setdata['state_id']=$this->input->post('state_id');
                if($id){
                    $this->common_model->UpdateData('cities',$setdata,['id'=>$id]);
                    redirect_admin('setting/city');
                }else{
                    $this->common_model->InsertData('cities',$setdata);
                    redirect_admin('setting/city');
                }
            }
        }
        $this->data['states']=$this->common_model->GetResult('states',[],'id,name');
        $this->data['content']='setting/city/edit';
        $this->load->view('super-admin',$this->data);
    }
}