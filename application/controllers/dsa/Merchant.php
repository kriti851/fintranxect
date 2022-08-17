<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Merchant extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
        $this->load->helper('dsa');
        $this->load->model(['dsa/merchant_model']);
        isDsaLogin();
        if(!MainPermission(2)){
            redirect_dsa('dashboard');
        }
    }
    public function index(){
        $per_page=10;
        $search=$keyword="";
		if($this->input->get('per_page')){
			$per_page=$this->input->get('per_page');
		}
        $type=$this->input->get('type');
        if(!SubPermission(1) && $type==""){
            $type='incomplete';
        }
        $keyword=trim($this->input->get('keyword'));
        $date_range=$this->input->get('date_range');
        $loan_type=$this->input->get('loan_type');
        $order_by=$this->input->get('order_by');
        $record_type=$this->input->get('record_type');
        $remark=$this->input->get('remark');
        if($this->input->server('REQUEST_METHOD')=='GET'){
            $search="?record_type=".$this->input->get('record_type');
            if(!empty($type)){
                $search.='&type='.$type;
            }
            if(!empty($keyword)){
                $search.='&keyword='.$keyword;
            }
            if(!empty($loan_type)){
                $search.='&loan_type='.$loan_type;
            }
            if(!empty($order_by)){
                $search.='&order_by='.$order_by;
            }
            if(!empty($remark)){
                $search.='&remark='.$remark;
            }
        }
		$dsaid="";
        $config=GetPagination($per_page);
		$config['base_url'] = dsa_url("merchant".$search);	
		$config['total_rows'] = $this->merchant_model->CountMerchantList($keyword,$type,$date_range,$loan_type,$dsaid,$record_type,$remark);
        $this->data['total_rows']=$config['total_rows'];
        $this->load->library('pagination');
		$this->pagination->initialize($config);
		$this->data['pagination']=$this->pagination->create_links();
		$page=$this->input->get('page');
		if($page > 1){
			$page=($page-1)*$config["per_page"];
		}else{
			$page=0;
		}
		$this->data['results']=$this->merchant_model->MerchantList($config['per_page'],$page,$keyword,$type,$date_range,$loan_type,$dsaid,$order_by,$record_type,$remark);
        $this->data['content']="merchant/index";
        $this->data['script']="merchant/script";
        $this->load->view('dsa',$this->data);
    }
    public function detail($userid){
        if(SubPermission(18)){
            $this->common_model->UpdateData('comments',['is_read'=>'1'],['merchant_id'=>$userid,'is_read'=>0,'comment_by'=>$this->session->userdata('user_id'),'comment_for'=>'PARTNER']);
        }
        $this->data['comments']=$this->common_model->GetResult('comments',['comment_by'=>$this->session->userdata('user_id'),'merchant_id'=>$userid,'comment_for'=>'PARTNER']); 
        $record=$this->common_model->GetRow(TBL_USERS,['user_id'=>$userid]);
        if($record->loan_type=='Business'){
            $this->data['record'] = $this->merchant_model->GetUserDetail($userid);
            $this->data['content']="merchant/detail";
        }else{
            $this->data['record'] = $this->merchant_model->GetUserDetail2($userid);
            $this->data['content']="merchant/detail2";
        }
        $this->data['script']="merchant/detail_script";
        $this->load->view('dsa',$this->data);
    }
    public function IsResolved(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['is_read']=1;
            $setdata['admin_read']=0;
            $setdata['is_resolved']=$this->input->post('is_resolved');
            $setdata['resolved_by']='PARTNER';
            $this->common_model->UpdateData('comments',$setdata,['comment_id'=>$this->input->post('comment_id')]);

            $record=$this->common_model->GetRow('comments',['comment_id'=>$this->input->post('comment_id')]);
            $caselog=[];
            $caselog['merchant_id']=$record->merchant_id;
            $caselog['change_by']=$this->session->userdata('full_name');
            $caselog['change_by_user_type']=$this->session->userdata('user_type');
            $caselog['log_text']='Resovled status of comment ('.$record->comment.')';
            $caselog['log_type']='COMMENT';
            $this->common_model->InsertData('case_log',$caselog);
            $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s'),'comment_time'=>date('Y-m-d H:i:s')],['user_id'=>$record->merchant_id]);
            return response(['status'=>'success']);
        }
    }
    public function LeaveComments(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['merchant_id']=$this->input->post('merchant_id');
            $setdata['comment_by']=$this->input->post('comment_by');
            $setdata['comment']=$this->input->post('comment');
            $setdata['comment_for']=$this->input->post('comment_for');
            $setdata['is_read']='1';
            $setdata['commented_by']='PARTNER';
            $setdata['created_at']=date('Y-m-d H:i:s');
            if($insertId=$this->common_model->InsertData('comments',$setdata)){
                $merchant=$this->common_model->GetRow('user_lender_assign',['merchant_id'=>$this->input->post('merchant_id')]);
                if(!empty($merchant) && $merchant->status=='LOGGED'){
                    $this->common_model->UpdateData('user_lender_assign',['updated_at'=>date('Y-m-d H:i:s'),'status'=>'PENDING'],['merchant_id'=>$this->input->post('merchant_id')]);
                    $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s'),'pending_time'=>date('Y-m-d H:i:s')],['user_id'=>$this->input->post('merchant_id')]);
                }
                $caselog=[];
                $caselog['merchant_id']=$this->input->post('merchant_id');
                $caselog['change_by']=$this->session->userdata('full_name');
                $caselog['change_by_user_type']=$this->session->userdata('user_type');
                $caselog['log_text']=$this->input->post('comment');
                $caselog['log_type']='COMMENT';
                $this->common_model->InsertData('case_log',$caselog);
                $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s'),'comment_time'=>date('Y-m-d H:i:s')],['user_id'=>$this->input->post('merchant_id')]);
                return response(['status'=>'success','message'=>'Success','date'=>date('d M Y h:i A'),'comment_id'=>$insertId]);
            }else{
                return response(['status'=>'fail','message'=>'Failure']);
            }
        }
    }
    public function GetUserDetail(){
	    if($this->input->server('REQUEST_METHOD')=='POST'){
	        $data = $this->merchant_model->GetUserDetail($this->input->post('user_id'));
            if($data){
                 return response(['status'=>'Success','message'=>'Successful','data'=>$data]);
            }else{
                return response(['status'=>'Fail','message'=>'Opps Something Wrong']);
            }
	    }
    }
    public function add(){
        $active="";
        if(!empty($this->session->userdata('r_number'))){
            $record=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->session->userdata('r_number'),'status'=>'INCOMPLETE']);
            if(!empty($record)){
                if($record->loan_type=='Business'){
                    $active="tab2";
                    $record->applicant=$this->common_model->GetResult(TBL_USER_COAPPLICANT,['user_id'=>$record->user_id]);
                    $this->data['users']=$record;
                    $this->data['detail']=$this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$record->user_id]);
                    $this->data['partner']=$this->common_model->GetResult(TBL_USER_PARTNER,['user_id'=>$record->user_id]);
                }else{
                    $this->data['users']=$record;
                    $this->data['detail']=$this->common_model->GetRow('user_detail',['user_id'=>$record->user_id]);
                    $this->data['mobile_number']=$this->session->userdata('r_number');
                }
                $this->session->unset_userdata('r_number');
            }
        }
        $this->data['active']=$active;
        $this->data['states']=$this->common_model->GetResult(TBL_STATE,['country_id'=>101],'id,name');
        if(!empty($record) && $record->loan_type!='Business'){
            $this->data['content']="merchant/add2";
            $this->data['script']="merchant/add_script2";
        }elseif(!empty($record) && $record->loan_type=='Business'){
            $this->data['content']="merchant/add";
            $this->data['script']="merchant/add_script";
        }else{
            $this->data['content']="merchant/form";
            $this->data['script']="merchant/form_script";
        }
        $this->load->view('dsa',$this->data);
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
                        $caselog=[];
                        $caselog['merchant_id']=$insertId;
                        $caselog['change_by']=$this->session->userdata('full_name');
                        $caselog['change_by_user_type']=$this->session->userdata('user_type');
                        $caselog['log_text']='Received Case';
                        $caselog['log_type']='STATUS';
                        $caselog['status']='RECEIVED';
                        $this->common_model->InsertData('case_log',$caselog);
                        $this->common_model->UpdateData(TBL_USERS,['status'=>NULL,'received_time'=>date('Y-m-d H:i:s')],['user_id'=>$record->user_id]);
                
                    }
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
    public function UpdateInfo(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $record=$this->common_model->GetRow(TBL_USERS,['user_id'=>$this->input->post('merchant_id')]);
            $setdata['full_name']=$this->input->post('first_name').' '.$this->input->post('last_name');
            $setdata['email']=$this->input->post('email');
            $setdata['age']=$this->input->post('age');
            $setdata['loan_type']=$this->input->post('employment_type');
            $setdata['updated_at']=date('Y-m-d H:i:s');
            $setdata2=[];
            if(!empty($record)){
                if($this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$record->user_id])){
                    $insertId= $record->user_id;
                    if($this->input->post('employment_type')=='Business'){
                        $detaildata=$this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$record->user_id]);
                        if($detaildata){
                            $this->common_model->UpdateData(TBL_USER_DETAIL,['date_of_birth'=>$this->input->post('date_of_birth')],['user_id'=>$record->user_id]);
                        }else{
                            $this->common_model->InsertData(TBL_USER_DETAIL,['user_id'=>$record->user_id,'date_of_birth'=>$this->input->post('date_of_birth')]);
                        }
                    }
                    $this->session->set_userdata(['r_number'=>$record->mobile_number]);
                    return response(['status'=>"success",'message'=>'Successful','id'=>$insertId]);
                }else{
                    return response(['status'=>"fail",'message'=>'Failure']);
                }
            }
        }
    }
    public function edit_email_validation(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data = $this->common_model->GetRow(TBL_USERS,['user_id'=>$this->input->post('merchant_id')]);
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
    public function edit($user_id){
        $record=$this->common_model->GetRow(TBL_USERS,['user_id'=>$user_id]);
		if($this->session->userdata('r_number')){
            if($record->loan_type=='Business'){
                $active="tab2";
                $record->applicant=$this->common_model->GetResult(TBL_USER_COAPPLICANT,['user_id'=>$record->user_id]);
                $this->data['users']=$record;
                $this->data['detail']=$this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$record->user_id]);
                $this->data['partner']=$this->common_model->GetResult(TBL_USER_PARTNER,['user_id'=>$record->user_id]);
                $this->data['content']="merchant/add";
                $this->data['script']="merchant/add_script";
                $this->data['states'] = $this->common_model->GetResult(TBL_STATE,['country_id'=>101]);
                if(!empty($this->data['detail']->state)){ 
                    $state = $this->common_model->GetRow(TBL_STATE,['name'=>$this->data['detail']->state,'country_id'=>101]);
                    if(!empty($state) && $state->id!=""){
                        $this->data['cities'] = $this->common_model->GetResult(TBL_CITY,['state_id'=>$state->id]);
                    }else{
                        $this->data['cities']=[];
                    }
                }else{
                    $this->data['cities']=[];
                }
            }else{
                $this->data['users']=$record;
                $this->data['detail']=$this->common_model->GetRow('user_detail',['user_id'=>$record->user_id]);
                $this->data['mobile_number']=$this->session->userdata('r_number');
                $this->data['content']="merchant/add2";
                $this->data['script']="merchant/add_script2";
                $this->data['states'] = $this->common_model->GetResult(TBL_STATE,['country_id'=>101]);
            }
            $this->session->unset_userdata('r_number');
        }else{
            $this->data['users']=$record;
            if($record){
                $this->data['detail']=$this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$record->user_id]);
            }
            $this->data['content']="merchant/edit";
            $this->data['script']="merchant/edit_script";
        }

        $this->load->view('dsa',$this->data);
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
    public function IncompleteForm(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $record=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('phone')]);
            $setdata['full_name']=$this->input->post('first_name').' '.$this->input->post('last_name');
            if(empty($record)){
                $lastsubfileid=1;
                $lastMerchant=$this->common_model->GetOrderByRow(TBL_USERS,['user_id','DESC'],['user_type'=>'MERCHANT']);
                if($lastMerchant){
                    $lastsubfileid = $lastMerchant->sub_id+1;
                }
                $setdata['sub_id']=$lastsubfileid;
                $setdata['status']='INCOMPLETE';
                $setdata['file_id']='FTM'.sprintf('%07u', $lastsubfileid);
                $setdata['user_type']='MERCHANT';
                $setdata['mobile_number']=$this->input->post('phone');
                $password=substr(str_replace(' ','',$setdata['full_name']),0,4).preg_replace('~[+\d-](?=[\d-]{4})~', '',$this->input->post('phone'));
                $setdata['password']=password_hash($password,PASSWORD_DEFAULT);
            }
            $setdata['email']=$this->input->post('email');
            $setdata['age']=$this->input->post('age');
            $setdata['loan_type']=$this->input->post('employment_type');
            $setdata['created_by']=$this->session->userdata('user_id');

            $setdata2=[];
            if(!empty($record)){
                $setdata['updated_at']=date('Y-m-d H:i:s');
                if($this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$record->user_id])){
                    $insertId= $record->user_id;
                    if($this->input->post('employment_type')=='Business'){
                        $detaildata=$this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$record->user_id]);
                        if($detaildata){
                            $this->common_model->UpdateData(TBL_USER_DETAIL,['date_of_birth'=>$this->input->post('date_of_birth')],['user_id'=>$record->user_id]);
                        }else{
                            $this->common_model->InsertData(TBL_USER_DETAIL,['user_id'=>$record->user_id,'date_of_birth'=>$this->input->post('date_of_birth')]);
                        }
                    }
                    return response(['status'=>"success",'message'=>'Successful','id'=>$insertId]);
                }else{
                    return response(['status'=>"fail",'message'=>'Failure']);
                }
            }else{
                $setdata['status']='INCOMPLETE';
                $setdata['created_at']=date('Y-m-d H:i:s');
                $setdata['updated_at']=date('Y-m-d H:i:s');
                if($insertId= $this->common_model->InsertData(TBL_USERS,$setdata)){
                    $setdata2['user_id']=$insertId;
                    if($this->input->post('date_of_birth')){
                        $setdata2['date_of_birth']=$this->input->post('date_of_birth');
                    }
                    $this->common_model->InsertData(TBL_USER_DETAIL,$setdata2);
                    $this->session->set_userdata(['r_number'=>$this->input->post('phone')]);
                    $message='Thanks for showing your interest in unsecured business loan. Our team will contact you shortly. www.fintranxect.com';
                    if($this->session->userdata('user_id')==1746){
                        $message='We have received your loan query through our partner Zomato. Our executive will get in touch with you shortly. www.fintranxect.com';
                    }
                    SendOtpMessage($setdata['mobile_number'],$message);
                    return response(['status'=>"success",'message'=>'Successful','id'=>$insertId]);
                }else{
                    return response(['status'=>"fail",'message'=>'Failure']);
                }
            }
        }
    }
    public function keyUpForm(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $record= $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('mobile_number')]);
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

                if($this->input->post('key')=='loan_type1')
                $setdata2['loan_type1']=$this->input->post('value');
                
                if($this->input->post('key')=='no_of_partner')
                $setdata2['total_director_partner']=$this->input->post('value');
                
                if($this->input->post('key')=='no_of_director')
                $setdata2['total_director_partner']=$this->input->post('value');

                if($this->input->post('key')=='pan_number')
                $setdata2['pan_number']=$this->input->post('value');

                if($this->input->post('key')=='business_address')
                $setdata2['business_address']=$this->input->post('value');
                
                if($this->input->post('key')=='resident_address')
                $setdata2['resident_address']=$this->input->post('value');

                if($this->input->post('key')=='gstnumber')
                $setdata2['gst_number']=$this->input->post('value');

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
    public function comments($user_id){
        $this->common_model->UpdateData('comments',['is_read'=>'1'],['merchant_id'=>$user_id,'is_read'=>0,'comment_by'=>$this->session->userdata('user_id'),'comment_for'=>'PARTNER']);
        $this->data['record'] = $this->merchant_model->GetUserDetail($user_id);
        $this->data['comments']=$this->merchant_model->GetComments($user_id);
        $this->data['content']="merchant/partner_comments";
        $this->data['script']="merchant/partner_comment_script";
        $this->load->view('dsa',$this->data);
    }
    public function LeaveComment(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['merchant_id']=$this->input->post('merchant_id');
            $setdata['comment_by']=$this->session->userdata('user_id');
            $setdata['comment']=$this->input->post('comments');
            $setdata['commented_by']='PARTNER';
            $setdata['is_read']='1';
            $setdata['comment_for']='PARTNER';
            $setdata['created_at']=date('Y-m-d H:i:s');
            if($this->common_model->InsertData('comments',$setdata)){
                $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s'),'coomment_time'=>date('Y-m-d H:i:s')],['user_id'=>$this->input->post('merchant_id')]);
                return response(['status'=>'success','message'=>'Success']);
            }else{
                return response(['status'=>'fail','message'=>'Failure']);
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
            $insertId=$record->user_id;
            $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata2,['user_id'=>$insertId]);
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
    public function resolved($commentid,$type){
        $record=$this->common_model->GetRow('comments',['comment_id'=>$commentid]);
        $setdata=[];
        $setdata['admin_read']=0;
        if($type=='yes'){
            $setdata['is_resolved']='YES';
        }else{
            $setdata['is_resolved']='NO';
        }
        $setdata['resolved_by']='PARTNER';
        $this->common_model->UpdateData('comments',$setdata,['comment_id'=>$commentid]);
        $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s'),'comment_time'=>date('Y-m-d H:i:s')],['user_id'=>$record->merchant_id]);
        return redirect_dsa('merchant/comments/'.$record->merchant_id);
    }
    
    public function personalDocuments(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $user=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('mobile_number')]);
            if($user){
                $setdata=[];
                if($this->input->post('bankstatement_password') && $this->input->post('bankstatement_password')!='undefined')
                    $setdata['bankstatement_password']=$this->input->post('bankstatement_password');

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
                            $caselog=[];
                            $caselog['merchant_id']=$user->user_id;
                            $caselog['change_by']=$this->session->userdata('full_name');
                            $caselog['change_by_user_type']=$this->session->userdata('user_type');
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
                    $newindex=1;
                    for($j=0;$j<count($count1);$j++){
                        $string=explode('@kk@',$this->input->post('base_co_pancard_'.$i)[$j]);
                        if(strlen($string[0])>50){
                            $contents = file_get_contents($string[0]);
                            if(!empty($contents)){
                                $filename=$user->file_id.'-'.$newindex.'-co-applicant.'.end($string);
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
                if(!empty($setdata)){
                    $setdata['user_id']=$user->user_id;
                    $this->common_model->InsertData(TBL_USER_COAPPLICANT,$setdata);
                }
            }
            return response(['status'=>'success']);
        }
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
        }
    }
    public function ExportCasesByFilter(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->load->library('PHPExcel');
            $this->load->library('zip');
            if(in_array('Business',$this->input->post('filter_type'))){
                $data=$this->merchant_model->GetExportFilter($this->input->post());
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()->setCreator("Support");
                $objPHPExcel->getProperties()->setTitle('Loan Applicant');
                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . 1, 'Customer ID');
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . 1, 'Status');
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . 1, 'Full Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . 1, 'Email');
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . 1, 'Mobile Number');
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . 1, 'Age');
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . 1, 'Employment Type');
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . 1, 'Business Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . 1, 'House No./Building No./Street No.');
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . 1, 'Pincode');
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . 1, 'State');
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . 1, 'City');
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . 1, 'Type Of Firm');
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . 1, 'Nature Of Business');
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . 1, 'Type Of Nature');
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . 1, 'No. Of Years in Business');
                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . 1, 'Turn Over');
                $objPHPExcel->getActiveSheet()->SetCellValue('R' . 1, 'Desired Amount');
                $objPHPExcel->getActiveSheet()->SetCellValue('S' . 1, 'GST Number');
                $objPHPExcel->getActiveSheet()->SetCellValue('T' . 1, 'Pan Number');
                $objPHPExcel->getActiveSheet()->SetCellValue('U' . 1, 'Business Address');
                $objPHPExcel->getActiveSheet()->SetCellValue('V' . 1, 'Resident Address');
                $objPHPExcel->getActiveSheet()->SetCellValue('W' . 1, 'Refrence Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('X' . 1, 'Refrence Number');
                $objPHPExcel->getActiveSheet()->SetCellValue('Y' . 1, 'No. Fo Director|Partner');
                
                $objPHPExcel->getActiveSheet()->SetCellValue('Z' . 1, 'Partner|Director Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('AA' . 1, 'Partner|Director Pan No.');
                $objPHPExcel->getActiveSheet()->SetCellValue('AB' . 1, 'Partner|Director Address');

                $objPHPExcel->getActiveSheet()->SetCellValue('AC' . 1, 'Co-Applicant Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('AD' . 1, 'Co-Applicant Pan');
                $objPHPExcel->getActiveSheet()->SetCellValue('AE' . 1, 'Co-Applicant Relationship');

                $objPHPExcel->getActiveSheet()->SetCellValue('AF' . 1, 'Created Time');
                $objPHPExcel->getActiveSheet()->SetCellValue('AG' . 1, 'Bankstatement Password');
                $objPHPExcel->getActiveSheet()->SetCellValue('AH' . 1, 'Date Of Birth');
                
                $rowCount = 2;
                foreach ($data as $row)
                {
                    $multifiles = [];
                    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row->file_id);
                    $currentstatus='';
                    if(!empty($row->lender_status)){
                        $currentstatus=$row->lender_status;
                    }elseif(!empty($row->status) && $row->status=='INCOMPLETE'){
                        $currentstatus='INCOMPLETE';
                    }else{
                        $currentstatus='RECEIVED';
                    }
                    $loantype="";
                    if($row->loan_type){
                        $loantype=$row->loan_type;
                    }else{
                        $loantype=$row->employment_type;
                    }
                    $pincode="";
                    if($row->pincode=='Other'){
                        $pincode=$row->other_pincode;
                    }else{
                        $pincode=$row->pincode;
                    }
                    $city="";
                    if($row->city=='Other'){
                        $city=$row->other_city;
                    }else{
                        $city=$row->city;
                    }
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $currentstatus);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->full_name);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->email);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->mobile_number);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->age);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $loantype);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->company_name);
                    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->houseno);
                    $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $pincode);
                    $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->state);
                    $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $city);
                    $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->business_type);
                    $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row->nature_of_business);
                    $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $row->type_of_nature);
                    $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $row->vintage);
                    $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $row->turn_over);
                    $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $row->desired_amount);
                    $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $row->gst_number);
                    $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $row->pan_number);
                    $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $row->business_address);
                    $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $row->resident_address);
                    $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $row->reference);
                    $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $row->reference_number);
                    $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $row->total_director_partner);
                    $rscount=$rowCount;
                    $newrowcount=$rowCount;
                    $partner=$this->common_model->GetResult(TBL_USER_PARTNER,['user_id'=>$row->user_id]);
                    if(!empty($partner)){
                        foreach($partner as $p){
                            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $newrowcount, $p->name);
                            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $newrowcount, $p->pan_number);
                            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $newrowcount, $p->address);                  
                            $newrowcount++;
                        }
                    }
                    $arowcount=$rowCount;
                    $applicant=$this->common_model->GetResult(TBL_USER_COAPPLICANT,['user_id'=>$row->user_id]);
                    if(!empty($applicant)){
                        foreach($applicant as $a){
                            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $arowcount, $a->name);
                            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $arowcount, $a->pan_number);
                            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $arowcount, $a->relationship);
                            $arowcount++;
                        }
                    }
                    $created_at=date('d M Y h:i A',strtotime($row->created_at));
                    $objPHPExcel->getActiveSheet()->SetCellValue('AF' .$rowCount,$created_at);
                   

                    $objPHPExcel->getActiveSheet()->SetCellValue('AG' .$rowCount,$row->bankstatement_password);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AH' .$rowCount,$row->date_of_birth);
                    if($arowcount>$newrowcount){
                        $rowCount=($arowcount-1);
                    }elseif($newrowcount>$rowCount){
                        $rowCount=($newrowcount-1);
                    }
                    $rowCount++;
                }
                $unset=UPLOADS_DIR.'Business-Applicant.xls';
                unset($unset);
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save(UPLOADS_DIR.'Business-Applicant.xls');
                $this->zip->read_file(UPLOADS_DIR.'Business-Applicant.xls');
            }
            if(in_array('Salaried',$this->input->post('filter_type'))){
                $data=$this->merchant_model->GetExportFilter2($this->input->post());
                
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()->setCreator("Support");
                $objPHPExcel->getProperties()->setTitle('Loan Applicant');
                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . 1, 'Customer ID');
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . 1, 'Status');
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . 1, 'Full Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . 1, 'Email');
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . 1, 'Mobile Number');
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . 1, 'Age');
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . 1, 'Father Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . 1, 'Date OF Birth');
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . 1, 'Gender');
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . 1, 'Qualification');
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . 1, 'Marital Status');
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . 1, "Number of Kid's");
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . 1, 'Vehicle Type');
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . 1, 'Name of Employer');
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . 1, 'Designation');
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . 1, 'No. Of Years in current organization');
                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . 1, 'Type of organization');
                $objPHPExcel->getActiveSheet()->SetCellValue('R' . 1, 'Total Experience (In Months)');
                $objPHPExcel->getActiveSheet()->SetCellValue('S' . 1, 'Building No./Plot No.');
                $objPHPExcel->getActiveSheet()->SetCellValue('T' . 1, 'Locality/Area');
                $objPHPExcel->getActiveSheet()->SetCellValue('U' . 1, 'Company Pincode');
                $objPHPExcel->getActiveSheet()->SetCellValue('V' . 1, 'Company State');
                $objPHPExcel->getActiveSheet()->SetCellValue('W' . 1, 'Company City');
                $objPHPExcel->getActiveSheet()->SetCellValue('X' . 1, 'Official Email Address');
                $objPHPExcel->getActiveSheet()->SetCellValue('Y' . 1, 'Company Website');
                
                $objPHPExcel->getActiveSheet()->SetCellValue('Z' . 1, 'Inhand Salary');
                $objPHPExcel->getActiveSheet()->SetCellValue('AA' . 1, 'Mode Of Receiving Salary');
                $objPHPExcel->getActiveSheet()->SetCellValue('AB' . 1, 'Flat No./Building');
                $objPHPExcel->getActiveSheet()->SetCellValue('AC' . 1, 'Locality Area');
                $objPHPExcel->getActiveSheet()->SetCellValue('AD' . 1, 'Pincode');
                $objPHPExcel->getActiveSheet()->SetCellValue('AE' . 1, 'State');
                
                $objPHPExcel->getActiveSheet()->SetCellValue('AF' . 1, 'City');
                $objPHPExcel->getActiveSheet()->SetCellValue('AG' . 1, 'Residence Type');
                $objPHPExcel->getActiveSheet()->SetCellValue('AH' . 1, 'Time At Residence');
                $objPHPExcel->getActiveSheet()->SetCellValue('AI' . 1, 'Pan Number');
                $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . 1, 'Aadhar Number');
                $objPHPExcel->getActiveSheet()->SetCellValue('AK' . 1, 'Reference Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('AL' . 1, 'Reference Number');
                $objPHPExcel->getActiveSheet()->SetCellValue('AM' . 1, 'Created Time');
                
    
                $rowCount = 2;
                foreach ($data as $row)
                {
                    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row->file_id);                    
                    $currentstatus='';
                    if(!empty($row->lender_status)){
                        $currentstatus=$row->lender_status;
                    }elseif(!empty($row->status) && $row->status=='INCOMPLETE'){
                        $currentstatus='INCOMPLETE';
                    }else{
                        $currentstatus='RECEIVED';
                    }

                    $company_pincode='';
                    if($row->company_pincode=='Other'){
                        $company_pincode=$row->company_other_pincode;
                    }else{
                        $company_pincode=$row->company_pincode;
                    }
                    $company_city='';
                    if($row->company_city=='Other'){
                        $company_city=$row->company_other_city;
                    }else{
                        $company_city=$row->company_pincode;
                    }
                    $residence_pincode='';
                    if($row->residence_pincode=='Other'){
                        $residence_pincode=$row->residence_other_pincode;
                    }else{
                        $residence_pincode=$row->residence_pincode;
                    }
                    $residence_city='';
                    if($row->residence_city=='Other'){
                        $residence_city=$row->residence_other_city;
                    }else{
                        $residence_city=$row->residence_city;
                    }
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $currentstatus);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->full_name);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->email);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->mobile_number);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->age);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row->father_name);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->date_of_birth);
                    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->gender);
                    $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row->qualification);
                    $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->marital_status);
                    $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->number_of_kids);
                    $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->vehicle_type);
                    $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row->employer_name);
                    $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $row->designation);
                    $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $row->organization);
                    $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $row->organization_type);
                    $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $row->total_experience);
                    $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $row->company_building);
                    $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $row->company_area);
                    $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $company_pincode);
                    $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $row->company_state);
                    $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $company_city);
                    $objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $row->company_email);
                    $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $row->company_website);
                    $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $row->salery_inhand);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $row->salary_mode);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $row->residence_building);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $row->residence_area);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $residence_pincode);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, $row->residence_state);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $residence_city);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $row->residence_type);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $row->year_at_residence);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, $row->pan_number);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $row->aadhar_number);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $rowCount, $row->reference);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $row->reference_number);
                    
                    $created_at=date('d M Y h:i A',strtotime($row->created_at));
                    $objPHPExcel->getActiveSheet()->SetCellValue('AM' .$rowCount,$created_at);
                    
                    
                    $rowCount++;
                }
                
                $unset=UPLOADS_DIR.'Salaried-Applicant.xls';
                unset($unset);
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save(UPLOADS_DIR.'Salaried-Applicant.xls'); 
                $this->zip->read_file(UPLOADS_DIR.'Salaried-Applicant.xls');
            }
            $this->zip->download('Download.zip'); 
        }
    }
    public function DownloadApplicant($user_id){
		$data=$this->merchant_model->GetMerchantResult($user_id);
		$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Support");
		$objPHPExcel->getProperties()->setTitle('Loan Applicant');
		//$objPHPExcel->getActiveSheet()->getStyle('A1:AQ1')->getilont()->setBold(true);
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A' . 1, 'Customer ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . 1, 'Status');
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . 1, 'Full Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . 1, 'Email');
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . 1, 'Mobile Number');
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . 1, 'Age');
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . 1, 'Employment Type');
		$objPHPExcel->getActiveSheet()->SetCellValue('H' . 1, 'Business Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('I' . 1, 'House No./Building No./Street No.');
		$objPHPExcel->getActiveSheet()->SetCellValue('J' . 1, 'Pincode');
		$objPHPExcel->getActiveSheet()->SetCellValue('K' . 1, 'State');
        $objPHPExcel->getActiveSheet()->SetCellValue('L' . 1, 'City');
        $objPHPExcel->getActiveSheet()->SetCellValue('M' . 1, 'Type Of Firm');
        $objPHPExcel->getActiveSheet()->SetCellValue('N' . 1, 'Nature Of Business');
        $objPHPExcel->getActiveSheet()->SetCellValue('O' . 1, 'Type Of Nature');
		$objPHPExcel->getActiveSheet()->SetCellValue('P' . 1, 'No. Of Years in Business');
		$objPHPExcel->getActiveSheet()->SetCellValue('Q' . 1, 'Turn Over');
		$objPHPExcel->getActiveSheet()->SetCellValue('R' . 1, 'Desired Amount');
		$objPHPExcel->getActiveSheet()->SetCellValue('S' . 1, 'GST Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('T' . 1, 'Pan Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('U' . 1, 'Business Address');
        $objPHPExcel->getActiveSheet()->SetCellValue('V' . 1, 'Resident Address');
		$objPHPExcel->getActiveSheet()->SetCellValue('W' . 1, 'Refrence Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('X' . 1, 'Refrence Number');
		$objPHPExcel->getActiveSheet()->SetCellValue('Y' . 1, 'No. Fo Director|Partner');
		
		$objPHPExcel->getActiveSheet()->SetCellValue('Z' . 1, 'Partner|Director Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('AA' . 1, 'Partner|Director Pan No.');
		$objPHPExcel->getActiveSheet()->SetCellValue('AB' . 1, 'Partner|Director Address');

		$objPHPExcel->getActiveSheet()->SetCellValue('AC' . 1, 'Co-Applicant Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('AD' . 1, 'Co-Applicant Pan');
		$objPHPExcel->getActiveSheet()->SetCellValue('AE' . 1, 'Co-Applicant Relationship');
        
        $objPHPExcel->getActiveSheet()->SetCellValue('AF' . 1, 'Created Time');
        $objPHPExcel->getActiveSheet()->SetCellValue('AG' . 1, 'Bankstatement Password');
        $objPHPExcel->getActiveSheet()->SetCellValue('AH' . 1, 'Date Of Birth');

		$rowCount = 2;
        //echo "<pre>";print_r($data);die;
        $this->load->library('zip');
		foreach ($data as $row)
		{
            $multifiles = [];
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row->file_id);
            $currentstatus='';
            if(!empty($row->lender_status)){
                $currentstatus=$row->lender_status;
            }elseif(!empty($row->status) && $row->status=='INCOMPLETE'){
                $currentstatus='INCOMPLETE';
            }else{
                $currentstatus='RECEIVED';
            }
            
            $loantype="";
            if($row->loan_type){
                $loantype=$row->loan_type;
            }else{
                $loantype=$row->employment_type;
            }
            $pincode="";
            if($row->pincode=='Other'){
                $pincode=$row->other_pincode;
            }else{
                $pincode=$row->pincode;
            }
            $city="";
            if($row->city=='Other'){
                $city=$row->other_city;
            }else{
                $city=$row->city;
            }
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $currentstatus);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->full_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->email);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->mobile_number);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->age);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $loantype);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->company_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->houseno);
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $pincode);
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->state);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $city);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->business_type);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row->nature_of_business);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $row->type_of_nature);
			$objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $row->vintage);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $row->turn_over);
			$objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $row->desired_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $row->gst_number);
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $row->pan_number);
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $row->business_address);
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $row->resident_address);
			$objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $row->reference);
			$objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $row->reference_number);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $row->total_director_partner);
            $rscount=$rowCount;
			$newrowcount=$rowCount;
			$partner=$this->common_model->GetResult(TBL_USER_PARTNER,['user_id'=>$row->user_id]);
			if(!empty($partner)){
                
				foreach($partner as $p){
					$objPHPExcel->getActiveSheet()->SetCellValue('Z' . $newrowcount, $p->name);
					$objPHPExcel->getActiveSheet()->SetCellValue('AA' . $newrowcount, $p->pan_number);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $newrowcount, $p->address);
                    if(!empty($p->director_partner_proof)){
                        $filearray=explode(',',$p->director_partner_proof);
                        foreach($filearray as $file){
                            if(strlen($file)>6 && $file!="data:"){
                                if(file_exists(FCPATH.'uploads/merchant/other/'.$file)){
                                    $this->zip->read_file(FCPATH.'uploads/merchant/other/'.$file);
                                }
                            }
                        }
                    }
                    if(!empty($p->pancard_image)){
                        $filearray=explode(',',$p->pancard_image);
                        foreach($filearray as $file){
                            if(strlen($file)>6 && $file!="data:"){
                                if(file_exists(FCPATH.'uploads/merchant/other/'.$file)){
                                    $this->zip->read_file(FCPATH.'uploads/merchant/other/'.$file);
                                }
                            }
                        }
                    }
                    if(!empty($p->address_proof)){
                        $filearray=explode(',',$p->address_proof);
                        foreach($filearray as $file){
                            if(strlen($file)>6 && $file!="data:"){
                                if(file_exists(FCPATH.'uploads/merchant/other/'.$file)){
                                    $this->zip->read_file(FCPATH.'uploads/merchant/other/'.$file);
                                }
                            }
                        }
                    }                    
                    $newrowcount++;
				}
			}
			$arowcount=$rowCount;
			$applicant=$this->common_model->GetResult(TBL_USER_COAPPLICANT,['user_id'=>$row->user_id]);
			if(!empty($applicant)){
                foreach($applicant as $a){
					$objPHPExcel->getActiveSheet()->SetCellValue('AC' . $arowcount, $a->name);
					$objPHPExcel->getActiveSheet()->SetCellValue('AD' . $arowcount, $a->pan_number);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $arowcount, $a->relationship);
                    if(!empty($a->pancard_image)){
                        $filearray=explode(',',$a->pancard_image);
                        foreach($filearray as $file){
                            if(strlen($file)>6 && $file!="data:"){
                                if(file_exists(FCPATH.'uploads/merchant/pancard/'.$file)){
                                    $this->zip->read_file(FCPATH.'uploads/merchant/pancard/'.$file);
                                }
                            }
                        }
                    }          
					$arowcount++;
				}
            }
           
            
            $created_at=date('d M Y h:i A',strtotime($row->created_at));
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' .$rowCount,$created_at);
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' .$rowCount,$row->bankstatement_password);
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' .$rowCount,$row->date_of_birth);
            if(!empty($row->pancard_image)){
                $filearray=explode(',',$row->pancard_image);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/pancard/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/pancard/'.$file);
                        }
                    }
                }
            }
            
            if(!empty($row->gstproof_image)){
                $filearray=explode(',',$row->gstproof_image);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/gst/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/gst/'.$file);
                        }
                    }
                }
            }
            
            if(!empty($row->business_address_proof)){
                $filearray=explode(',',$row->business_address_proof);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/business/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/business/'.$file);
                        }
                    }
                }
            }
            if(!empty($row->resident_address_proof)){
                $filearray=explode(',',$row->resident_address_proof);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/resident/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/resident/'.$file);
                        }
                    }
                }
            }
           
            if(!empty($row->bank_statement)){
                $filearray=explode(',',$row->bank_statement);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/bankstatement/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/bankstatement/'.$file);
                        }
                    }
                }
            }
            
            if(!empty($row->ownership_proof)){
                $filearray=explode(',',$row->ownership_proof);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/ownership/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/ownership/'.$file);
                        }
                    }
                }
            }
            if(!empty($row->partnership_deal)){
                $filearray=explode(',',$row->partnership_deal);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/partnership/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/partnership/'.$file);
                        }
                    }
                }
            }
            if(!empty($row->tan_image)){
                $filearray=explode(',',$row->tan_image);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/tan/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/tan/'.$file);
                        }
                    }
                }
            }
            if(!empty($row->coi_image)){
                $filearray=explode(',',$row->coi_image);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/coi/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/coi/'.$file);
                        }
                    }
                }
            }
            if(!empty($row->boardresolution)){
                $filearray=explode(',',$row->boardresolution);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/boardresolution/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/boardresolution/'.$file);
                        }
                    }
                }
            }
            if(!empty($row->itr_docs)){
                $filearray=explode(',',$row->itr_docs);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/itr/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/itr/'.$file);
                        }
                    }
                }
            }
            if(!empty($row->cheque_docs)){
                $filearray=explode(',',$row->cheque_docs);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/canceled_cheque/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/canceled_cheque/'.$file);
                        }
                    }
                }
            }
            if(!empty($row->additional_docs)){
                $filearray=explode(',',$row->additional_docs);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/addition_docs/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/addition_docs/'.$file);
                        }
                    }
                }
            }

            if($arowcount>$newrowcount){
				$rowCount=$arowcount;
			}elseif($newrowcount>$rowCount){
				$rowCount=$newrowcount;
			}
			$rowCount=$rowCount+1;
			$rowCount++;
        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save(UPLOADS_DIR.'Loan Applicant.xls'); 
        $this->zip->read_file(UPLOADS_DIR.'Loan Applicant.xls');
        $this->zip->download('Download.zip'); 
    }
    public function DownloadApplicant2($user_id=""){
		
        $data=$this->merchant_model->GetMerchantResult2($user_id);
        //echo "<pre>";print_r($data);die;
		$this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Support");
		$objPHPExcel->getProperties()->setTitle('Loan Applicant');
		//$objPHPExcel->getActiveSheet()->getStyle('A1:AQ1')->getFont()->setBold(true);
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A' . 1, 'Customer ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . 1, 'Status');
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . 1, 'Full Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . 1, 'Email');
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . 1, 'Mobile Number');
		$objPHPExcel->getActiveSheet()->SetCellValue('F' . 1, 'Age');
		$objPHPExcel->getActiveSheet()->SetCellValue('G' . 1, 'Father Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('H' . 1, 'Date OF Birth');
		$objPHPExcel->getActiveSheet()->SetCellValue('I' . 1, 'Gender');
		$objPHPExcel->getActiveSheet()->SetCellValue('J' . 1, 'Qualification');
		$objPHPExcel->getActiveSheet()->SetCellValue('K' . 1, 'Marital Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('L' . 1, "Number of Kid's");
        $objPHPExcel->getActiveSheet()->SetCellValue('M' . 1, 'Vehicle Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('N' . 1, 'Name of Employer');
        $objPHPExcel->getActiveSheet()->SetCellValue('O' . 1, 'Designation');
		$objPHPExcel->getActiveSheet()->SetCellValue('P' . 1, 'No. Of Years in current organization');
		$objPHPExcel->getActiveSheet()->SetCellValue('Q' . 1, 'Type of organization');
		$objPHPExcel->getActiveSheet()->SetCellValue('R' . 1, 'Total Experience (In Months)');
		$objPHPExcel->getActiveSheet()->SetCellValue('S' . 1, 'Building No./Plot No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('T' . 1, 'Locality/Area');
        $objPHPExcel->getActiveSheet()->SetCellValue('U' . 1, 'Company Pincode');
        $objPHPExcel->getActiveSheet()->SetCellValue('V' . 1, 'Company State');
		$objPHPExcel->getActiveSheet()->SetCellValue('W' . 1, 'Company City');
		$objPHPExcel->getActiveSheet()->SetCellValue('X' . 1, 'Official Email Address');
		$objPHPExcel->getActiveSheet()->SetCellValue('Y' . 1, 'Company Website');
		
		$objPHPExcel->getActiveSheet()->SetCellValue('Z' . 1, 'Inhand Salary');
		$objPHPExcel->getActiveSheet()->SetCellValue('AA' . 1, 'Mode Of Receiving Salary');
		$objPHPExcel->getActiveSheet()->SetCellValue('AB' . 1, 'Flat No./Building');
		$objPHPExcel->getActiveSheet()->SetCellValue('AC' . 1, 'Locality Area');
		$objPHPExcel->getActiveSheet()->SetCellValue('AD' . 1, 'Pincode');
		$objPHPExcel->getActiveSheet()->SetCellValue('AE' . 1, 'State');
        
        $objPHPExcel->getActiveSheet()->SetCellValue('AF' . 1, 'City');
        $objPHPExcel->getActiveSheet()->SetCellValue('AG' . 1, 'Residence Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('AH' . 1, 'Time At Residence');
        $objPHPExcel->getActiveSheet()->SetCellValue('AI' . 1, 'Pan Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . 1, 'Aadhar Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('AK' . 1, 'Reference Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('AL' . 1, 'Reference Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('AM' . 1, 'Bankstatement Password');

		$rowCount = 2;
        //echo "<pre>";print_r($data);die;
        $this->load->library('zip');
		foreach ($data as $row)
		{
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row->file_id);
            $currentstatus='';
            if(!empty($row->lender_status)){
                $currentstatus=$row->lender_status;
            }elseif(!empty($row->status) && $row->status=='INCOMPLETE'){
                $currentstatus='INCOMPLETE';
            }else{
                $currentstatus='RECEIVED';
            }
            
            $company_pincode='';
            if($row->company_pincode=='Other'){
                $company_pincode=$row->company_other_pincode;
            }else{
                $company_pincode=$row->company_pincode;
            }
            $company_city='';
            if($row->company_city=='Other'){
                $company_city=$row->company_other_city;
            }else{
                $company_city=$row->company_pincode;
            }
            $residence_pincode='';
            if($row->residence_pincode=='Other'){
                $residence_pincode=$row->residence_other_pincode;
            }else{
                $residence_pincode=$row->residence_pincode;
            }
            $residence_city='';
            if($row->residence_city=='Other'){
                $residence_city=$row->residence_other_city;
            }else{
                $residence_city=$row->residence_city;
            }
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $currentstatus);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->full_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->email);
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->mobile_number);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->age);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row->father_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $row->date_of_birth);
			$objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $row->gender);
			$objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $row->qualification);
			$objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $row->marital_status);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $row->number_of_kids);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $row->vehicle_type);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $row->employer_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $row->designation);
			$objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $row->organization);
			$objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $row->organization_type);
			$objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $row->total_experience);
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $row->company_building);
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $row->company_area);
            $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $company_pincode);
            $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $row->company_state);
			$objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $company_city);
			$objPHPExcel->getActiveSheet()->SetCellValue('X' . $rowCount, $row->company_email);
            $objPHPExcel->getActiveSheet()->SetCellValue('Y' . $rowCount, $row->company_website);
            $objPHPExcel->getActiveSheet()->SetCellValue('Z' . $rowCount, $row->salery_inhand);
            $objPHPExcel->getActiveSheet()->SetCellValue('AA' . $rowCount, $row->salary_mode);
            $objPHPExcel->getActiveSheet()->SetCellValue('AB' . $rowCount, $row->residence_building);
            $objPHPExcel->getActiveSheet()->SetCellValue('AC' . $rowCount, $row->residence_area);
            $objPHPExcel->getActiveSheet()->SetCellValue('AD' . $rowCount, $residence_pincode);
            $objPHPExcel->getActiveSheet()->SetCellValue('AE' . $rowCount, $row->residence_state);
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rowCount, $residence_city);
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $row->residence_type);
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . $rowCount, $row->year_at_residence);
            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . $rowCount, $row->pan_number);
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . $rowCount, $row->aadhar_number);
            $objPHPExcel->getActiveSheet()->SetCellValue('AK' . $rowCount, $row->reference);
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . $rowCount, $row->reference_number);
            $rscount=$rowCount;
			$newrowcount=$rowCount;
			
            if(!empty($row->created_by)){
                $partnerrecord=$this->common_model->GetRow(TBL_USERS,['user_id'=>$row->created_by]);
                if(!empty($partnerrecord)){
                    $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $rscount, $partnerrecord->file_id);
                }
            }
            $created_at=date('d M Y h:i A',strtotime($row->created_at));
            $objPHPExcel->getActiveSheet()->SetCellValue('AN' .$rowCount,$created_at);
            $remark = $this->common_model->GetOrderByRow('remark',['remark_id','DESC'],['merchant_id'=>$row->user_id]);
            if(!empty($remark)){
                $objPHPExcel->getActiveSheet()->SetCellValue('AO' .$rowCount,$remark->comments);
                $objPHPExcel->getActiveSheet()->SetCellValue('AP' .$rowCount,$remark->created_at);
            }
            $comments = $this->common_model->GetOrderByRow('comments',['comment_id','DESC'],['merchant_id'=>$row->user_id]);
            if(!empty($comments)){
                $objPHPExcel->getActiveSheet()->SetCellValue('AQ' .$rowCount,$comments->comment);
                $objPHPExcel->getActiveSheet()->SetCellValue('AR' .$rowCount,$comments->created_at);
            }
            if($currentstatus=='INCOMPLETE')
                $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->created_at);
            elseif($currentstatus=='RECEIVED')
                $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->received_time);
            elseif($currentstatus=='SHORTCLOSE')
                $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->short_close_time);
            
            $objPHPExcel->getActiveSheet()->SetCellValue('AT' .$rowCount,$row->bankstatement_password);
            if(!empty($row->pancard_image)){
                $filearray=explode(',',$row->pancard_image);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/pancard/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/pancard/'.$file);
                        }
                    }
                }
            }
            if(!empty($row->salery_slip)){
                $filearray=explode(',',$row->salery_slip);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/salery_slip/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/salery_slip/'.$file);
                        }
                    }
                }
            }
            if(!empty($row->aadhar_image)){
                $filearray=explode(',',$row->aadhar_image);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/aadharcard/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/aadharcard/'.$file);
                        }
                    }
                }
            }

            if(!empty($row->bank_statement)){
                $filearray=explode(',',$row->bank_statement);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/bankstatement/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/bankstatement/'.$file);
                        }
                    }
                }
            }
            if(!empty($row->itr_docs)){
                $filearray=explode(',',$row->itr_docs);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/itr/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/itr/'.$file);
                        }
                    }
                }
            }
            if(!empty($row->cheque_docs)){
                $filearray=explode(',',$row->cheque_docs);
                foreach($filearray as $file){
                    if(strlen($file)>6 && $file!="data:"){
                        if(file_exists(FCPATH.'uploads/merchant/canceled_cheque/'.$file)){
                            $this->zip->read_file(FCPATH.'uploads/merchant/canceled_cheque/'.$file);
                        }
                    }
                }
            }
            
            if($arowcount>$newrowcount){
				$rowCount=$arowcount;
			}elseif($newrowcount>$rowCount){
				$rowCount=$newrowcount;
			}
			$rowCount=$rowCount+1;
			$rowCount++;
        }
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save(UPLOADS_DIR.'Loan Applicant.xls'); 
        $this->zip->read_file(UPLOADS_DIR.'Loan Applicant.xls');
        $this->zip->download('Download.zip'); 
	}
}