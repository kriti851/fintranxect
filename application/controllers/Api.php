<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
    private $data=[];
      public function __construct() {
      parent::__construct();
      $this->output->delete_cache();
      $this->load->model('super-admin/merchant_model','merchant_model');
      header("Access-Control-Allow-Origin: *");
    }
    public function ValidEmail(){
      $record = $this->common_model->GetRow(TBL_USERS,['email'=>$this->input->post('email'),'status'=>null]);
      if($record){
        $this->form_validation->set_message('ValidEmail', 'Email already Exists');
        return false;
      }else{
        return true;
      }
    }
    public function ValidIp($ip){
      $record = $this->common_model->GetRow('white_list_ips',['ip_address'=>$ip]);
      if($record){       
        return true;
      }else{
        return false;
      }
    }
    public function VerifySecretKey(){
      $header=  $this->input->request_headers();
      if(isset($header['Secret-Key'])){
        $record = $this->common_model->GetRow(TBL_USERS,['secret_key'=>$header['Secret-Key'],'user_type'=>'DSA']);
        if($record){       
          return $record->user_id;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }
    public function ValidLoanType(){
      if($this->input->post('occupationType')!="Business"){
        $this->form_validation->set_message('ValidLoanType', 'Only Business Option Available');
        return false;
      }else{
        return true;
      }
    }
    public function ValidNoOfPartner(){
      if($this->input->post('noOfPartner')>1){
        return true;
      }else{
        $this->form_validation->set_message('ValidNoOfPartner', 'Number of partner is greater than 1');
        return false;
      }
    }
    public function ValidNoOfDirector(){
      if($this->input->post('noOfDirector')>1){
        return true;
      }else{
        $this->form_validation->set_message('ValidNoOfDirector', 'Number of director is greater than 1');
        return false;
      }
    }
    public function CoApplicantError(){
        $coapplicant = $this->input->post('coApplicant');
        if($coapplicant){
          if(is_array($coapplicant)){
            foreach($coapplicant as $co){
              $co=(object)$co;
              if(empty($co->fullName)){
                $this->form_validation->set_message('CoApplicantError','The Co Applicant Full Name is Required');
                return FALSE;
              }
              if(empty($co->relationship)){
                $this->form_validation->set_message('CoApplicantError','The Co Applicant Relationship is Required');
                return FALSE;
              }
              if(empty($co->panNumber)){
                $this->form_validation->set_message('CoApplicantError','The Co Applicant Pan Number is Required');
                return FALSE;
              }else{
                if(!preg_match('/^[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}$/',$co->panNumber)){
                  $this->form_validation->set_message('CoApplicantError','Enter Co Applicant Valid Pan Number');
                  return FALSE;
                }
              }
            }
            return TRUE;
          }else{
            $this->form_validation->set_message('CoApplicantError','Invalid Co Applicant Detail');
            return FALSE;
          }
        }else{
          return TRUE;
        }
    }
    public function OccupationValidate($value,$str){
      if(!empty($value)){
        if($value!='Business' && $value!="Salaried"){
          $this->form_validation->set_message('OccupationValidate','Invalid Occupation type');
          return FALSE;
        }else{
          return true;
        }
      }
    }
    public function create_application(){
      if($this->input->server('REQUEST_METHOD')=='POST')
      {
        $ip_address=$this->input->ip_address();
        if($this->ValidIp($ip_address))
        {        
          $_POST=params();
          $created_by_secret=$this->VerifySecretKey();
          if(!$created_by_secret){
            return response(['status'=>'fail','message'=>'Invalid Secret Key']);
          }
          $this->form_validation->set_rules('fullName','Full Name','trim|required');
          $this->form_validation->set_rules('mobileNumber','Mobile Number','trim|required|numeric|min_length[10]|max_length[10]');
          $this->form_validation->set_rules('email','Email','trim|required|valid_email|callback_ValidEmail');
          $this->form_validation->set_rules('occupationType','Occupation Type','trim|required|callback_OccupationValidate[occupationType]');
          if($this->form_validation->run()==TRUE){
            $record= $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('mobileNumber')]);
            if(empty($record) || (!empty($record) && $record->user_type=='MERCHANT' && $record->status!=null)){
              $setdata=[];
              $setdata['full_name']=$this->input->post('fullName');
              if(empty($record)){
                $lastsubfileid=1;
                $lastMerchant=$this->common_model->GetOrderByRow(TBL_USERS,['user_id','DESC'],['user_type'=>'MERCHANT']);
                if($lastMerchant){
                  $lastsubfileid = $lastMerchant->sub_id+1;
                }
                $setdata['sub_id']=$lastsubfileid;
                $setdata['user_type']='MERCHANT';
                $setdata['file_id']='FTM'.sprintf('%07u', $lastsubfileid);
                $setdata['status']='INCOMPLETE';
                $setdata['created_at']=date('Y-m-d H:i:s');
                $setdata['created_by']=$created_by_secret;
                $password="myloan@123#";
                $password=substr(str_replace(' ','',$setdata['full_name']),0,4).preg_replace('~[+\d-](?=[\d-]{4})~', '',$this->input->post('mobileNumber'));
                $setdata['password']=password_hash($password,PASSWORD_DEFAULT);
              }
              $setdata['email']=$this->input->post('email');
              $setdata['age']=$this->input->post('age');
              $setdata['company_name']=$this->input->post('businessName');
              $setdata['loan_type']=$this->input->post('occupationType');
              $insertId="";
              if(!empty($record)){
                $setdata['updated_at']=date('Y-m-d H:i:s');
                $this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$record->user_id]);
                $returndata=[];
                if($record->loan_type=='Business'){
                  $returndata=$this->merchant_model->GetUserDetail($record->user_id);
                }else{
                  $returndata=$this->merchant_model->GetUserDetail2($record->user_id);
                }
                $return =new stdClass;
                $return->caseId=$returndata->file_id;
                $return->fullName=$returndata->full_name;
                $return->email=$returndata->email;
                $return->mobileNumber=$returndata->mobile_number;
                $return->occupationType=$returndata->loan_type;
                return response([ 'status'=>'success','message'=>'Success','next'=>'Add Detail','data'=>$return]);
              }else{
                $setdata['updated_at']=date('Y-m-d H:i:s');
                $setdata['mobile_number']=$this->input->post('mobileNumber');
                $insertId= $this->common_model->InsertData(TBL_USERS,$setdata);
                $returndata=[];
                if($setdata['loan_type']=='Business'){
                  $returndata=$this->merchant_model->GetUserDetail($insertId);
                }else{
                  $returndata=$this->merchant_model->GetUserDetail2($insertId);
                }
                $return =new stdClass;
                $return->caseId=$returndata->file_id;
                $return->fullName=$returndata->full_name;
                $return->email=$returndata->email;
                $return->mobileNumber=$returndata->mobile_number;
                $return->occupationType=$returndata->loan_type;
                $return->age=$returndata->age;
                return response([ 'status'=>'success','message'=>'Success','next'=>'Add Detail','data'=>$return]);
              }            
            }else{
              return response([ 'status'=>'fail','message'=>'Mobile Number already Exists']);
            }
          }else{
            $errors="";
            if(form_error('fullName')){
              $errors=strip_tags(form_error('fullName'));
            }elseif(form_error('mobileNumber')){
              $errors=strip_tags(form_error('mobileNumber'));
            }elseif(form_error('email')){
              $errors=strip_tags(form_error('email'));
            }elseif(form_error('age')){
              $errors=strip_tags(form_error('age'));
            }elseif(form_error('occupationType')){
              $errors=strip_tags(form_error('occupationType'));
            }
            return response([ 'status'=>'fail','message'=>$errors]);
          }
        }else{
          return response(['status'=>'fail','message'=>"Ip is not whitelist"]);
        }
      }
    }
    public function ValidDateofBirth($value,$str){
      if(!empty($value)){
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$value)) {
            return true;
        } else {
          $this->form_validation->set_message('ValidDateofBirth','Use only YYYY-MM-DD format');
          return false;
        }
      }else{
        return true;
      }
    }
    public function  ValidateTypeOfFirm($value,$str){
      if(!empty($value)){
        if($value!='Partnership' && $value!='PVT .ltd' && $value!='Individual' && $value!="Proprietorship"){
          $this->form_validation->set_message('ValidateTypeOfFirm','Invalid Type of Firm');
          return FALSE;
        }else{
          return true;
        }
      }else{
        return true;
      }
    }
    public function ValidateBusinessNature($value,$str){
      if(!empty($value)){
        if($value!='Retail' && $value!='Wholesale' && $value!='Manufacturing' && $value!="Service"){
          $this->form_validation->set_message('ValidateBusinessNature','Invalid value passed in nature of business');
          return FALSE;
        }else{
          return true;
        }
      }else{
        return true;
      }
    }
    public function ValidateQualification($value,$str){
      if(!empty($value)){
        if($value!='Undre Graduate' && $value!='Graduate' && $value!='Post Graduate' ){
          $this->form_validation->set_message('ValidateQualification','Invalid value passed in qualification');
          return FALSE;
        }else{
          return true;
        }
      }else{
        return true;
      }
    }
    public function ValidateGender($value,$str){
      if(!empty($value)){
        if($value!='Male' && $value!='Female' && $value!='Other' && $value!="Prefer Not to Say"){
          $this->form_validation->set_message('ValidateGender','Invalid Value Passed in Gender Type');
          return FALSE;
        }else{
          return true;
        }
      }else{
        return true;
      }
    }
    public function ValidateMarital($value,$str){
      if(!empty($value)){
        if($value!='Single' && $value!='Married' && $value!='Prefer Not to Say'){
          $this->form_validation->set_message('ValidateMarital','Invalid value Passed in Marital Status');
          return FALSE;
        }else{
          return true;
        }
      }else{
        return true;
      }
    }
    public function ValidateVehicleType($value,$str){
      if(!empty($value)){
        if($value!='2 wheeler' && $value!='4 wheeler' && $value!='None'){
          $this->form_validation->set_message('ValidateVehicleType','Invalid Value Passed in Vehicle Type');
          return FALSE;
        }else{
          return true;
        }
      }else{
        return true;
      }
    }
    public function ValidateOrganizationType($value,$str){
      if(!empty($value)){
        if($value!='Proprietorship' && $value!='Partnership' && $value!='Private Limited' && $value!="Public Limited" && $value!="Government"){
          $this->form_validation->set_message('ValidateOrganizationType','Invalid Value Passed in Organization Type');
          return FALSE;
        }else{
          return true;
        }
      }else{
        return true;
      }
    }
    public function ValidateSalaryMode($value,$str){
      if(!empty($value)){
        if($value!='Bank account transfer' && $value!='Cheque' && $value!='Cash'){
          $this->form_validation->set_message('ValidateSalaryMode','Invalid Value Passed in salary mode');
          return FALSE;
        }else{
          return true;
        }
      }else{
        return true;
      }
    }
    public function add_detail(){
      if($this->input->server('REQUEST_METHOD')=='POST'){
        $ip_address=$this->input->ip_address();
        if($this->ValidIp($ip_address)){
          $_POST=params();
          $verify=$this->VerifySecretKey();
          if(!$verify){
            return response(['status'=>'fail','message'=>'Invalid Secret Key']);
          }
          $record= $this->common_model->GetRow(TBL_USERS,['file_id'=>trim($this->input->post('caseId')),'user_type'=>'MERCHANT']);
          if(!empty($record)){
            if($record->status==null){
              return response([ 'status'=>'fail','message'=>'User Already Exists']);
            }
            if($record->loan_type=='Business'){
              $this->form_validation->set_rules('businessName','Business Name','trim|required');
              $this->form_validation->set_rules('pincode','Pincode','trim|numeric|min_length[6]|max_length[6]');
              $this->form_validation->set_rules('numberOfYearInBusiness','Number Of Year In Business','trim|numeric');
              $this->form_validation->set_rules('typeOfFirm','Type Of Firm','trim|required|callback_ValidateTypeOfFirm[typeOfFirm]');
              $this->form_validation->set_rules('natureOfBusiness','Nature Of Business','trim|callback_ValidateBusinessNature[natureOfBusiness]');
              $this->form_validation->set_rules('coApplicant','Co Applicant','callback_CoApplicantError');
              $this->form_validation->set_rules('referenceNumber','Reference Number','trim|numeric|min_length[10]|max_length[10]');
              if($this->form_validation->run()==TRUE){
                  $setdata=[];
                  $setdata['company_name']=$this->input->post('businessName');
                  $insertId="";
                  if(!empty($record)){
                    $setdata['updated_at']=date('Y-m-d H:i:s');
                    $insertId=$record->user_id;
                    $this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$record->user_id]);
                  }
                  if(!empty($insertId)){
                    $detail = $this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$insertId]);
                    $setdata2=[];

                    if($this->input->post('houseNo'))
                    $setdata2['houseno']=$this->input->post('houseNo');

                    if($this->input->post('typeOfLoan'))
                    $setdata2['loan_type1']=$this->input->post('typeOfLoan');

                    if($this->input->post('city'))
                    $setdata2['city']=$this->input->post('city');

                    if($this->input->post('pincode'))
                    $setdata2['pincode']=$this->input->post('pincode');

                    if($this->input->post('state'))
                    $setdata2['state']=$this->input->post('state');
                    
                    if($this->input->post('numberOfYearInBusiness'))
                    $setdata2['vintage']=$this->input->post('numberOfYearInBusiness');
                    
                    if($this->input->post('monthlyTurnOver'))
                    $setdata2['turn_over']=$this->input->post('monthlyTurnOver');

                    if($this->input->post('typeOfFirm'))
                    $setdata2['business_type']=$this->input->post('typeOfFirm');

                    if($this->input->post('typeOfNature'))
                    $setdata2['type_of_nature']=$this->input->post('typeOfNature');
                    
                    if($this->input->post('natureOfBusiness'))
                    $setdata2['nature_of_business']=$this->input->post('natureOfBusiness');

                    if($this->input->post('desiredAmount'))
                    $setdata2['desired_amount']=$this->input->post('desiredAmount');

                    if($this->input->post('noOfPartner'))
                    $setdata2['total_director_partner']=$this->input->post('noOfPartner');
                    
                    if($this->input->post('noOfDirector'))
                    $setdata2['total_director_partner']=$this->input->post('noOfDirector');

                    if($this->input->post('referenceName'))
                    $setdata2['reference']=$this->input->post('referenceName');

                    if($this->input->post('referenceNumber'))
                    $setdata2['reference_number']=$this->input->post('referenceNumber');
                    
                    if($detail){
                      $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata2,['user_id'=>$insertId]);
                    }else{
                      $setdata2['user_id']=$insertId;
                      $this->common_model->InsertData(TBL_USER_DETAIL,$setdata2);
                    }
                    if($this->input->post('coApplicant')){
                      $this->common_model->DeleteData('user_co_applicant',['user_id'=>$insertId]);
                      foreach($this->input->post('coApplicant') as $coapplicant){
                        $coapplicant=(object)$coapplicant;
                        $setdata3=[];
                        $setdata3['user_id']=$insertId;
                        $setdata3['name']=$coapplicant->fullName;
                        $setdata3['pan_number']=$coapplicant->panNumber;
                        $setdata3['relationship']=$coapplicant->relationship;
                        $this->common_model->InsertData('user_co_applicant',$setdata3);
                      }              
                    }
                    $returndata=$this->merchant_model->GetUserDetail($insertId);
                    $return =new stdClass;
                    $return->caseId=$returndata->file_id;
                    $return->fullName=$returndata->full_name;
                    $return->email=$returndata->email;
                    $return->mobileNumber=$returndata->mobile_number;
                    $return->occupationType=$returndata->loan_type;
                    $return->houseNo=$returndata->houseno;
                    $return->businessName=$returndata->company_name;
                    $return->typeOfLoan=$returndata->loan_type1;
                    $return->city=$returndata->city;
                    $return->pincode=$returndata->pincode;
                    $return->state=$returndata->state;
                    $return->numberOfYearInBusiness=$returndata->vintage;
                    $return->monthlyTurnOver=$returndata->vintage;
                    $return->typeOfFirm=$returndata->business_type;
                    if($return->typeOfFirm=='PVT .ltd'){
                      $return->noOfDirector=$returndata->total_director_partner;
                    }elseif($return->typeOfFirm=='Partnership'){
                      $return->noOfDirector=$returndata->total_director_partner;
                    }
                    $return->natureOfBusiness=$returndata->nature_of_business;
                    $return->typeOfNature=$returndata->type_of_nature;
                    $return->desiredAmount=$returndata->desired_amount;
                    $return->referenceName=$returndata->reference;
                    $return->referenceNumber=$returndata->reference_number;
                    $return->coApplicant=$this->input->post('coApplicant');
                    return response([ 'status'=>'success','message'=>'Detail submit successfully','next'=>'Upload Documents','data'=>$return]);
                  }else{
                    return response([ 'status'=>'fail','message'=>'Something wrong !']);
                  }
              }else{
                $errors="";
                if(form_error('businessName')){
                  $errors=strip_tags(form_error('businessName'));
                }elseif(form_error('typeOfLoan')){
                  $errors=strip_tags(form_error('typeOfLoan'));
                }elseif(form_error('houseNo')){
                  $errors=strip_tags(form_error('houseNo'));
                }elseif(form_error('pincode')){
                  $errors=strip_tags(form_error('pincode'));
                }elseif(form_error('state')){
                  $errors=strip_tags(form_error('state'));
                }elseif(form_error('city')){
                  $errors=strip_tags(form_error('city'));
                }elseif(form_error('numberOfYearInBusiness')){
                  $errors=strip_tags(form_error('numberOfYearInBusiness'));
                }elseif(form_error('typeOfFirm')){
                  $errors=strip_tags(form_error('typeOfFirm'));
                }elseif(form_error('natureOfBusiness')){
                  $errors=strip_tags(form_error('natureOfBusiness'));
                }elseif(form_error('noOfPartner')){
                  $errors=strip_tags(form_error('noOfPartner'));
                }elseif(form_error('noOfDirector')){
                  $errors=strip_tags(form_error('noOfDirector'));
                }elseif(form_error('typeOfNature')){
                  $errors=strip_tags(form_error('typeOfNature'));
                }elseif(form_error('monthlyTurnOver')){
                  $errors=strip_tags(form_error('monthlyTurnOver'));
                }elseif(form_error('desiredAmount')){
                  $errors=strip_tags(form_error('desiredAmount'));
                }elseif(form_error('coApplicant')){
                  $errors=strip_tags(form_error('coApplicant'));
                }elseif(form_error('referenceNumber')){
                  $errors=strip_tags(form_error('referenceNumber'));
                }
                return response([ 'status'=>'fail','message'=>$errors]);
              }
            }else{
              $this->form_validation->set_rules('dateOfBirth','Date Of Birth','trim|callback_ValidDateofBirth[dateOfBirth]');
              $this->form_validation->set_rules('gender','Gender','trim|callback_ValidateGender[gender]');
              $this->form_validation->set_rules('qualification','Qualification','trim|callback_ValidateQualification[qualification]');
              $this->form_validation->set_rules('maritalStatus','Marital Status','trim|callback_ValidateMarital[maritalStatus]');
              $this->form_validation->set_rules('vehicleType','Vehicle Type','trim|callback_ValidateVehicleType[vehicleType]');
              $this->form_validation->set_rules('yearAtCurrenOrganization','Year At Current Organization','trim|numeric');
              $this->form_validation->set_rules('organizationType','Organization Type','trim|callback_ValidateOrganizationType[organizationType]');
              /* $this->form_validation->set_rules('totalExperience','Total Experience','trim|required');
              $this->form_validation->set_rules('companyBuilding','Company Building','trim|required');
              $this->form_validation->set_rules('companyArea','Company Area','trim|required'); */
              $this->form_validation->set_rules('companyPincode','Company Pincode','trim|numeric|min_length[6]|max_length[6]');
              /* $this->form_validation->set_rules('companyState','Company State','trim|required');
              $this->form_validation->set_rules('companyCity','Company City','trim|required'); */
              $this->form_validation->set_rules('companyEmail','Company Email','trim|valid_email');
              $this->form_validation->set_rules('monthlyTakeHome','Monthly Take Home','trim|numeric');
              $this->form_validation->set_rules('salaryReceiveMode','Salary Receive Mode','trim|callback_ValidateSalaryMode[salaryReceiveMode]');
              $this->form_validation->set_rules('residencePincode','Residence Pincode','trim|numeric|min_length[6]|max_length[6]');
              $this->form_validation->set_rules('referenceNumber','Reference Number','trim|numeric|min_length[10]|max_length[10]');
              if($this->form_validation->run()==TRUE){
                $setdata=[];
                if($this->input->post('FatherName'))
                $setdata['father_name']=$this->input->post('FatherName');

                if($this->input->post('dateOfBirth'))
                $setdata['date_of_birth']=$this->input->post('dateOfBirth');

                if($this->input->post('gender'))
                $setdata['gender']=$this->input->post('gender');

                if($this->input->post('qualification'))
                $setdata['qualification']=$this->input->post('qualification');

                if($this->input->post('maritalStatus'))
                $setdata['marital_status']=$this->input->post('maritalStatus');

                if($this->input->post('numberOfKids'))
                $setdata['number_of_kids']=$this->input->post('numberOfKids');

                if($this->input->post('vehicleType'))
                $setdata['vehicle_type']=$this->input->post('vehicleType');

                if($this->input->post('employerName'))
                $setdata['employer_name']=$this->input->post('employerName');

                if($this->input->post('designation'))
                $setdata['designation']=$this->input->post('designation');

                if($this->input->post('yearAtCurrenOrganization'))
                $setdata['organization']=$this->input->post('yearAtCurrenOrganization');

                if($this->input->post('organizationType'))
                $setdata['organization_type']=$this->input->post('organizationType');

                if($this->input->post('totalExperience'))
                $setdata['total_experience']=$this->input->post('totalExperience');

                if($this->input->post('companyBuilding'))
                $setdata['company_building']=$this->input->post('companyBuilding');

                if($this->input->post('companyArea'))
                $setdata['company_area']=$this->input->post('companyArea');

                if($this->input->post('companyPincode'))
                $setdata['company_pincode']=$this->input->post('companyPincode');

                if($this->input->post('companyState'))
                $setdata['company_state']=$this->input->post('companyState');

                if($this->input->post('companyCity'))
                $setdata['company_city']=$this->input->post('companyCity');

                if($this->input->post('companyEmail'))
                $setdata['company_email']=$this->input->post('companyEmail');

                if($this->input->post('companyWebsite'))
                $setdata['company_website']=$this->input->post('companyWebsite');

                if($this->input->post('monthlyTakeHome'))
                $setdata['salery_inhand']=$this->input->post('monthlyTakeHome');

                if($this->input->post('salaryReceiveMode'))
                $setdata['salary_mode']=$this->input->post('salaryReceiveMode');

                if($this->input->post('residenceBuilding'))
                $setdata['residence_building']=$this->input->post('residenceBuilding');

                if($this->input->post('residenceArea'))
                $setdata['residence_area']=$this->input->post('residenceArea');

                if($this->input->post('residencePincode'))
                $setdata['residence_pincode']=$this->input->post('residencePincode');

                if($this->input->post('residenceState'))
                $setdata['residence_state']=$this->input->post('residenceState');

                if($this->input->post('residenceCity'))
                $setdata['residence_city']=$this->input->post('residenceCity');

                if($this->input->post('residenceType'))
                $setdata['residence_type']=$this->input->post('residenceType');

                if($this->input->post('yearAtResidence'))
                $setdata['year_at_residence']=$this->input->post('yearAtResidence');

                if($this->input->post('referenceName'))
                $setdata['reference']=$this->input->post('referenceName');

                if($this->input->post('referenceNumber'))
                $setdata['reference_number']=$this->input->post('referenceNumber');
                
                $detail=$this->common_model->GetRow('user_detail',['user_id'=>$record->user_id]);
                if($detail){
                  $this->common_model->UpdateData('user_detail',$setdata,['user_id'=>$record->user_id]);
                }else{
                  $setdata['user_id']=$record->user_id;
                  $this->common_model->InsertData('user_detail',$setdata);
                }
                $returndata=$this->merchant_model->GetUserDetail2($record->user_id);
                $return=new stdClass;
                $return->caseId=$returndata->file_id;
                $return->fullName=$returndata->full_name;
                $return->mobileNumber=$returndata->mobile_number;
                $return->email=$returndata->email;
                $return->age=$returndata->age;
                $return->occupationType=$returndata->loan_type;
                $return->dateOfBirth=$returndata->date_of_birth;
                $return->gender=$returndata->gender;
                $return->qualification=$returndata->qualification;
                $return->maritalStatus=$returndata->marital_status;
                $return->numberOfKids=$returndata->number_of_kids;
                $return->vehicleType=$returndata->vehicle_type;
                $return->employerName=$returndata->employer_name;
                $return->designation=$returndata->designation;
                $return->yearAtCurrenOrganization=$returndata->organization;
                $return->organizationType=$returndata->organization_type;
                $return->totalExperience=$returndata->total_experience;
                $return->companyBuilding=$returndata->company_building;
                $return->companyArea=$returndata->company_area;
                $return->companyPincode=$returndata->company_pincode;
                $return->companyCity=$returndata->company_city;
                $return->companyState=$returndata->company_state;
                $return->companyBuilding=$returndata->company_building;
                $return->companyEmail=$returndata->company_email;
                $return->companyWebsite=$returndata->company_website;
                $return->monthlyTakeHome=$returndata->salery_inhand;
                $return->salaryReceiveMode=$returndata->salary_mode;
                $return->salaryReceiveMode=$returndata->salary_mode;
                $return->residenceBuilding=$returndata->residence_building;
                $return->residenceArea=$returndata->residence_area;
                $return->residencePincode=$returndata->residence_pincode;
                $return->residenceState=$returndata->residence_state;
                $return->residenceCity=$returndata->residence_city;
                $return->residenceType=$returndata->residence_type;
                $return->yearAtResidence=$returndata->year_at_residence;
                $return->referenceName=$returndata->reference;
                $return->referenceNumber=$returndata->reference_number;
                return response([ 'status'=>'success','message'=>'Detail submit successfully', 'next'=>'Upload Documents','data'=>$return]);
              }else{
                  $error='';
                  if(form_error('fatherName')){
                    $error=form_error('fatherName');
                  }elseif(form_error('dateOfBirth')){
                    $error=form_error('dateOfBirth');
                  }elseif(form_error('gender')){
                    $error=form_error('gender');
                  }elseif(form_error('qualification')){
                    $error=form_error('qualification');
                  }elseif(form_error('maritalStatus')){
                    $error=form_error('maritalStatus');
                  }elseif(form_error('numberOfKids')){
                    $error=form_error('numberOfKids');
                  }elseif(form_error('vehicleType')){
                    $error=form_error('vehicleType');
                  }elseif(form_error('employerName')){
                    $error=form_error('employerName');
                  }elseif(form_error('designation')){
                    $error=form_error('designation');
                  }elseif(form_error('yearAtCurrenOrganization')){
                    $error=form_error('yearAtCurrenOrganization');
                  }elseif(form_error('organizationType')){
                    $error=form_error('organizationType');
                  }elseif(form_error('totalExperience')){
                    $error=form_error('totalExperience');
                  }elseif(form_error('companyBuilding')){
                    $error=form_error('companyBuilding');
                  }elseif(form_error('companyArea')){
                    $error=form_error('companyArea');
                  }elseif(form_error('companyPincode')){
                    $error=form_error('companyPincode');
                  }elseif(form_error('companyState')){
                    $error=form_error('companyState');
                  }elseif(form_error('companyCity')){
                    $error=form_error('companyCity');
                  }elseif(form_error('companyEmail')){
                    $error=form_error('companyEmail');
                  }elseif(form_error('monthlyTakeHome')){
                    $error=form_error('monthlyTakeHome');
                  }elseif(form_error('salaryReceiveMode')){
                    $error=form_error('salaryReceiveMode');
                  }elseif(form_error('residenceBuilding')){
                    $error=form_error('residenceBuilding');
                  }elseif(form_error('residenceArea')){
                    $error=form_error('residenceArea');
                  }elseif(form_error('residencePincode')){
                    $error=form_error('residencePincode');
                  }elseif(form_error('residenceState')){
                    $error=form_error('residenceState');
                  }elseif(form_error('residenceCity')){
                    $error=form_error('residenceCity');
                  }elseif(form_error('residenceType')){
                    $error=form_error('residenceType');
                  }elseif(form_error('yearAtResidence')){
                    $error=form_error('yearAtResidence');
                  }elseif(form_error('referenceName')){
                    $error=strip_tags(form_error('referenceName'));
                  }elseif(form_error('referenceNumber')){
                    $error=strip_tags(form_error('referenceNumber'));
                  }
                  return response([ 'status'=>'fail','message'=>strip_tags($error)]);
              }
            }
          }else{
            return response([ 'status'=>'fail','message'=>'User does not exists']);
          }
        }else{
          return response(['status'=>'fail','message'=>"Ip is not whitelist"]);
        }
      }
    }
    public function ValidPanNumber(){
      if($this->input->post('panNumber')){
        if(!preg_match('/^[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}$/',$this->input->post('panNumber'))){
          $this->form_validation->set_message('ValidPanNumber','Please Enter Valid Pan Number');
          return FALSE;
        }else{
          return TRUE;
        }
      }
    }
    public function CheckDocument($id){
      $record = $this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$id]);
      if($record){
          if($record->business_type=='PVT .ltd'){
            if($record->pancard_image==null){
              return 'Pan';
            }elseif($record->business_address_proof==null){
              return 'Business';
            }elseif($record->tan_image==null){
              return 'MOA';
            }elseif($record->coi_image==null){
              return 'COI';
            }elseif($record->bank_statement==null){
              return 'Bankstatement';
            }elseif($record->boardresolution==null){
              return 'BoardResolution';
            }else{
              return 'OK';
            }
          }elseif($record->business_type=='Partnership'){
            if($record->pancard_image==null){
              return 'Pan';
            }elseif($record->business_address_proof==null){
              return 'Business';
            }elseif($record->bank_statement==null){
              return 'Bankstatement';
            }elseif($record->ownership_proof==null){
              return 'Ownership';
            }elseif($record->partnership_deal==null){
              return 'PartnershipDeed';
            }else{
              return 'OK';
            }
          }elseif($record->business_type=='Proprietorship'){
            if($record->pancard_image==null){
              return 'Pan';

            }elseif($record->business_address_proof==null){
              return 'Business';
            }elseif($record->resident_address_proof==null){
              return 'Residence';
            }elseif($record->bank_statement==null){
              return 'Bankstatement';
            }else{
              return 'OK';
            }
          }elseif($record->business_type=='Individual'){
            if($record->pancard_image==null){
              return 'Pan';
            }elseif($record->business_address_proof==null){
              return 'Business';
            }elseif($record->resident_address_proof==null){
              return 'Residence';
            }elseif($record->bank_statement==null){
              return 'Bankstatement';
            }else{
              return 'OK';
            }
          }
      }
    }
    private function FileUploadMultiple($files,$name,$path,$fileid=""){
      $uploadedimage=[];
      $newindex=1;
      for($i=0;$i<count($files['name']);$i++){
        $_FILES[$name]['name']=$files['name'][$i];
        $_FILES[$name]['type']=$files['type'][$i];
        $_FILES[$name]['tmp_name']=$files['tmp_name'][$i];
        $_FILES[$name]['error']=$files['error'][$i];
        $_FILES[$name]['size']=$files['size'][$i];

        $extension=pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
        if(!empty($fileid)){
          $_FILES[$name]['name']=$fileid.'-'.$newindex.'-'.$name.".".$extension;
        }else{
          $_FILES[$name]['name']=time().rand(10000,99999).".".$extension;
        }
        $config['upload_path']          = $path;
        $config['allowed_types']        = 'png|jpeg|jpg|pdf|doc|docx';
        $this->load->library('upload',$config);
        $this->upload->initialize($config);
        if($this->upload->do_upload($name))
        {
          $image = $this->upload->data();
          $uploadedimage[]=$image['file_name'];
          $newindex++;
        }
      }
      return $uploadedimage;
    }
    public function UploadsDocument(){
      $verify=$this->VerifySecretKey();
      if(!$verify){
        return response(['status'=>'fail','message'=>'Invalid Secret Key']);
      }
      $ip_address=$this->input->ip_address();
      if($this->ValidIp($ip_address)){  
        $userdata= $this->common_model->GetRow(TBL_USERS,['file_id'=>trim($this->input->post('caseId')),'user_type'=>'MERCHANT']);
        if(!empty($userdata)){
          if($userdata->status==null){
            return response([ 'status'=>'fail','message'=>'User Already Exists']);
          }
          if($this->input->post('documentType') =='Pan'){
            $this->form_validation->set_rules('documentText','Pan Number','trim|required|callback_ValidatePan[documentText]');
            if($this->form_validation->run()!=TRUE){
              return response([ 'status'=>'fail','message'=>strip_tags(form_error('documentText'))]);
            }
          }else if($this->input->post('documentType') =='Business'){
            $this->form_validation->set_rules('documentText','Business Address','trim|required');
            if($this->form_validation->run()!=TRUE){
              return response([ 'status'=>'fail','message'=>strip_tags(form_error('documentText'))]);
            }
          }else if($this->input->post('documentType') =='Residence'){
            $this->form_validation->set_rules('documentText','Residence Address','trim|required');
            if($this->form_validation->run()!=TRUE){
              return response([ 'status'=>'fail','message'=>strip_tags(form_error('documentText'))]);
            }
          }else if($this->input->post('documentType') =='Aadharcard'){
            $this->form_validation->set_rules('documentText','Aadhar Number','trim|required|numeric|min_length[12]|max_length[12]');
            if($this->form_validation->run()!=TRUE){
              return response([ 'status'=>'fail','message'=>strip_tags(form_error('documentText'))]);
            }
          }
          if(!empty($_FILES['document'])){
            if($this->input->post('documentType')=='Bankstatement' || $this->input->post('documentType')=='Salaryslip'){
              for($i=0;$i<count($_FILES['document']['name']);$i++){
                $extension=pathinfo($_FILES['document']['name'][$i],PATHINFO_EXTENSION);
                if(strtolower($extension)!='pdf'){
                  return response([ 'status'=>'fail','message'=>'Only pdf type allowed']);
                }
              }
            }else{
              for($i=0;$i<count($_FILES['document']['name']);$i++){
                $extension=pathinfo($_FILES['document']['name'][$i],PATHINFO_EXTENSION);
                if(!in_array(strtolower($extension),['pdf','jpg','jpeg','png','doc','docx'])){
                  return response([ 'status'=>'fail','message'=>'Only pdf,jpg,jpeg,doc,docx type allowed']);
                }
              }
            }
          }else{
            return response([ 'status'=>'fail','message'=>'Document is Required']);
          }
          if($userdata->loan_type=='Business'){
            $detail= $this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$userdata->user_id]);
            $firmType=$detail->business_type;
            if($firmType=='Individual'){
              if($this->input->post('documentType')=='Pan'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'pancard','uploads/merchant/pancard',$userdata->file_id);
                if(!empty($upload)){
                  $setdata=[];
                  $setdata['pan_number']=$this->input->post('documentText');
                  $setdata['pancard_image']=implode(',',$upload);
                  $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                  return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }elseif($this->input->post('documentType')=='Business'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'businessproof','uploads/merchant/business',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['business_address']=$this->input->post('documentText');
                    $setdata['business_address_proof']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }elseif($this->input->post('documentType')=='Residence'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'residenceproof','uploads/merchant/resident',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['resident_address']=$this->input->post('documentText');
                    $setdata['resident_address_proof']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }elseif($this->input->post('documentType')=='Bankstatement'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'bankstatement','uploads/merchant/bankstatement',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['bank_statement']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    return response([ 'status'=>'success','message'=>'Registration Successful']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }else{
                return response([ 'status'=>'fail','message'=>'Invalid Document Type']);
              }

            }elseif($firmType=='Proprietorship'){

              if($this->input->post('documentType')=='Pan'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'pancard','uploads/merchant/pancard',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['pan_number']=$this->input->post('documentText');
                    $setdata['pancard_image']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }if($this->input->post('documentType')=='Gst'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'gstproof','uploads/merchant/gst',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['gst_number']=$this->input->post('documentText');
                    $setdata['gstproof_image']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }elseif($this->input->post('documentType')=='Business'){
                  $upload =$this->FileUploadMultiple($_FILES['document'],'businessproof','uploads/merchant/business',$userdata->file_id);
                  if(!empty($upload)){
                      $setdata=[];
                      $setdata['business_address']=$this->input->post('documentText');
                      $setdata['business_address_proof']=implode(',',$upload);
                      $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                      return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                  }else{
                    return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                  }
              }elseif($this->input->post('documentType')=='Residence'){
                  $upload =$this->FileUploadMultiple($_FILES['document'],'residenceproof','uploads/merchant/resident',$userdata->file_id);
                  if(!empty($upload)){
                      $setdata=[];
                      $setdata['resident_address']=$this->input->post('documentText');
                      $setdata['resident_address_proof']=implode(',',$upload);
                      $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                      return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                  }else{
                    return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                  }
              }elseif($this->input->post('documentType')=='Bankstatement'){
                  $upload =$this->FileUploadMultiple($_FILES['document'],'bankstatement','uploads/merchant/bankstatement',$userdata->file_id);
                  if(!empty($upload)){
                      $setdata=[];
                      $setdata['bank_statement']=implode(',',$upload);
                      $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                      return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                  }else{
                    return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                  }
              }else{
                return response([ 'status'=>'fail','message'=>'Invalid Document Type']);
              }

            }elseif($firmType=='Partnership'){
              if($this->input->post('documentType')=='Pan'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'pancard','uploads/merchant/pancard',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['pan_number']=$this->input->post('documentText');
                    $setdata['pancard_image']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }if($this->input->post('documentType')=='Gst'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'gstproof','uploads/merchant/gst',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['gst_number']=$this->input->post('documentText');
                    $setdata['gstproof_image']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }elseif($this->input->post('documentType')=='Business'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'businessproof','uploads/merchant/business',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['business_address']=$this->input->post('documentText');
                    $setdata['business_address_proof']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }elseif($this->input->post('documentType')=='Bankstatement'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'bankstatement','uploads/merchant/bankstatement',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['bank_statement']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    
                    return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }elseif($this->input->post('documentType')=='Ownership'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'ownership','uploads/merchant/ownership',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['ownership_proof']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }elseif($this->input->post('documentType')=='PartnershipDeed'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'partnership','uploads/merchant/partnership',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['partnership_deal']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }else{
                return response([ 'status'=>'fail','message'=>'Invalid Document Type']);
              }

            }elseif($firmType=='PVT .ltd'){
              if($this->input->post('documentType')=='Pan'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'pancard','uploads/merchant/pancard',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['pan_number']=$this->input->post('documentText');
                    $setdata['pancard_image']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }if($this->input->post('documentType')=='Gst'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'gstproof','uploads/merchant/gst',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['gst_number']=$this->input->post('documentText');
                    $setdata['gstproof_image']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }elseif($this->input->post('documentType')=='Business'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'businessproof','uploads/merchant/business',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['business_address']=$this->input->post('documentText');
                    $setdata['business_address_proof']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }elseif($this->input->post('documentType')=='MOA'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'moa-aoa','uploads/merchant/tan',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['tan_image']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }elseif($this->input->post('documentType')=='COI'){
                  $upload =$this->FileUploadMultiple($_FILES['document'],'coi','uploads/merchant/coi',$userdata->file_id);
                  if(!empty($upload)){
                      $setdata=[];
                      $setdata['coi_image']=implode(',',$upload);
                      $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                      return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                  }else{
                    return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                  }
              }elseif($this->input->post('documentType')=='Bankstatement'){
                $upload =$this->FileUploadMultiple($_FILES['document'],'bankstatement','uploads/merchant/bankstatement',$userdata->file_id);
                if(!empty($upload)){
                    $setdata=[];
                    $setdata['bank_statement']=implode(',',$upload);
                    $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                    return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                }else{
                  return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                }
              }elseif($this->input->post('documentType')=='BoardResolution'){
                  $upload =$this->FileUploadMultiple($_FILES['document'],'board-resolution','uploads/merchant/boardresolution',$userdata->file_id);
                  if(!empty($upload)){
                      $setdata=[];
                      $setdata['boardresolution']=implode(',',$upload);
                      $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$userdata->user_id]);
                      return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
                  }else{
                    return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
                  }
              }else{
                return response([ 'status'=>'fail','message'=>'Invalid Document Type']);
              }
            }else{
              return response([ 'status'=>'fail','message'=>'Something Wrong']);
            }
          }else{
            if($this->input->post('documentType')=='Pan'){
              $upload =$this->FileUploadMultiple($_FILES['document'],'pancard','uploads/merchant/pancard',$userdata->file_id);
              if(!empty($upload)){
                $setdata=[];
                $setdata['pan_number']=$this->input->post('documentText');
                $setdata['pancard_image']=implode(',',$upload);
                $this->common_model->UpdateData('user_detail',$setdata,['user_id'=>$userdata->user_id]);
                return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
              }else{
                return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
              }
            }elseif($this->input->post('documentType')=='Aadharcard'){
              $upload =$this->FileUploadMultiple($_FILES['document'],'addharcard','uploads/merchant/aadharcard',$userdata->file_id);
              if(!empty($upload)){
                $setdata=[];
                $setdata['aadhar_number']=$this->input->post('documentText');
                $setdata['aadhar_image']=implode(',',$upload);
                $this->common_model->UpdateData('user_detail',$setdata,['user_id'=>$userdata->user_id]);
                return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
              }else{
                return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
              }
            }elseif($this->input->post('documentType')=='CurrentAddress'){
              $upload =$this->FileUploadMultiple($_FILES['document'],'residence-address','uploads/merchant/resident',$userdata->file_id);
              if(!empty($upload)){
                $setdata=[];
                $setdata['residence_address_proof']=implode(',',$upload);
                $this->common_model->UpdateData('user_detail',$setdata,['user_id'=>$userdata->user_id]);
                return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
              }else{
                return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
              }
            }elseif($this->input->post('documentType')=='Salaryslip'){
              $upload =$this->FileUploadMultiple($_FILES['document'],'salary-slip','uploads/merchant/salery_slip',$userdata->file_id);
              if(!empty($upload)){
                $setdata=[];
                $setdata['salery_slip']=implode(',',$upload);
                $this->common_model->UpdateData('user_detail',$setdata,['user_id'=>$userdata->user_id]);
                return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
              }else{
                return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
              }
            }elseif($this->input->post('documentType')=='Bankstatement'){
              $upload =$this->FileUploadMultiple($_FILES['document'],'bankstatement','uploads/merchant/bankstatement',$userdata->file_id);
              if(!empty($upload)){
                $setdata=[];
                $setdata['bank_statement']=implode(',',$upload);
                $this->common_model->UpdateData('user_detail',$setdata,['user_id'=>$userdata->user_id]);
                return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
              }else{
                return response([ 'status'=>'fail','message'=>'Document Uploading Failed']);
              }
            }
          }
        }else{
          return response([ 'status'=>'fail','message'=>'Unable to find user']);
        }
      }else{
         return response(['status'=>'fail','message'=>"Ip is not whitelist"]);
      }
    }
    private function CheckPDocument($user_id){
      $record=$this->common_model->GetRow('user_detail',['user_id'=>$user_id]);
      if($record){
        if($record->pancard_image==null){
          return 'Pan';
        }elseif($record->aadharcard_image==null){
          return 'Aadharcard';
        }elseif($record->residence_address_proof==null){
          return 'CurrentAddress';
        }elseif($record->salery_slip==null){
          return 'Salaryslip';
        }elseif($record->salery_slip==null){
          return 'Bankstatement';
        }else{
          return 'OK';
        }
      }else{
        return 'Pan';
      }
    }
    public function ValidatePan($val,$str){
      if(!empty($val)){
        if(!preg_match('/^[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}$/',$val)){
          $this->form_validation->set_message('ValidatePan','Enter Valid Pan Number');
          return FALSE;
        }else{
          return true;
        }
      }
    }
    public function UploadOtherDocument(){
      $verify=$this->VerifySecretKey();
      if(!$verify){
        return response(['status'=>'fail','message'=>'Invalid Secret Key']);
      }
      $ip_address=$this->input->ip_address();
      if($this->ValidIp($ip_address)){
        $userdata=$this->common_model->GetRow(TBL_USERS,['file_id'=>trim($this->input->post('caseId')),'user_type'=>'MERCHANT']);
        if($userdata){
          if($userdata->status==null){
            return response([ 'status'=>'fail','message'=>'User Apleard Exists']);
          }
          $detail=$this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$userdata->user_id]);
          if($detail && ($detail->business_type=='Partnership' || $detail->business_type=='PVT .ltd')){
            $this->form_validation->set_rules('name','Full Name','trim|required');
            $this->form_validation->set_rules('panNumber','Pan Number','trim|required|callback_ValidatePan[panNumber]');
            $this->form_validation->set_rules('address','Address','trim|required');
            if($this->form_validation->run()==TRUE){
              /* $document = $this->CheckDocument($userdata->user_id);
              if($document=='OK'){ */
                if($this->input->post('documentType')=='Partner'){
                  if(!empty($_FILES['partnerProof']['name'])){
                    for($i=0;$i<count($_FILES['partnerProof']['name']);$i++){
                      $extension=pathinfo($_FILES['partnerProof']['name'][$i],PATHINFO_EXTENSION);
                      if(!in_array($extension,['pdf','jpg','jpeg','png','doc','docx'])){
                        return response([ 'status'=>'fail','message'=>'Only pdf,jpg,jpeg,doc,docx type allowed']);
                      }
                    }
                  }else{
                    return response([ 'status'=>'fail','message'=>'Partner Proof Required']);
                  }
                }
                if(!empty($_FILES['panCard']['name'])){
                  for($i=0;$i<count($_FILES['panCard']['name']);$i++){
                    $extension=pathinfo($_FILES['panCard']['name'][$i],PATHINFO_EXTENSION);
                    if(!in_array($extension,['pdf','jpg','jpeg','png','doc','docx'])){
                      return response([ 'status'=>'fail','message'=>'Only pdf,jpg,jpeg,doc,docx type allowed']);
                    }
                  }
                }else{
                  return response([ 'status'=>'fail','message'=>'Pancard Required']);
                }
                if(!empty($_FILES['addressProof']['name'])){
                  for($i=0;$i<count($_FILES['addressProof']['name']);$i++){
                    $extension=pathinfo($_FILES['addressProof']['name'][$i],PATHINFO_EXTENSION);
                    if(!in_array($extension,['pdf','jpg','jpeg','png','doc','docx'])){
                      return response([ 'status'=>'fail','message'=>'Only pdf,jpg,jpeg,doc,docx type allowed']);
                    }
                  }
                }else{
                  return response([ 'status'=>'fail','message'=>'Address Proof Required']);
                }
              /* }else{
                return response([ 'status'=>'fail','message'=>'Pervious Document Not Uploaded']);
              } */
              $countP= $this->common_model->CountResults('user_business_partner',['user_id'=>$userdata->user_id]);
              if($countP<$detail->total_director_partner){
                $setdata=[];
                $setdata['user_id']=$userdata->user_id;
                $setdata['name']=$this->input->post('name');
                $setdata['pan_number']=$this->input->post('panNumber');
                $setdata['address']=$this->input->post('address');
                if($this->input->post('documentType')=='Partner'){
                  $upload =$this->FileUploadMultiple($_FILES['partnerProof'],'other','uploads/merchant/other');
                  if(!empty($upload)){
                      $setdata['director_partner_proof']=implode(',',$upload);
                  }
                }
                $upload =$this->FileUploadMultiple($_FILES['panCard'],'pancard','uploads/merchant/other');
                if(!empty($upload)){
                  $setdata['pancard_image']=implode(',',$upload);
                }
                $upload =$this->FileUploadMultiple($_FILES['addressProof'],'address','uploads/merchant/other');
                if(!empty($upload)){
                  $setdata['address_proof']=implode(',',$upload);
                }
                $this->common_model->InsertData('user_business_partner',$setdata);
                return response([ 'status'=>'success','message'=>'Document Uploaded Successfully']);
              }else{
                return faliure([ 'status'=>'fail','message'=>'Failure']);
              }

            }else{
              $errors="";
              if(form_error('name')){
                $errors=strip_tags(form_error('name'));
              }elseif(form_error('panNumber')){
                $errors=strip_tags(form_error('panNumber'));
              }elseif(form_error('address')){
                $errors=strip_tags(form_error('address'));
              }
              return response([ 'status'=>'fail','message'=>$errors]);
            }
          }else{
            return response([ 'status'=>'fail','message'=>'Document Required only for Partnership/PVT .ltd']);
          }
        }else{
          return response([ 'status'=>'fail','message'=>'Unable to find user']);
        }
      }else{
        return response(['status'=>'fail','message'=>"Ip is not whitelist"]);
      }
    }
 
  public function DataEntry(){
    $this->form_validation->set_rules('type_of_location','Type Of Location','trim|required');
    $this->form_validation->set_rules('location','Location','trim|required');
    $this->form_validation->set_rules('social_days','Social Days','trim|required');
    $this->form_validation->set_rules('contact_person','Contact Person Name','trim|required');
    $this->form_validation->set_rules('contact_mobile_phone','Mobile Number','trim|required|numeric|min_length[10]|max_length[10]');
    $this->form_validation->set_rules('entry_by','Data Entry By','trim|required');
    $this->form_validation->set_rules('morning_start_time','Morning Start Time','trim|required');
    $this->form_validation->set_rules('morning_end_time','Morning End Time','trim|required');
    $this->form_validation->set_rules('evening_start_time','Evening Start Time','trim|required');
    $this->form_validation->set_rules('evening_end_time','Evening Start Time','trim|required');
    if(empty($_FILES['image1']['name'])){
      $this->form_validation->set_rules('image1','Image 2','required');
    }else{
      for($i=0;$i<count($_FILES['image1']['name']);$i++){
        $extension=pathinfo($_FILES['image1']['name'][$i],PATHINFO_EXTENSION);
        if(!in_array($extension,['pdf','jpg','jpeg','png','doc','docx'])){
          return response([ 'status'=>'fail','message'=>'Only pdf,jpg,jpeg,doc,docx type allowed']);
        }
      }
    }
    if(empty($_FILES['image2']['name'])){
      $this->form_validation->set_rules('image2','Image 2','trim|required');
    }else{
      for($i=0;$i<count($_FILES['image2']['name']);$i++){
        $extension=pathinfo($_FILES['image2']['name'][$i],PATHINFO_EXTENSION);
        if(!in_array($extension,['pdf','jpg','jpeg','png','doc','docx'])){
          return response([ 'status'=>'fail','message'=>'Only pdf,jpg,jpeg,doc,docx type allowed']);
        }
      }
    }
    if($this->form_validation->run()==TRUE){
      $setdata=[];
      $setdata['type_of_location']=$this->input->post('type_of_location');
      $setdata['location']=$this->input->post('location');
      $setdata['timing_of_operation']=$this->input->post('timing_of_operation');
      $setdata['social_days']=$this->input->post('social_days');
      $setdata['contact_person']=$this->input->post('contact_person');
      $setdata['contact_mobile_phone']=$this->input->post('contact_mobile_phone');
      $setdata['morning_start_time']=$this->input->post('morning_start_time');
      $setdata['morning_end_time']=$this->input->post('morning_end_time');
      $setdata['evening_start_time']=$this->input->post('evening_start_time');
      $setdata['evening_end_time']=$this->input->post('evening_end_time');
      $setdata['entry_by']=$this->input->post('entry_by');
      $image1 =$this->FileUploadMultiple($_FILES['image1'],'image1','uploads/test');
      if($image1){
        $setdata['image1']=implode(',',$image1);
      }
      $image2 =$this->FileUploadMultiple($_FILES['image2'],'image2','uploads/test');
      if($image2){
        $setdata['image2']=implode(',',$image2);
      }
      if($this->common_model->InsertData('data_entry',$setdata)){
        return response([ 'status'=>'success','message'=>'Success']);
      }else{
        return response([ 'status'=>'fail','message'=>'Something Wrong']);
      }
    }else{
      $errors="";
      if(form_error('type_of_location')){
        $errors=strip_tags(form_error('type_of_location'));
      }elseif(form_error('location')){
        $errors=strip_tags(form_error('location'));
      }elseif(form_error('social_days')){
        $errors=strip_tags(form_error('social_days'));
      }elseif(form_error('contact_person')){
        $errors=strip_tags(form_error('contact_person'));
      }elseif(form_error('contact_mobile_phone')){
        $errors=strip_tags(form_error('contact_mobile_phone'));
      }elseif(form_error('entry_by')){
        $errors=strip_tags(form_error('entry_by'));
      }elseif(form_error('morning_start_time')){
        $errors=strip_tags(form_error('morning_start_time'));
      }elseif(form_error('morning_end_time')){
        $errors=strip_tags(form_error('morning_end_time'));
      }elseif(form_error('evening_start_time')){
        $errors=strip_tags(form_error('evening_start_time'));
      }elseif(form_error('evening_end_time')){
        $errors=strip_tags(form_error('evening_end_time'));
      }elseif(form_error('image1')){
        $errors=strip_tags(form_error('image1'));
      }elseif(form_error('image2')){
        $errors=strip_tags(form_error('image2'));
      }
      return response([ 'status'=>'fail','message'=>$errors]);
    }
  }
  public function checkStatus(){
    if($this->input->server('REQUEST_METHOD')=='POST'){
      $verify=$this->VerifySecretKey();
      if(!$verify){
        return response(['status'=>'fail','message'=>'Invalid Secret Key']);
      }
      $ip_address=$this->input->ip_address();
      if($this->ValidIp($ip_address)){
        $_POST=params();
        $userdata=$this->common_model->GetRow(TBL_USERS,['file_id'=>$this->input->post('caseId'),'user_type'=>'MERCHANT']);
        if($userdata){
          $status="";
          if($userdata->status=='INCOMPLETE'){
            $status="INCOMPLETE";
          }else{
            $assign=$this->common_model->GetRow(TBL_LENDER_ASSIGN,['merchant_id'=>$userdata->user_id]);
            if(!empty($assign) && $assign->status!=""){
              $status=$assign->status;
            }else{
              $status="RECEIVED";
            }
          }
          return response(['status'=>'success','message'=>'Success','data'=>['caseStatus'=>$status]]);
        }else{
          return response(['status'=>'fail','message'=>"User not find"]);
        }
      }else{
        return response(['status'=>'fail','message'=>"Ip is not whitelist"]);
      }
    }else{
      return response(['status'=>'fail','message'=>"Invalid Method"]);
    }
  }
}