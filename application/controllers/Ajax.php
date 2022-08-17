<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model(['auth_model']);
        $this->load->helper('cookie');

    }
    public function dsa_mobile_number(){
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
    public function dsa_email(){
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
    public function send_dsa_otp(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data = $this->common_model->GetRow('temp_user',['mobile_number'=>$this->input->post('mobile_number')]);
            $otp=rand(111111,999999);
            $otp=111111;
            if($data){
               $this->common_model->UpdateData('temp_user',['otp'=>$otp,'otp_time'=>date('Y-m-d H:i:s')],['mobile_number'=>$this->input->post('mobile_number')]); 
            }else{
                 $this->common_model->InsertData('temp_user',['otp'=>$otp,'otp_time'=>date('Y-m-d H:i:s'),'mobile_number'=>$this->input->post('mobile_number')]); 
            }
            $message=$otp." is your verification code. Please do not share to anyone";
            SendOtpMessage($message,$this->input->post('mobile_number'));
            return response(['status'=>"success",'message'=>'Successful','data'=>['otp'=>$otp]]);
        }
    }
    public function dsa_verify_otp(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data = $this->common_model->GetRow('temp_user',['mobile_number'=>$this->input->post('mobile_number')]);
            if($data){
                if($data->otp==$this->input->post('otp')){
                     return response(['status'=>"success",'message'=>'Successful']);
                }else{
                     return response(['status'=>"fail",'message'=>'Invalid otp']);
                }
            }else{
                 return response(['status'=>"fail",'message'=>'Invalid otp']);
            }
        }
    }
    public function dsa_registration(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata2=[];
            $lastsubfileid=1;
            $lastDsa=$this->common_model->GetOrderByRow(TBL_USERS,['user_id','DESC'],['user_type'=>'DSA']);
            if($lastDsa){
                $lastsubfileid = $lastDsa->sub_id+1;
            }
            $setdata['sub_id']=$lastsubfileid;
            $setdata['file_id']='FTP'.sprintf('%04u', $lastsubfileid);
            $setdata['company_name']=$this->input->post('company_name');
            $setdata['full_name']=$this->input->post('full_name');
            $setdata['mobile_number']=$this->input->post('mobile_number');
            $setdata['address']=$this->input->post('address');
            $setdata['email']=$this->input->post('email');
            $setdata['website']=$this->input->post('website');
            $setdata['user_name']=$this->input->post('username');

            if($this->input->post('gst_number'))
            $setdata['gst_number']=$this->input->post('gst_number');

            $setdata['user_type']='DSA';
            $setdata['created_at']=date('Y-m-d H:i:s');
            if(!empty($this->input->post('dsa_document'))){
                $count=$this->input->post('dsa_document');
                $filedata=[];
                for($i=0;$i<count($count);$i++){
                    $string=explode('@kk@',$this->input->post('dsa_document')[$i]);
                    $contents = file_get_contents($string[0]);
                    if(!empty($contents)){
                        $filename=time().rand(111111,999999).'.'.end($string);
                        $filedata[]=$filename;
                        uploadFile(UPLOADS_DIR.'dsa-doc/'.$filename,$contents);
                    }
                }
                if(!empty($filedata)){
                    $setdata['doc']=implode(',',$filedata);
                }
            }
            $password="myloan@123#";
            $explode=explode(" ",$this->input->post('full_name'));
            $password=strtolower($explode[0]).'@'.rand(111,999).'#';
            $password=$this->input->post('password');
            $setdata['password']=password_hash($password,PASSWORD_DEFAULT);
            $setdata2['incomplete_status']=8;
            $this->common_model->UpdateData(TBL_USERS,$setdata2,['user_id'=>$record->user_id]);
            if($this->common_model->InsertData(TBL_USERS,$setdata)){
                $message='Dear '.$this->input->post('full_name').' '.$password." is your login password. Please do not share to anyone";
                //SendOtpMessage($message,$this->input->post('mobile_number'));
                return response(['status'=>"success",'message'=>'Successful']);
            }else{
                return response(['status'=>"fail",'message'=>'Failure']);
            }
        }
    }
    
    public function lender_mobile_number(){
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
     public function lender_email(){
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
    public function send_lender_otp(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data = $this->common_model->GetRow('temp_user',['mobile_number'=>$this->input->post('mobile_number')]);
            $otp=rand(111111,999999);
            $otp=111111;
            if($data){
               $this->common_model->UpdateData('temp_user',['otp'=>$otp,'otp_time'=>date('Y-m-d H:i:s')],['mobile_number'=>$this->input->post('mobile_number')]); 
            }else{
                 $this->common_model->InsertData('temp_user',['otp'=>$otp,'otp_time'=>date('Y-m-d H:i:s'),'mobile_number'=>$this->input->post('mobile_number')]); 
            }
            $message=$otp." is your verification code. Please do not share to anyone";
            SendOtpMessage($message,$this->input->post('mobile_number'));
            return response(['status'=>"success",'message'=>'Successful','data'=>['otp'=>$otp]]);
        }
    }
    public function lender_verify_otp(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data = $this->common_model->GetRow('temp_user',['mobile_number'=>$this->input->post('mobile_number')]);
            if($data){
                if($data->otp==$this->input->post('otp')){
                     return response(['status'=>"success",'message'=>'Successful']);
                }else{
                     return response(['status'=>"fail",'message'=>'Invalid otp']);
                }
            }else{
                 return response(['status'=>"fail",'message'=>'Invalid otp']);
            }
        }
    }
    public function lender_registration(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $lastsubfileid=1;
            $lastLender=$this->common_model->GetOrderByRow(TBL_USERS,['user_id','DESC'],['user_type'=>'LENDERS']);
            if($lastLender){
                $lastsubfileid = $lastLender->sub_id+1;
            }
            $setdata['sub_id']=$lastsubfileid;
            $setdata['file_id']='FTL'.sprintf('%04u', $lastsubfileid);
            $setdata['company_name']=$this->input->post('company_name');
            $setdata['full_name']=$this->input->post('full_name');
            $setdata['mobile_number']=$this->input->post('mobile_number');
            $setdata['address']=$this->input->post('address');
            $setdata['email']=$this->input->post('email');
            //$setdata['website']=$this->input->post('website');
            if($this->input->post('gst_number'))
            $setdata['gst_number']=$this->input->post('gst_number');
            
            $setdata['user_type']='LENDERS';
            $setdata['created_at']=date('Y-m-d H:i:s');
            
            $password="myloan@123#";
            $explode=explode(" ",$this->input->post('full_name'));
            $password=strtolower($explode[0]).'@'.rand(111,999).'#';
            $password=$this->input->post('password');

            $setdata['password']=password_hash($password,PASSWORD_DEFAULT);
            if($this->common_model->InsertData(TBL_USERS,$setdata)){
                $message='Dear '.$this->input->post('full_name').' '.$password." is your login password. Please do not share to anyone";
                //SendOtpMessage($message,$this->input->post('mobile_number'));
                return response(['status'=>"success",'message'=>'Successful']);
            }else{
                return response(['status'=>"fail",'message'=>'Failure']);
            }
        }
    }
    public function send_otp_phone(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data = $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('mobile_number')]);
            $otp=rand(111111,999999);
            if($data){
                $this->common_model->UpdateData(TBL_USERS,['otp'=>$otp,'otp_time'=>date('Y-m-d H:i:s')],['mobile_number'=>$this->input->post('mobile_number')]); 
                $message=$otp." is your verification code. Please do not share to anyone";
                SendOtpMessage($message,$this->input->post('mobile_number'));
                return response(['status'=>"success",'message'=>'Successful','data'=>['otp'=>$otp]]);
            }else{
                 return response(['status'=>"fail",'message'=>'Invalid Mobile Number']);
            }
            
        }
    }
    public function verify_otp(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data = $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('mobile_number')]);
            if($data){
                if($data->otp==$this->input->post('otp')){
                     return response(['status'=>"success",'message'=>'Successful']);
                }else{
                     return response(['status'=>"fail",'message'=>'Invalid otp']);
                }
            }else{
                 return response(['status'=>"fail",'message'=>'Invalid otp']);
            }
        }
    }
    public function updatePassword(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['password']=password_hash($this->input->post('password'),PASSWORD_DEFAULT);
            $this->common_model->UpdateData(TBL_USERS,$setdata,['mobile_number'=>$this->input->post('mobile_number')]);
            return response(['status'=>"success",'message'=>'Successful']);
        }
    }
    public function phone_validation(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|numeric');
            if($this->form_validation->run()==TRUE){
                $mobile_number=$this->input->post('mobile_number');
                $data = $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$mobile_number,'status'=>null]);
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
                $data = $this->common_model->GetRow(TBL_USERS,['email'=>$email,'status'=>null]);
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
    public function send_loan_otp(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            if($this->input->server('REQUEST_METHOD')=='POST'){
                $data = $this->common_model->GetRow('temp_user',['mobile_number'=>$this->input->post('mobile_number')]);
                $otp=rand(111111,999999);
                $otp=111111;
                if($data){
                   $this->common_model->UpdateData('temp_user',['otp'=>$otp,'otp_time'=>date('Y-m-d H:i:s')],['mobile_number'=>$this->input->post('mobile_number')]); 
                }else{
                     $this->common_model->InsertData('temp_user',['otp'=>$otp,'otp_time'=>date('Y-m-d H:i:s'),'mobile_number'=>$this->input->post('mobile_number')]); 
                }
                $message=$otp." is your verification code. Please do not share to anyone";
                SendOtpMessage($message,$this->input->post('mobile_number'));
                return response(['status'=>"success",'message'=>'Successful','data'=>['otp'=>$otp]]);
            }
        }
    }
    public function loan_verify_otp(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data = $this->common_model->GetRow('temp_user',['mobile_number'=>$this->input->post('mobile_number')]);
            if($data){
                if($data->otp==$this->input->post('otp')){
                     return response(['status'=>"success",'message'=>'Successful']);
                }else{
                     return response(['status'=>"fail",'message'=>'Invalid otp']);
                }
            }else{
                 return response(['status'=>"fail",'message'=>'Invalid otp']);
            }
        }
    }
    public function loan_registration(){
        
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $record= $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('phone')]);
            $setdata=[];
            $setdata['company_name']=$this->input->post('business_name');
            $setdata['updated_at']=date('Y-m-d H:i:s');
            
            $setdata2=[];
            if($this->input->post('reference'))
            $setdata2['reference']=$this->input->post('reference');
            
            if($this->input->post('reference_number'))
            $setdata2['reference_number']=$this->input->post('reference_number');
            
            if($this->input->post('no_of_partner'))
            $setdata2['total_director_partner']=$this->input->post('no_of_partner');
            
            if($this->input->post('no_of_director'))
            $setdata2['total_director_partner']=$this->input->post('no_of_director');

            if($this->input->post('pan_number'))
            $setdata2['pan_number']=$this->input->post('pan_number');
            
            if($this->input->post('business_address'))
            $setdata2['business_address']=$this->input->post('business_address');
            
            if($this->input->post('resident_address'))
            $setdata2['resident_address']=$this->input->post('resident_address');

            if($this->input->post('gstnumber'))
            $setdata2['gst_number']=$this->input->post('gstnumber');

            if($this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$record->user_id])){
                
                $insertId=$record->user_id;
                $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata2,['user_id'=>$insertId]);
                if($record->status=='INCOMPLETE'){
                    $checkdocuments = $this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$insertId,'pancard_image!='=>NULL,'bank_statement!='=>NULL]);
                    if($checkdocuments){
                        if($record->created_by=='1793' && $record->other_app_user_id!=""){
                            $payToken = $this->GetPay1Token();
                            if(!empty($payToken) && !empty($payToken['api_token'])){
                                $pay1_data=$this->common_model->GetRow('pay1_data',['user_id'=>$record->other_app_user_id                                ]);
                                if(!empty($pay1_data)){
                                    $token=$payToken['api_token'];
                                    $url='http://loandev.pay1.in/sdk/loans/'.$record->file_id;
                                    $headers=['x-api-token:Basic '.$token,'Content-type:application/json'];
                                    $setpay1=[];
                                    $setpay1['user_id']=$record->other_app_user_id;
                                    $setpay1['interest_rate_yearly']=null;
                                    $setpay1['emi_counts']=0;
                                    $setpay1['amount_disbursed']=null;
                                    $setpay1['loan_uid']=$record->file_id;
                                    $setpay1['loan_amount']=null;
                                    $setpay1['processing_fee']=$pay1_data->processing_fees;
                                    $setpay1['tenure']=$pay1_data->tenure_in_days;
                                    $setpay1['emi_amount_interest']=null;
                                    $setpay1['emi_amount']=null;
                                    $setpay1['type']=1;
                                    $setpay1['amount_offered']=$pay1_data->approved_amount;
                                    $setpay1['emi_amount_principle']=null;
                                    $this->CallApi($url,$headers,$setpay1);
                                }
                            }
                        }
                   
                        $caselog=[];
                        $caselog['merchant_id']=$insertId;
                        $caselog['change_by']='public url';
                        $caselog['change_by_user_type']=null;
                        $caselog['log_text']='Received Case';
                        $caselog['log_type']='STATUS';
                        $caselog['status']='RECEIVED';
                        $this->common_model->InsertData('case_log',$caselog);
                        $this->common_model->UpdateData(TBL_USERS,['status'=>null,'received_time'=>date('Y-m-d H:i:s')],['user_id'=>$record->user_id]);
                    }
                   /*  $this->session->set_flashdata('message','Thank you ! Your application has been successfully received. You may choose to note down the file number for further tracking of the case!');
                    $this->session->set_flashdata('message_type','success'); */
                }
                $shortclose=$this->common_model->GetRow('user_lender_assign',['merchant_id'=>$insertId,'lender_id'=>null,'status'=>'SHORTCLOSE']);
                if(!empty($shortclose)){
                    $this->common_model->DeleteData('user_lender_assign',['id'=>$shortclose->id]);
                }
                return response(['status'=>"success",'message'=>'Successful']);
            }else{
                return response(['status'=>"fail",'message'=>'Failure']);
            }
        }
    }
    public function GetCityList(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
           $state=$this->common_model->GetRow(TBL_STATE,['name'=>$this->input->post('state')]); 
            $cities=$this->common_model->GetOrderByResult(TBL_CITY,['name','ASC'],['state_id'=>$state->id],'UPPER(name) as name');
            $html='<option value="">City</option>';
            if($cities){
                foreach($cities as $city){
                    $selected='';
                    if($this->input->post('city')==$city->name){
                        $selected='selected';
                    }
                    $html.='<option value="'.$city->name.'" '.$selected.'>'.$city->name.'</a>';
                }
            }
            $selected='';
            if($this->input->post('city')=='Other'){
                $selected='selected';
            }
            $html.='<option value="Other" '.$selected.'>Other</option>';
            echo $html; 
        }
    }
    public function incomplete_form(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $data = $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('mobile_number')]);
            $setdata=[];
            $setdata['full_name']=$this->input->post('first_name').' '.$this->input->post('last_name');
            if($data){
                $setdata['status']='INCOMPLETE';
            }else{
                $lastsubfileid=1;
                $lastMerchant=$this->common_model->GetOrderByRow(TBL_USERS,['user_id','DESC'],['user_type'=>'MERCHANT']);
                if($lastMerchant){
                    $lastsubfileid = $lastMerchant->sub_id+1;
                }
                $setdata['sub_id']=$lastsubfileid;
                $setdata['user_type']='MERCHANT';
                $setdata['file_id']='FTM'.sprintf('%07u', $lastsubfileid);
                $setdata['status']='INCOMPLETE';
                $setdata['incomplete_status']=1;

                $password=substr(str_replace(' ','',$setdata['full_name']),0,4).preg_replace('~[+\d-](?=[\d-]{4})~', '', $this->input->post('mobile_number'));
                $setdata['password']=password_hash($password,PASSWORD_DEFAULT);
            }
            $setdata['mobile_number']=$this->input->post('mobile_number');
            $setdata['email']=$this->input->post('email');
            $setdata['age']=$this->input->post('age');
            $setdata['loan_type']=$this->input->post('employment_type');
           
            if(!empty($this->input->post('other_app_user_id'))){
                $setdata['other_app_user_id']=$this->input->post('other_app_user_id');
            }
            if($this->input->post('das_agent_id'))
            $setdata['created_by']=$this->input->post('das_agent_id');
            
            if(!empty($data)){
                $setdata['updated_at']=date('Y-m-d H:i:s');
                if($this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$data->user_id])){
                    if($this->input->post('employment_type')=='Business'){
                        $detail=$this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$data->user_id]);
                        if($detail){
                            $setdata2=[];
                            $setdata2['date_of_birth']=date('Y-m-d',strtotime($this->input->post('date_of_birth')));
                            $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata2,['user_id'=>$data->user_id]);
                        }else{
                            $setdata2=[];
                            $setdata2['user_id']=$data->user_id;
                            $setdata2['date_of_birth']=date('Y-m-d',strtotime($this->input->post('date_of_birth')));
                            $this->common_model->InsertData(TBL_USER_DETAIL,$setdata2);
                        }
                    }
                    $this->session->set_userdata(['r_number'=>$this->input->post('mobile_number')]);
                    $message='Thanks for showing your interest in unsecured business loan. Our team will contact you shortly. www.fintranxect.com';
                    if($this->input->post('das_agent_id')==1746){
                        $message='We have received your loan query through our partner Zomato. Our executive will get in touch with you shortly. www.fintranxect.com';
                    }
                    SendOtpMessage($setdata['mobile_number'],$message);
                    return response(['status'=>'success','message'=>'Success','number'=>$this->input->post('mobile_number')]);
                }else{
                    return response(['status'=>'fail','message'=>'Failure']);
                }

            }else{
                $setdata['created_at']=date('Y-m-d H:i:s');
                $setdata['updated_at']=date('Y-m-d H:i:s');
                if($insertId= $this->common_model->InsertData(TBL_USERS,$setdata)){
                    if($this->input->post('employment_type')=='Business'){
                        $setdata2=[];
                        $setdata2['user_id']=$insertId;
                        $setdata2['date_of_birth']=date('Y-m-d',strtotime($this->input->post('date_of_birth')));
                        $this->common_model->InsertData(TBL_USER_DETAIL,$setdata2);
                    }
                    //set_cookie('r_number',$this->input->post('mobile_number'),time() + 84000000);
                    $this->session->set_userdata(['r_number'=>$this->input->post('mobile_number')]);
                    $message='Thanks for showing your interest in unsecured business loan. Our team will contact you shortly. www.fintranxect.com';
                    if($this->input->post('das_agent_id')==1746){
                        $message='We have received your loan query through our partner Zomato. Our executive will get in touch with you shortly. www.fintranxect.com';
                    }
                    SendOtpMessage($setdata['mobile_number'],$message);
                    return response(['status'=>'success','message'=>'Success','number'=>$this->input->post('mobile_number')]);
                }else{
                    return response(['status'=>'fail','message'=>'Failure']);
                }
            }
        } 
    }
    public function keyUpForm(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $record= $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('mobile_number'),'status'=>'INCOMPLETE']);
            $setdata=[];
            if($this->input->post('key')=='business_name'){
                $setdata['company_name']=$this->input->post('value');
                $this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$record->user_id]);
            }else{
                $setdata2=[];
                
                if($this->input->post('key')=='houseno')
                $setdata2['houseno']=$this->input->post('value');

                if($this->input->post('key')=='other_city')
                $setdata2['other_city']=$this->input->post('value');

                if($this->input->post('key')=='other_pincode')
                $setdata2['other_pincode']=$this->input->post('value');

                if($this->input->post('key')=='city')
                $setdata2['city']=$this->input->post('value');

                if($this->input->post('key')=='pincode')
                $setdata2['pincode']=$this->input->post('value');

                if($this->input->post('key')=='state')
                $setdata2['state']=$this->input->post('value');
                
                if($this->input->post('key')=='vintage')
                $setdata2['vintage']=$this->input->post('value');

                if($this->input->post('key')=='turn_over')
                $setdata2['turn_over']=$this->input->post('value');

                if($this->input->post('key')=='business_type')
                $setdata2['business_type']=$this->input->post('value');

                if($this->input->post('key')=='nature_of_business')
                $setdata2['nature_of_business']=$this->input->post('value');

                if($this->input->post('key')=='desired_amount')
                $setdata2['desired_amount']=$this->input->post('value');

                if($this->input->post('key')=='type_of_nature')
                $setdata2['type_of_nature']=$this->input->post('value');

                if($this->input->post('key')=='reference')
                $setdata2['reference']=$this->input->post('value');

                if($this->input->post('key')=='reference_number')
                $setdata2['reference_number']=$this->input->post('value');

                if($this->input->post('key')=='no_of_partner')
                $setdata2['total_director_partner']=$this->input->post('value');
                
                if($this->input->post('key')=='no_of_director')
                $setdata2['total_director_partner']=$this->input->post('value');

                if($this->input->post('key')=='loan_type1')
                $setdata2['loan_type1']=$this->input->post('value');

                if($this->input->post('key')=='pan_number')
                $setdata2['pan_number']=$this->input->post('value');

                if($this->input->post('key')=='business_address')
                $setdata2['business_address']=$this->input->post('value');
                
                if($this->input->post('key')=='resident_address')
                $setdata2['resident_address']=$this->input->post('value');

                if($this->input->post('key')=='gstnumber')
                $setdata2['gst_number']=$this->input->post('value');
                
                // $data = $this->common_model->GetRow(TBL_USERS,['user_id'=>$record->user_id]);
                // $set=[];
                // $set['incomplete_status']=5;
                // if($data){
                //     $this->common_model->UpdateData(TBL_USERS,$set,['user_id'=>$record->user_id]);
                // }

                $detail=$this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$record->user_id]);
                if($detail){
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata2,['user_id'=>$record->user_id]);
                }else{
                    $setdata2['user_id']=$record->user_id;
                    $this->common_model->InsertData(TBL_USER_DETAIL,$setdata2);
                }
            
            }

            return response(['status'=>'success']);
        }
    }
    public function SaveApplicant(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $record=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('phone')]);
            $insertId=$record->user_id;
            $this->common_model->DeleteData(TBL_USER_COAPPLICANT,['user_id'=>$record->user_id]);
            $count = count($this->input->post('co_pan_number'));
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

        }
    }
    public function validate_username(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $username=$this->input->post('username');
            $data = $this->common_model->GetRow(TBL_USERS,['user_name'=>$username]);
            if($data){
                return response(['status'=>"fail",'message'=>'Trade Name Already Exists']);
            }else{
                return response(['status'=>"success",'message'=>'Successful']);
            }
        }
    }
    public function loan_documents(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $record= $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('phone')]);
            $setdata2=[];

            if($this->input->post('no_of_partner'))
            $setdata2['total_director_partner']=$this->input->post('no_of_partner');
            
            if($this->input->post('no_of_director'))
            $setdata2['total_director_partner']=$this->input->post('no_of_director');

            if($this->input->post('pan_number'))
            $setdata2['pan_number']=$this->input->post('pan_number');
            
            if($this->input->post('business_address'))
            $setdata2['business_address']=$this->input->post('business_address');
            
            if($this->input->post('resident_address'))
            $setdata2['resident_address']=$this->input->post('resident_address');

            if($this->input->post('gstnumber'))
            $setdata2['gst_number']=$this->input->post('gstnumber');
            
            if($this->input->post('bankstatement_password') && $this->input->post('bankstatement_password')!='undefined')
            $setdata2['bankstatement_password']=$this->input->post('bankstatement_password');

            if(!empty($this->input->post('base_pancard_'))){
                $count=$this->input->post('base_pancard_');
                $filedata=[];
                $newindex=1;
                for($i=0;$i<count($count);$i++){
                    $string=explode('@kk@',$this->input->post('base_pancard_')[$i]);
                    if(strlen($string[0])>50){
                        $contents = file_get_contents($string[0]);
                        if(!empty($contents)){
                            $filename=$record->file_id.'-'.$newindex.'-pancard.'.end($string);
                            $filedata[]=$filename;
                            uploadFile(UPLOADS_DIR.'merchant/pancard/'.$filename,$contents);
                            $newindex++;
                        }
                    }else{
                        $filedata[]=$string[0];
                    }
                }
                if(!empty($filedata)){
                    $setdata2['pancard_image']=implode(',',$filedata);
                }
            }
            if(!empty($this->input->post('base_gstnumber_'))){
                $count=$this->input->post('base_gstnumber_');
                $filedata=[];
                $newindex=1;
                for($i=0;$i<count($count);$i++){
                    $string=explode('@kk@',$this->input->post('base_gstnumber_')[$i]);
                    if(strlen($string[0])>50){
                        $contents = file_get_contents($string[0]);
                        if(!empty($contents)){
                            $filename=$record->file_id.'-'.$newindex.'-gstproof.'.end($string);
                            $filedata[]=$filename;
                            uploadFile(UPLOADS_DIR.'merchant/gst/'.$filename,$contents);
                            $newindex++;
                        }
                    }else{
                        $filedata[]=$string[0];
                    }
                }
                if(!empty($filedata)){
                    $setdata2['gstproof_image']=implode(',',$filedata);
                }
            }
            if(!empty($this->input->post('base_business_proof_'))){
                $count=$this->input->post('base_business_proof_');
                $filedata=[];
                $newindex=1;
                for($i=0;$i<count($count);$i++){
                    $string=explode('@kk@',$this->input->post('base_business_proof_')[$i]);
                    if(strlen($string[0])>50){
                        $contents = file_get_contents($string[0]);
                        if(!empty($contents)){
                            $filename=$record->file_id.'-'.$newindex.'-businessproof.'.end($string);
                            $filedata[]=$filename;
                            uploadFile(UPLOADS_DIR.'merchant/business/'.$filename,$contents);
                            $newindex++;
                        }
                    }else{
                        $filedata[]=$string[0];
                    }
                }
                if(!empty($filedata)){
                    $setdata2['business_address_proof']=implode(',',$filedata);
                }
            }
            if(!empty($this->input->post('base_resident_address_'))){
                $count=$this->input->post('base_resident_address_');
                $filedata=[];
                $newindex=1;
                for($i=0;$i<count($count);$i++){
                    $string=explode('@kk@',$this->input->post('base_resident_address_')[$i]);
                    if(strlen($string[0])>50){
                        $contents = file_get_contents($string[0]);
                        if(!empty($contents)){
                            $filename=$record->file_id.'-'.$newindex.'-residenceproof.'.end($string);
                            $filedata[]=$filename;
                            uploadFile(UPLOADS_DIR.'merchant/resident/'.$filename,$contents);
                            $newindex++;
                        }
                    }else{
                        $filedata[]=$string[0];
                    }
                }
                if(!empty($filedata)){
                    $setdata2['resident_address_proof']=implode(',',$filedata);
                }
            }
            if(!empty($this->input->post('base_tan_'))){
                $count=$this->input->post('base_tan_');
                $filedata=[];
                $newindex=1;
                for($i=0;$i<count($count);$i++){
                    $string=explode('@kk@',$this->input->post('base_tan_')[$i]);
                    if(strlen($string[0])>50){
                        $contents = file_get_contents($string[0]);
                        if(!empty($contents)){
                            $filename=$record->file_id.'-'.$newindex.'-moa-aoa-proof.'.end($string);
                            $filedata[]=$filename;
                            uploadFile(UPLOADS_DIR.'merchant/tan/'.$filename,$contents);
                            $newindex++;
                        }
                    }else{
                        $filedata[]=$string[0];
                    }
                }
                if(!empty($filedata)){
                    $setdata2['tan_image']=implode(',',$filedata);
                }
            }
            if(!empty($this->input->post('base_coi_firm_'))){
                $count=$this->input->post('base_coi_firm_');
                $filedata=[];
                $newindex=1;
                for($i=0;$i<count($count);$i++){
                    $string=explode('@kk@',$this->input->post('base_coi_firm_')[$i]);
                    if(strlen($string[0])>50){
                        $contents = file_get_contents($string[0]);
                        if(!empty($contents)){
                            $filename=$record->file_id.'-'.$newindex.'-coi.'.end($string);
                            $filedata[]=$filename;
                            uploadFile(UPLOADS_DIR.'merchant/coi/'.$filename,$contents);
                            $newindex++;
                        }
                    }else{
                        $filedata[]=$string[0];
                    }
                }
                if(!empty($filedata)){
                    $setdata2['coi_image']=implode(',',$filedata);
                }
            }
            if(!empty($this->input->post('base_bankstatement_'))){
                $count=$this->input->post('base_bankstatement_');
                $filedata=[];
                $newindex=1;
                for($i=0;$i<count($count);$i++){
                    $string=explode('@kk@',$this->input->post('base_bankstatement_')[$i]);
                    if(strlen($string[0])>50){
                        $contents = file_get_contents($string[0]);
                        if(!empty($contents)){
                            $filename=$record->file_id.'-'.$newindex.'-bankstatement.'.end($string);
                            $filedata[]=$filename;
                            uploadFile(UPLOADS_DIR.'merchant/bankstatement/'.$filename,$contents);
                            $newindex++;
                        }
                    }else{
                        $filedata[]=$string[0];
                    }
                }
                if(!empty($filedata)){
                    $setdata2['bank_statement']=implode(',',$filedata);
                }
            }
            if(!empty($this->input->post('base_ownership_'))){
                $count=$this->input->post('base_ownership_');
                $filedata=[];
                $newindex=1;
                for($i=0;$i<count($count);$i++){
                    $string=explode('@kk@',$this->input->post('base_ownership_')[$i]);
                    if(strlen($string[0])>50){
                        $contents = file_get_contents($string[0]);
                        if(!empty($contents)){
                            $filename=$record->file_id.'-'.$newindex.'-ownership.'.end($string);
                            $filedata[]=$filename;
                            uploadFile(UPLOADS_DIR.'merchant/ownership/'.$filename,$contents);
                            $newindex++;
                        }
                    }else{
                        $filedata[]=$string[0];
                    }
                }
                if(!empty($filedata)){
                    $setdata2['ownership_proof']=implode(',',$filedata);
                }
            }
            if(!empty($this->input->post('base_partnership_'))){
                $count=$this->input->post('base_partnership_');
                $filedata=[];
                $newindex=1;
                for($i=0;$i<count($count);$i++){
                    $string=explode('@kk@',$this->input->post('base_partnership_')[$i]);
                    if(strlen($string[0])>50){
                        $contents = file_get_contents($string[0]);
                        if(!empty($contents)){
                            $filename=$record->file_id.'-'.$newindex.'-partnership.'.end($string);
                            $filedata[]=$filename;
                            uploadFile(UPLOADS_DIR.'merchant/partnership/'.$filename,$contents);
                            $newindex++;
                        }
                    }else{
                        $filedata[]=$string[0];
                    }
                }
                if(!empty($filedata)){
                    $setdata2['partnership_deal']=implode(',',$filedata);
                }
            }
            if(!empty($this->input->post('base_resolution_'))){
                $count=$this->input->post('base_resolution_');
                $filedata=[];
                $newindex=1;
                for($i=0;$i<count($count);$i++){
                    $string=explode('@kk@',$this->input->post('base_resolution_')[$i]);
                    if(strlen($string[0])>50){
                        $contents = file_get_contents($string[0]);
                        if(!empty($contents)){
                            $filename=$record->file_id.'-'.$newindex.'-board-resolution.'.end($string);
                            $filedata[]=$filename;
                            uploadFile(UPLOADS_DIR.'merchant/boardresolution/'.$filename,$contents);
                            $newindex++;
                        }
                    }else{
                        $filedata[]=$string[0];
                    }
                }
                if(!empty($filedata)){
                    $setdata2['boardresolution']=implode(',',$filedata);
                }
            }
            if(!empty($this->input->post('base_itr_'))){
                $count=$this->input->post('base_itr_');
                $filedata=[];
                $newindex=1;
                for($i=0;$i<count($count);$i++){
                    $string=explode('@kk@',$this->input->post('base_itr_')[$i]);
                    if(strlen($string[0])>50){
                        $contents = file_get_contents($string[0]);
                        if(!empty($contents)){
                            $filename=$record->file_id.'-'.$newindex.'-itr.'.end($string);
                            $filedata[]=$filename;
                            uploadFile(UPLOADS_DIR.'merchant/itr/'.$filename,$contents);
                            $newindex++;
                        }
                    }else{
                        $filedata[]=$string[0];
                    }
                }
                if(!empty($filedata)){
                    $setdata2['itr_docs']=implode(',',$filedata);
                }
            }
            if(!empty($this->input->post('base_canceled_cheque_'))){
                $count=$this->input->post('base_canceled_cheque_');
                $filedata=[];
                $newindex=1;
                for($i=0;$i<count($count);$i++){
                    $string=explode('@kk@',$this->input->post('base_canceled_cheque_')[$i]);
                    if(strlen($string[0])>50){
                        $contents = file_get_contents($string[0]);
                        if(!empty($contents)){
                            $filename=$record->file_id.'-'.$newindex.'-cancelled_cheque.'.end($string);
                            $filedata[]=$filename;
                            uploadFile(UPLOADS_DIR.'merchant/canceled_cheque/'.$filename,$contents);
                            $newindex++;
                        }
                    }else{
                        $filedata[]=$string[0];
                    }
                }
                if(!empty($filedata)){
                    $setdata2['cheque_docs']=implode(',',$filedata);
                }
            }
            if(!empty($this->input->post('base_additional_docs_'))){
                $count=$this->input->post('base_additional_docs_');
                $filedata=[];
                $newindex=1;
                for($i=0;$i<count($count);$i++){
                    $string=explode('@kk@',$this->input->post('base_additional_docs_')[$i]);
                    if(strlen($string[0])>50){
                        $contents = file_get_contents($string[0]);
                        if(!empty($contents)){
                            $filename=$record->file_id.'-'.$newindex.'-additional_docs.'.end($string);
                            $filedata[]=$filename;
                            uploadFile(UPLOADS_DIR.'merchant/addition_docs/'.$filename,$contents);
                            $newindex++;
                        }
                    }else{
                        $filedata[]=$string[0];
                    }
                }
                if(!empty($filedata)){
                    $setdata2['additional_docs']=implode(',',$filedata);
                }
            }
            $set=[];
            $set['incomplete_status'] = 3;
            $insertId=$record->user_id;
            $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata2,['user_id'=>$insertId]);
            $this->common_model->UpdateData(TBL_USERS,$set,['user_id'=>$insertId]);
            $this->common_model->DeleteData(TBL_USER_PARTNER,['user_id'=>$insertId]);
            if($this->input->post('business_type')!='Individual' && $this->input->post('business_type')!='Proprietorship'){
                $docName='partner';
                if($this->input->post('business_type')=='Partnership'){
                    $docName='director';
                }
                $newrowcount=1;
                for($i=0;$i<$setdata2['total_director_partner'];$i++){
                    $setdata3=[];
                    if($this->input->post('other_pan_number')[$i])
                    $setdata3['pan_number']=$this->input->post('other_pan_number')[$i];

                    if($this->input->post('other_address')[$i])
                    $setdata3['address']=$this->input->post('other_address')[$i];

                    if($this->input->post('other_name')[$i])
                    $setdata3['name']=$this->input->post('other_name')[$i];
                    if(!empty($this->input->post('other_name_proof'.$i))){
                        $filedata=[];
                        $newindex=1;
                        for($j=0;$j<count($this->input->post('other_name_proof'.$i));$j++){
                            $string=explode('@kk@',$this->input->post('other_name_proof'.$i)[$j]);
                            if(strlen($string[0])>50){
                                $contents = file_get_contents($string[0]);
                                if(!empty($contents)){
                                    $filename=$record->file_id.'-'.$newindex.'-'.$newrowcount.'-'.$docName.'_name_proof.'.end($string);
                                    $filedata[]=$filename;
                                    uploadFile(UPLOADS_DIR.'merchant/other/'.$filename,$contents);
                                    $newindex++;
                                }
                            }else{
                                $filedata[]=$string[0];
                            }
                        }
                        if(!empty($filedata)){
                            $setdata3['director_partner_proof']=implode(',',$filedata);
                        }
                    }
                    if(!empty($this->input->post('other_pancard'.$i))){
                        $filedata=[];
                        $newindex=1;
                        for($j=0;$j<count($this->input->post('other_pancard'.$i));$j++){
                            $string=explode('@kk@',$this->input->post('other_pancard'.$i)[$j]);
                            if(strlen($string[0])>50){
                                $contents = file_get_contents($string[0]);
                                if(!empty($contents)){
                                    $filename=$record->file_id.'-'.$newindex.'-'.$newrowcount.'-'.$docName.'_pancard.'.end($string);
                                    $filedata[]=$filename;
                                    uploadFile(UPLOADS_DIR.'merchant/other/'.$filename,$contents);
                                    $newindex++;
                                }
                            }else{
                                $filedata[]=$string[0];
                            }
                        }
                        if(!empty($filedata)){
                            $setdata3['pancard_image']=implode(',',$filedata);
                        }
                    }
                    if(!empty($this->input->post('other_address'.$i))){
                        $filedata=[];
                        $newindex=1;
                        for($j=0;$j<count($this->input->post('other_address'.$i));$j++){
                            $string=explode('@kk@',$this->input->post('other_address'.$i)[$j]);
                            if(strlen($string[0])>50){
                                $contents = file_get_contents($string[0]);
                                if(!empty($contents)){
                                    $filename=$record->file_id.'-'.$newindex.'-'.$newrowcount.'-'.$docName.'_address_proof.'.end($string);
                                    $filedata[]=$filename;
                                    uploadFile(UPLOADS_DIR.'merchant/other/'.$filename,$contents);
                                    $newindex++;
                                }
                            }else{
                                $filedata[]=$string[0];
                            }
                        }
                        if(!empty($filedata)){
                            $setdata3['address_proof']=implode(',',$filedata);
                        }
                    }
                    
                    if(!empty($setdata3)){
                        $setdata3['user_id']=$insertId;
                        $this->common_model->InsertData(TBL_USER_PARTNER,$setdata3);
                    }
                    $newrowcount++;
                }
            }
            return response(['status'=>"success",'message'=>'Successful']);
        }
    }
    public function personalDocuments(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $user=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('mobile_number')]);
            if($user){
                $setdata=[];
                if($this->input->post('bankstatement_password')){
                    $setdata['bankstatement_password']=$this->input->post('bankstatement_password');
                }
                if(!empty($this->input->post('base_pancard_'))){
                    $count=$this->input->post('base_pancard_');
                    $filedata=[];
                    $newindex=1;
                    for($i=0;$i<count($count);$i++){
                        $string=explode('@kk@',$this->input->post('base_pancard_')[$i]);
                        if(strlen($string[0])>50){
                            $contents = file_get_contents($string[0]);
                            if(!empty($contents)){
                                $filename=$user->file_id.'-'.$newindex.'-pancard.'.end($string);
                                $filedata[]=$filename;
                                uploadFile(UPLOADS_DIR.'merchant/pancard/'.$filename,$contents);
                                $newindex++;
                            }
                        }else{
                            $filedata[]=$string[0];
                        }
                    }
                    if(!empty($filedata)){
                        $setdata['pancard_image']=implode(',',$filedata);
                    }
                }
                if(!empty($this->input->post('base_aadharcard_'))){
                    $count=$this->input->post('base_aadharcard_');
                    $filedata=[];
                    $newindex=1;
                    for($i=0;$i<count($count);$i++){
                        $string=explode('@kk@',$this->input->post('base_aadharcard_')[$i]);
                        if(strlen($string[0])>50){
                            $contents = file_get_contents($string[0]);
                            if(!empty($contents)){
                                $filename=$user->file_id.'-'.$newindex.'-aadharcard.'.end($string);
                                $filedata[]=$filename;
                                uploadFile(UPLOADS_DIR.'merchant/aadharcard/'.$filename,$contents);
                                $newindex++;
                            }
                        }else{
                            $filedata[]=$string[0];
                        }
                    }
                    if(!empty($filedata)){
                        $setdata['aadhar_image']=implode(',',$filedata);
                    }
                }
                if(!empty($this->input->post('base_salery_slip_'))){
                    $count=$this->input->post('base_salery_slip_');
                    $filedata=[];
                    $newindex=1;
                    for($i=0;$i<count($count);$i++){
                        $string=explode('@kk@',$this->input->post('base_salery_slip_')[$i]);
                        if(strlen($string[0])>50){
                            $contents = file_get_contents($string[0]);
                            if(!empty($contents)){
                                $filename=$user->file_id.'-'.$newindex.'-salary_slip.'.end($string);
                                $filedata[]=$filename;
                                uploadFile(UPLOADS_DIR.'merchant/salery_slip/'.$filename,$contents);
                                $newindex++;
                            }
                        }else{
                            $filedata[]=$string[0];
                        }
                    }
                    if(!empty($filedata)){
                        $setdata['salery_slip']=implode(',',$filedata);
                    }
                }
                if(!empty($this->input->post('base_bankstatement_'))){
                    $count=$this->input->post('base_bankstatement_');
                    $filedata=[];
                    $newindex=1;
                    for($i=0;$i<count($count);$i++){
                        $string=explode('@kk@',$this->input->post('base_bankstatement_')[$i]);
                        if(strlen($string[0])>50){
                            $contents = file_get_contents($string[0]);
                            if(!empty($contents)){
                                $filename=$user->file_id.'-'.$newindex.'-bankstatement.'.end($string);
                                $filedata[]=$filename;
                                uploadFile(UPLOADS_DIR.'merchant/bankstatement/'.$filename,$contents);
                                $newindex++;
                            }
                        }else{
                            $filedata[]=$string[0];
                        }
                    }
                    if(!empty($filedata)){
                        $setdata['bank_statement']=implode(',',$filedata);
                    }
                }
                if(!empty($this->input->post('base_residence_address_proof_'))){
                    $count=$this->input->post('base_residence_address_proof_');
                    $filedata=[];
                    $newindex=1;
                    for($i=0;$i<count($count);$i++){
                        $string=explode('@kk@',$this->input->post('base_residence_address_proof_')[$i]);
                        if(strlen($string[0])>50){
                            $contents = file_get_contents($string[0]);
                            if(!empty($contents)){
                                $filename=$user->file_id.'-'.$newindex.'-residence_address.'.end($string);
                                $filedata[]=$filename;
                                uploadFile(UPLOADS_DIR.'merchant/resident/'.$filename,$contents);
                                $newindex++;
                            }
                        }else{
                            $filedata[]=$string[0];
                        }
                    }
                    if(!empty($filedata)){
                        $setdata['residence_address_proof']=implode(',',$filedata);
                    }
                }
                if(!empty($this->input->post('base_itr_'))){
                    $count=$this->input->post('base_itr_');
                    $filedata=[];
                    $newindex=1;
                    for($i=0;$i<count($count);$i++){
                        $string=explode('@kk@',$this->input->post('base_itr_')[$i]);
                        if(strlen($string[0])>50){
                            $contents = file_get_contents($string[0]);
                            if(!empty($contents)){
                                $filename=$user->file_id.'-'.$newindex.'-itr.'.end($string);
                                $filedata[]=$filename;
                                uploadFile(UPLOADS_DIR.'merchant/itr/'.$filename,$contents);
                                $newindex++;
                            }
                        }else{
                            $filedata[]=$string[0];
                        }
                    }
                    if(!empty($filedata)){
                        $setdata['itr_docs']=implode(',',$filedata);
                    }
                }
                if(!empty($this->input->post('base_cheque_'))){
                    $count=$this->input->post('base_cheque_');
                    $filedata=[];
                    $newindex=1;
                    for($i=0;$i<count($count);$i++){
                        $string=explode('@kk@',$this->input->post('base_cheque_')[$i]);
                        if(strlen($string[0])>50){
                            $contents = file_get_contents($string[0]);
                            if(!empty($contents)){
                                $filename=$user->file_id.'-'.$newindex.'-cancelled_cheque.'.end($string);
                                $filedata[]=$filename;
                                uploadFile(UPLOADS_DIR.'merchant/canceled_cheque/'.$filename,$contents);
                                $newindex++;
                            }
                        }else{
                            $filedata[]=$string[0];
                        }
                    }
                    if(!empty($filedata)){
                        $setdata['cheque_docs']=implode(',',$filedata);
                    }
                }
                $detail=$this->common_model->GetRow('user_detail',['user_id'=>$user->user_id]);
                if($detail){
                    $this->common_model->UpdateData('user_detail',$setdata,['user_id'=>$user->user_id]);
                }else{
                    $setdata['user_id']=$user->user_id;
                    $this->common_model->InsertData('user_detail',$setdata);
                }
                return response(['status'=>'success']);
            }else{
                return response(['status'=>'fail']);
            }
        }
    }
    public function PersonalRegistration(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $user=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('mobile_number')]);
            if($user){
                $setdata=[];
                $detail=$this->common_model->GetRow('user_detail',['user_id'=>$user->user_id]);
                if($detail){
                    $setdata['reference']=$this->input->post('reference');
                    $setdata['reference_number']=$this->input->post('reference_number');
                    $this->common_model->UpdateData('user_detail',$setdata,['user_id'=>$user->user_id]);
                    $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$user->user_id]);
                    if($user->status=='INCOMPLETE'){
                        $checkdocuments = $this->common_model->GetRow('user_detail',['user_id'=>$user->user_id,'pancard_image!='=>NULL,'bank_statement!='=>NULL]);
                        if($checkdocuments){
                            if($user->created_by=='1793' && $user->other_app_user_id!=""){
                                $payToken = $this->GetPay1Token();
                                if(!empty($payToken) && !empty($payToken['api_token'])){
                                    $pay1_data=$this->common_model->GetRow('pay1_data',['user_id'=>$user->other_app_user_id]);
                                    if(!empty($pay1_data)){
                                        $token=$payToken['api_token'];
                                        $url='http://loandev.pay1.in/sdk/loans/'.$user->file_id;
                                        $headers=['x-api-token:Basic '.$token,'Content-type:application/json'];
                                        $setpay1=[];
                                        $setpay1['user_id']=$record->other_app_user_id;
                                        $setpay1['interest_rate_yearly']=null;
                                        $setpay1['emi_counts']=0;
                                        $setpay1['amount_disbursed']=null;
                                        $setpay1['loan_uid']=$record->file_id;
                                        $setpay1['loan_amount']=null;
                                        $setpay1['processing_fee']=$pay1_data->processing_fees;
                                        $setpay1['tenure']=$pay1_data->tenure_in_days;
                                        $setpay1['emi_amount_interest']=null;
                                        $setpay1['emi_amount']=null;
                                        $setpay1['type']=1;
                                        $setpay1['amount_offered']=$pay1_data->approved_amount;
                                        $setpay1['emi_amount_principle']=null;
                                        $this->CallApi($url,$headers,$setpay1);
                                    }
                                }
                            }
                            $caselog=[];
                            $caselog['merchant_id']=$user->user_id;
                            $caselog['change_by']='public url';
                            $caselog['change_by_user_type']=null;
                            $caselog['log_text']='Received Case';
                            $caselog['log_type']='STATUS';
                            $caselog['status']='RECEIVED';
                            $this->common_model->InsertData('case_log',$caselog);
                            $this->common_model->UpdateData(TBL_USERS,['status'=>null,'received_time'=>date('Y-m-d H:i:s')],['user_id'=>$user->user_id]);
                        }
                    }
                    
                    $shortclose=$this->common_model->GetRow('user_lender_assign',['merchant_id'=>$user->user_id,'lender_id'=>null,'status'=>'SHORTCLOSE']);
                    if(!empty($shortclose)){
                        $this->common_model->DeleteData('user_lender_assign',['id'=>$shortclose->id]);
                    }
                    return response(['status'=>'success']);
                }
            }
            $setdata2=[];
            $setdata2['incomplete_status']=11;
            $this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$record->user_id]);
        }
    }
    
    public function PersonalAutoSave(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata[$this->input->post('key')]=$this->input->post('value');
            $user=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('mobile_number')]);
            $detail=$this->common_model->GetRow('user_detail',['user_id'=>$user->user_id]);
            if(!empty($detail)){
                $this->common_model->UpdateData('user_detail',$setdata,['user_id'=>$user->user_id]);
            }else{
                $setdata['user_id']=$user->user_id;
                $this->common_model->InsertData('user_detail',$setdata);
            }
            return response(['status'=>'success']);
        }
    }
    public function UploadPersonalExtraField(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['date_of_birth']=$this->input->post('date_of_birth');
            $setdata['employer_name']=$this->input->post('employer_name');
            $setdata['company_pincode']=$this->input->post('company_pincode');
            $setdata['company_state']=$this->input->post('company_state');
            $setdata['company_city']=$this->input->post('company_city');
            $setdata['residence_state']=$this->input->post('residence_state');
            $setdata['residence_city']=$this->input->post('residence_city');
            $setdata['residence_pincode']=$this->input->post('residence_pincode');
            $user=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('mobile_number')]);
            $detail=$this->common_model->GetRow('user_detail',['user_id'=>$user->user_id]);
            if(!empty($detail)){
                $this->common_model->UpdateData('user_detail',$setdata,['user_id'=>$user->user_id]);
            }else{
                $setdata['user_id']=$user->user_id;
                $this->common_model->InsertData('user_detail',$setdata);
            }
            $setdata2=[];
            $setdata2['incomplete_status']=10;
            $this->common_model->UpdateData('users',$setdata2,['user_id'=>$user->user_id]);
            return response(['status'=>'success']);
        }
    }
    public function UploadCoApplicantDocs(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $user=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('phone')]);
            $this->common_model->DeleteData(TBL_USER_COAPPLICANT,['user_id'=>$user->user_id]);
            $count = count($this->input->post('co_pan_number'));
            for($i=0;$i<$count;$i++){
                $setdata=[];
                $setdata['name']=$this->input->post('co_name')[$i];
                $setdata['pan_number']=$this->input->post('co_pan_number')[$i];
                $setdata['relationship']=$this->input->post('co_relationship')[$i];
                
                if(!empty($this->input->post('base_co_pancard_'.$i))){
                    $count1=$this->input->post('base_co_pancard_'.$i);
                    $filedata=[];
                    $newrowcount=1;
                    $newindex=0;
                    for($j=0;$j<count($count1);$j++){
                        $string=explode('@kk@',$this->input->post('base_co_pancard_'.$i)[$j]);
                        if(strlen($string[0])>50){
                            $contents = file_get_contents($string[0]);
                            if(!empty($contents)){
                                $filename=$user->file_id.'-'.$newindex.'-co-applicant-pancard.'.end($string);
                                $filedata[]=$filename;
                                uploadFile(UPLOADS_DIR.'merchant/pancard/'.$filename,$contents);
                                $newindex++;
                            }
                        }else{
                            $filedata[]=$string[0];
                        }
                    }
                    if(!empty($filedata)){
                        $setdata['pancard_image']=implode(',',$filedata);
                    }
                }
                if(!empty($setdata&&$setdata2)){
                    $setdata['user_id']=$user->user_id;
                    $this->common_model->InsertData(TBL_USER_COAPPLICANT,$setdata);
                    $this->common_model->UpdateData(TBL_USERS,$setdata2,['user_id'=>$record->user_id]);
                   
                }  
            }
            $setdata2=[];
            $setdata2['incomplete_status']=13;
            $this->common_model->UpdateData(TBL_USERS,$setdata2,['user_id'=>$record->user_id]);
            return response(['status'=>'success']);
        }
    }
    public function PartnerWithUs(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            
            return response(['status'=>'success']);
            
        }
    }
    public function UploadBusinessData(){
        $record= $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('phone'),'status'=>'INCOMPLETE']);
        $setdata=[];
        if($this->input->post('business_name')){
            $setdata['company_name']=$this->input->post('business_name');
            $setdata['incomplete_status']=12;
            $this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$record->user_id]);
        }
        $setdata2=[];
        $setdata2['pincode']=$this->input->post('pincode');
        $setdata2['state']=$this->input->post('state');
        $setdata2['city']=$this->input->post('city');
        $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata2,['user_id'=>$record->user_id]);
        return response(['status'=>"success",'message'=>'Successful']);
    }
    public function GetStatus(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $record = $this->common_model->GetRow(TBL_USERS,['user_type'=>'MERCHANT','file_id'=>$this->input->post('caseid')]);
            if($record){
                if(password_verify($this->input->post('password'),$record->password)){
                    $data=[];
                    $assign = $this->common_model->GetRow('user_lender_assign',['merchant_id'=>$record->user_id]);
                    $currentstatus='';
                    if(!empty($assign)){
                        $currentstatus=$assign->status;
                    }elseif(!empty($row->status) && $row->status=='INCOMPLETE'){
                        $currentstatus='INCOMPLETE';
                    }else{
                        $currentstatus='RECEIVED';
                    }
                    $data['full_name']=$record->full_name;
                    $data['mobile_number']=$record->mobile_number;
                    $data['email']=$record->email;
                    $data['file_id']=$record->file_id;
                    $data['status']=$currentstatus;
                    return response(['status'=>'success','data'=>$data]);
                }else{
                    return response(['status'=>'fail','data'=>['password_error'=>'Invalid Password','caseid_error'=>'']]);
                }
            }else{
                return response(['status'=>'fail','data'=>['caseid_error'=>'Invalid Case Id','password_error'=>'']]);
            }
        }
    }
    private function GetPay1Token(){
        $url='https://loan.pragaticapital.in/sdk/tokens';
        $username=base64_encode("fintranxect:p@y1@f!n+r@nkey");
        $headers=['Authorization:Basic '.$username,'Content-type:application/json'];
        $response = $this->CallApi($url,$headers,[]);
        return json_decode($response,true);
    }
    private function CallApi($url,$headers,$data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        if(!empty($data)){
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $response;
    }
    public function CheckSelectCity(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            if($this->input->post('city')!='Other'){
                $state=$this->common_model->GetRow('states',['name'=>$this->input->post('state'),'country_id'=>'101']);
                $record = $this->common_model->GetRow('cities',['name'=>$this->input->post('city')]);
                if($record && $state){
                    $pincode = $this->db->select('pincode')->from('pincode')->where(['city'=>strtoupper($record->name),'state_id'=>$state->id])->group_by('pincode')->get()->result();
                    $html='<option value="">Pincode</option>';
                    if($pincode){
                        foreach($pincode as $pin){
                            $selected="";
                            if($this->input->post('pincode')==$pin->pincode){
                                $selected="selected";
                            }
                            $html.='<option value="'.$pin->pincode.'" '.$selected.'>'.$pin->pincode.'</option>';
                        }
                    }
                    $selected="";
                    if($this->input->post('pincode')=='Other'){
                        $selected="selected";
                    }
                    $html.='<option value="Other" '.$selected.'>Other</option>';
                    return response(['status'=>'success','pincode'=>$html]);
                }else{
                    $selected="";
                    if($this->input->post('pincode')=='Other'){
                        $selected="selected";
                    }
                    $html='<option value="">Pincode</option><option value="Other"  '.$selected.'>Other</option>';
                    return response(['status'=>'success','pincode'=>$html]);
                }
            }else{
                $selected="";
                if($this->input->post('pincode')=='Other'){
                    $selected="selected";
                }
                $html='<option value="">Pincode</option><option value="Other" '.$selected.'>Other</option>';
                return response(['status'=>'success','pincode'=>$html]);
            }
        }
    }
    public function checkAddressError(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $user=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('phone')]);
            $state=$this->common_model->GetRow('states',['name'=>$this->input->post('state'),'country_id'=>'101']);
            $record = $this->common_model->GetRow('cities',['name'=>$this->input->post('city'),'state_id'=>$state->id]);
            if($record){
                $pincode = $this->common_model->GetRow('pincode',['pincode'=>$this->input->post('pincode'),'city'=>strtoupper($record->name)]);
                if($pincode){
                    return response(['status'=>"success"]);
                }else{
                    return response(['status'=>"fail",'city_error'=>'','pincode_error'=>'Please enter correct city pincode']);
                }
            }else{
                return response(['status'=>"fail",'city_error'=>'City does not exist in our record.','pincode_error'=>'']);
            }
            $setdata[]='';
            $setdata['incomplete_status']=8;
            $this->common_model->UpdateData(TBL_USER,$setdata,['user_id'=>$record->user_id]);
        }
    }
    public function check_upload_documents(){
        if($this->input->server('REQUEST_METHOD')=='POST'){

        }
    }
}