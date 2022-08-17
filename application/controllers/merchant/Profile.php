<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('merchant');
        $this->load->model(['merchant/profile_model']);
        isMerchantLogin();
    }
    public function index(){
        $this->data['result']=$this->profile_model->GetUserDetail($this->session->userdata('user_id'));
        $this->data['content']="profile/index";
        $this->data['script']="profile/script";
        $this->load->view('merchant',$this->data);
    }
    public function email_validation(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data = $this->common_model->GetRow(TBL_USERS,['user_id'=>$this->session->userdata('user_id')]);
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
    public function update_profile(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['full_name']=$this->input->post('first_name').' '.$this->input->post('last_name');
            $setdata['company_name']=$this->input->post('business_name');
            $setdata['email']=$this->input->post('email');
            $setdata['age']=$this->input->post('age');
            $setdata['gst_number']=$this->input->post('gst_number');
            $setdata['pan_number']=$this->input->post('pan_number');
            $setdata['user_type']='MERCHANT';
            $setdata['updated_at']=date('Y-m-d H:i:s');
           
            $setdata2=[];
            $setdata2['address1']=$this->input->post('address1');
            $setdata2['vintage']=$this->input->post('vintage');
            $setdata2['turn_over']=$this->input->post('turn_over');
            $setdata2['business_type']=$this->input->post('business_type');

            if($this->input->post('reference'))
            $setdata2['reference']=$this->input->post('reference');
            
            if(!empty($_FILES['adharcard_image']['name'])){
                $extension=pathinfo($_FILES['adharcard_image']['name'], PATHINFO_EXTENSION);	
                $_FILES['adharcard_image']['name']=time().".".$extension;
                $config['upload_path']          = 'uploads/merchant/adharcard';
                $config['allowed_types']        = 'png|jpeg|jpg';
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('adharcard_image'))
                {
                    $image = $this->upload->data();
                    $setdata2['adharcard_image']=$image['file_name'];
                }
            }
            if(!empty($_FILES['pancard_image']['name'])){
                $extension=pathinfo($_FILES['pancard_image']['name'], PATHINFO_EXTENSION);	
                $_FILES['pancard_image']['name']=time().".".$extension;
                $config['upload_path']          = 'uploads/merchant/pancard';
                $config['allowed_types']        = 'png|jpeg|jpg';
                $this->load->library('upload',$config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('pancard_image'))
                {
                    $image = $this->upload->data();
                    $setdata2['pancard_image']=$image['file_name'];
                }
            }
            $insertId=$this->session->userdata('user_id');
            if($this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$insertId])){
                
                $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata2,['user_id'=>$insertId]);
                $this->common_model->DeleteData(TBL_USER_PARTNER,['user_id'=>$insertId]);
                $this->common_model->DeleteData(TBL_USER_COAPPLICANT,['user_id'=>$insertId]);
                $count = count($this->input->post('other_pannumber'));
                for($i=0;$i<$count;$i++){
                    $setdata3=[];
                    if($this->input->post('other_pannumber')[$i])
                    $setdata3['pan_number']=$this->input->post('other_pannumber')[$i];

                    if($this->input->post('other_phone_number')[$i])
                    $setdata3['phone_number']=$this->input->post('other_phone_number')[$i];

                    if($this->input->post('other_office_address')[$i])
                    $setdata3['office_address']=$this->input->post('other_office_address')[$i];

                    if($this->input->post('other_home_address')[$i])
                    $setdata3['home_address']=$this->input->post('other_home_address')[$i];

                    if(!empty($setdata3)){
                        $setdata3['user_id']=$insertId;
                        $this->common_model->InsertData(TBL_USER_PARTNER,$setdata3);
                    }
                }

                $count = count($this->input->post('co_name'));
                for($i=0;$i<$count;$i++){
                    $setdata4=[];
                    if($this->input->post('co_name')[$i])
                    $setdata4['name']=$this->input->post('co_name')[$i];

                    if($this->input->post('co_relationship')[$i])
                    $setdata4['relationship']=$this->input->post('co_relationship')[$i];

                    if($this->input->post('co_pan_number')[$i])
                    $setdata4['pan_number']=$this->input->post('co_pan_number')[$i];

                    if(!empty($setdata4)){
                        $setdata4['user_id']=$insertId;
                        $this->common_model->InsertData(TBL_USER_COAPPLICANT,$setdata4);
                    }
                }
                return response(['status'=>"success",'message'=>'Successful']);
            }else{
                return response(['status'=>"fail",'message'=>'Failure']);
            }
        }
    }
}