<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pincode extends CI_Controller {
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
		$config['base_url'] = admin_url("setting/pincode".$search);	
		$config['total_rows'] = $this->setting_model->CountPincodeList($keyword);
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$this->data['pagination']=$this->pagination->create_links();
		$page=$this->input->get('page');
		if($page > 1){
			$page=($page-1)*$config["per_page"];
		}else{
			$page=0;
		}
        $this->data['results']=$this->setting_model->PincodeList($config['per_page'],$page,$keyword);
        $this->data['content']='setting/pincode/index';
        $this->data['script']='setting/pincode/script';
        $this->load->view('super-admin',$this->data);
    }
    public function add($id=""){
        if(!SubPermission(47)){
            redirect_admin('dashboard');
        }
        if($id){
            $this->data['row']=$this->common_model->GetRow('pincode',['id'=>$id]);
        }
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('pincode','Pincode','required');
            $this->form_validation->set_rules('city','City','required');
            if($this->form_validation->run()==TRUE){
                $setdata=[];
                $setdata['city']=$this->input->post('city');
                $setdata['pincode']=$this->input->post('pincode');
                $setdata['state_id']=$this->input->post('state_id');
                $this->common_model->InsertData('pincode',$setdata);
                redirect_admin('setting/pincode');
            }
        }
        $this->data['states']=$this->common_model->GetResult('states',[],'id,name');
        $this->data['content']='setting/pincode/edit';
        $this->data['script']='setting/pincode/script';
        $this->load->view('super-admin',$this->data);
    }
    public function GetCityList(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $record = $this->common_model->GetResult('cities',['state_id'=>$this->input->post('state_id')]);
            $html='<option value="">City</option>';
            if($record){
                foreach($record as $row){
                    $html.='<option value="'.$row->name.'">'.$row->name.'</option>';
                }
            }
            echo $html;
        }
    }
    public function delete($id){
        if(!SubPermission(48)){
            redirect_admin('dashboard');
        }
        $this->common_model->DeleteData('pincode',['id'=>$id]);
        redirect_admin('setting/pincode');
    }
}