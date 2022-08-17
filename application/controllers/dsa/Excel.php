<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->output->delete_cache();
        $this->load->helper('dsa');
        isDsaLogin();
    }
    public function add(){
        $case_data = [];
        $first_data = [];
		if ($this->input->server('REQUEST_METHOD') == "POST") {
			$this->load->library('PHPExcel');
			if (!empty($_FILES['csvexcel']['name'])) {
                $isupload=false;
                if($this->input->post('occupationtype')=='Business' && $_FILES['csvexcel']['name']=='Fintranxect-Business-Type.xlsx'){
                    $isupload=true;
                }elseif($this->input->post('occupationtype')=='Salaried' && $_FILES['csvexcel']['name']=='Fintranxect-Salaried-Type.xlsx'){
                    $isupload=true;
                }
                if($isupload){
                    $extension = pathinfo($_FILES['csvexcel']['name'], PATHINFO_EXTENSION);
                    $_FILES['csvexcel']['name'] = "ExcelImport." . $extension;
                    $config['upload_path']          = 'uploads/excel';
                    $config['allowed_types']        = 'xlsx|csv';
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('csvexcel')) {
                        $file_data = $this->upload->data();
                        $file_path =  $file_data['full_path'];
                        $objPHPExcel = PHPExcel_IOFactory::load($file_path);
                        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                        $data_value = array_filter($cell_collection);
                        foreach ($cell_collection as $cell) {
                            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                            if ($row != 1) {
                                $case_data[$row][$column] = $data_value;
                            }else{
                                $first_data[$column]=$data_value;
                            }
                        }
                        $update=false;
                        $unimportCase=[];
                        $importCase=0;
                        if($this->input->post('occupationtype')=='Business'){
                            if(count($first_data)==20){
                                if(!empty($case_data)){
                                    foreach($case_data as $case){
                                        if(!empty($case['B'])){
                                            $email=$this->common_model->GetRow(TBL_USERS,['email'=>trim($case['C']),'status'=>null],'user_id');
                                            if($email){
                                                $unimportCase[]=$case['C'].' already exists';
                                            }else{
                                                $mobile_number=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>trim($case['B'])]);
                                                if($mobile_number){
                                                    $unimportCase[]=$case['B'].' already exists';
                                                }else{
                                                    $update=true;
                                                    $importCase+=1;
                                                    $setdata=[];
                                                    $lastsubfileid=1;
                                                    $lastMerchant=$this->common_model->GetOrderByRow(TBL_USERS,['user_id','DESC'],['user_type'=>'MERCHANT']);
                                                    if($lastMerchant){
                                                        $lastsubfileid = $lastMerchant->sub_id+1;
                                                    }
                                                    $setdata['sub_id']=$lastsubfileid;
                                                    $setdata['file_id']='FTM'.sprintf('%07u', $lastsubfileid);
                                                    
                                                    $setdata['user_type']='MERCHANT';
                                                    $setdata['status']='INCOMPLETE';
                                                    $setdata['full_name']=$case['A'];
                                                    $setdata['mobile_number']=$case['B'];
                                                    $setdata['email']=$case['C'];
                                                    $password=substr(str_replace(' ','',$setdata['full_name']),0,4).preg_replace('~[+\d-](?=[\d-]{4})~', '',$case['B']);
                                                    $setdata['password']=password_hash($password,PASSWORD_DEFAULT);
                                                    if(!empty($case['D'])){
                                                        $setdata['company_name']=$case['D'];
                                                    }
                                                    if(!empty($case['E'])){
                                                        $setdata['age']=$case['E'];
                                                    }
                                                    $setdata['loan_type']='Business';
                                                    $setdata['created_by']=$this->session->userdata('user_id');
                                                    $setdata['created_at']=date('Y-m-d H:i:s');
                                                    $setdata['updated_at']=date('Y-m-d H:i:s');
                                                    if($insertId=$this->common_model->InsertData(TBL_USERS,$setdata)){
                                                        $setdata1=[];
                                                        $setdata1['user_id']=$insertId;
                                                        if(!empty($case['F'])){
                                                            $setdata1['loan_type1']=$case['F'];
                                                        }
                                                        if(!empty($case['G'])){
                                                            $setdata1['houseno']=$case['G'];
                                                        }
                                                        if(!empty($case['H'])){
                                                            $setdata1['city']=$case['H'];
                                                        }
                                                        if(!empty($case['I'])){
                                                            $setdata1['pincode']=$case['I'];
                                                        }
                                                        if(!empty($case['J'])){
                                                            $setdata1['state']=$case['J'];
                                                        }
                                                        if(!empty($case['K'])){
                                                            $setdata1['vintage']=$case['K'];
                                                        }
                                                        if(!empty($case['L'])){
                                                            $setdata1['turn_over']=$case['L'];
                                                        }
                                                        if(!empty($case['M'])){
                                                            $setdata1['nature_of_business']=$case['M'];
                                                        }
                                                        if(!empty($case['N'])){
                                                            $setdata1['type_of_nature']=$case['N'];
                                                        }
                                                        if(!empty($case['O'])){
                                                            $setdata1['desired_amount']=$case['O'];
                                                        }
                                                        if(!empty($case['P'])){
                                                            $setdata1['reference']=$case['P'];
                                                        }
                                                        if(!empty($case['Q'])){
                                                            $setdata1['reference_number']=$case['Q'];
                                                        }
                                                        if(!empty($case['R'])){
                                                            $setdata1['pan_number']=$case['R'];
                                                        }
                                                        if(!empty($case['S'])){
                                                            $setdata1['business_address']=$case['S'];
                                                        }
                                                        if(!empty($case['T'])){
                                                            $setdata1['resident_address']=$case['T'];
                                                        }
                                                        $this->common_model->InsertData(TBL_USER_DETAIL,$setdata1);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    $this->data['import_case']=$importCase;
                                    $this->data['unimport_case']=$unimportCase;
                                    if($update==false){
                                        $this->data['message_error']='Something Went Wrong!';
                                    }
                                }else{
                                $this->data['message_error']='Excel Is Empty';
                                }
                            }else{
                                $this->data['message_error']='Invalid Parameter passed in excel.';
                            }
                        }else{
                            if(count($first_data)==35){
                                if(!empty($case_data)){
                                    foreach($case_data as $case){
                                        if(!empty($case['B'])){
                                            $email=$this->common_model->GetRow(TBL_USERS,['email'=>trim($case['C']),'status'=>null],'user_id');
                                            if($email){
                                                $unimportCase[]=$case['C'].' already exists';
                                            }else{
                                                $mobile_number=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>trim($case['B'])]);
                                                if($mobile_number){
                                                    $unimportCase[]=$case['B'].' already exists';
                                                }else{
                                                    $update=true;
                                                    $importCase+=1;
                                                    $setdata=[];
                                                    $lastsubfileid=1;
                                                    $lastMerchant=$this->common_model->GetOrderByRow(TBL_USERS,['user_id','DESC'],['user_type'=>'MERCHANT']);
                                                    if($lastMerchant){
                                                        $lastsubfileid = $lastMerchant->sub_id+1;
                                                    }
                                                    $setdata['sub_id']=$lastsubfileid;
                                                    $setdata['file_id']='FTM'.sprintf('%07u', $lastsubfileid);
                                                    
                                                    $setdata['user_type']='MERCHANT';
                                                    $setdata['status']='INCOMPLETE';
                                                    $setdata['full_name']=$case['A'];
                                                    $setdata['mobile_number']=$case['B'];
                                                    $setdata['email']=$case['C'];
                                                    $password=substr(str_replace(' ','',$setdata['full_name']),0,4).preg_replace('~[+\d-](?=[\d-]{4})~', '',$case['B']);
                                                    $setdata['password']=password_hash($password,PASSWORD_DEFAULT);
                                                    if(!empty($case['D'])){
                                                        $setdata['age']=$case['D'];
                                                    }
                                                    $setdata['loan_type']='Salaried';
                                                    $setdata['created_by']=$this->session->userdata('user_id');
                                                    $setdata['created_at']=date('Y-m-d H:i:s');
                                                    $setdata['updated_at']=date('Y-m-d H:i:s');
                                                    if($insertId=$this->common_model->InsertData(TBL_USERS,$setdata)){
                                                        $setdata1=[];
                                                        $setdata1['user_id']=$insertId;
                                                        if(!empty($case['E'])){
                                                            $setdata1['father_name']=$case['E'];
                                                        }
                                                        if(!empty($case['F'])){
                                                            $setdata1['date_of_birth']=$case['F'];
                                                        }
                                                        if(!empty($case['G'])){
                                                            $setdata1['gender']=$case['G'];
                                                        }
                                                        if(!empty($case['H'])){
                                                            $setdata1['qualification']=$case['H'];
                                                        }
                                                        if(!empty($case['I'])){
                                                            $setdata1['marital_status']=$case['I'];
                                                        }
                                                        if(!empty($case['J'])){
                                                            $setdata1['number_of_kids']=$case['J'];
                                                        }
                                                        if(!empty($case['K'])){
                                                            $setdata1['vehicle_type']=$case['K'];
                                                        }
                                                        if(!empty($case['L'])){
                                                            $setdata1['employer_name']=$case['L'];
                                                        }
                                                        if(!empty($case['M'])){
                                                            $setdata1['designation']=$case['M'];
                                                        }
                                                        if(!empty($case['N'])){
                                                            $setdata1['organization']=$case['N'];
                                                        }
                                                        if(!empty($case['O'])){
                                                            $setdata1['organization_type']=$case['O'];
                                                        }
                                                        if(!empty($case['P'])){
                                                            $setdata1['total_experience']=$case['P'];
                                                        }
                                                        if(!empty($case['Q'])){
                                                            $setdata1['company_building']=$case['Q'];
                                                        }
                                                        if(!empty($case['R'])){
                                                            $setdata1['company_area']=$case['R'];
                                                        }
                                                        if(!empty($case['S'])){
                                                            $setdata1['company_pincode']=$case['S'];
                                                        }
                                                        if(!empty($case['T'])){
                                                            $setdata1['company_state']=$case['T'];
                                                        }
                                                        if(!empty($case['U'])){
                                                            $setdata1['company_city']=$case['U'];
                                                        }
                                                        if(!empty($case['V'])){
                                                            $setdata1['company_email']=$case['V'];
                                                        }
                                                        if(!empty($case['W'])){
                                                            $setdata1['company_website']=$case['W'];
                                                        }
                                                        if(!empty($case['X'])){
                                                            $setdata1['salery_inhand']=$case['X'];
                                                        }
                                                        if(!empty($case['Y'])){
                                                            $setdata1['salary_mode']=$case['Y'];
                                                        }
                                                        if(!empty($case['Z'])){
                                                            $setdata1['residence_building']=$case['Z'];
                                                        }
                                                        if(!empty($case['AA'])){
                                                            $setdata1['residence_area']=$case['AA'];
                                                        }
                                                        if(!empty($case['AB'])){
                                                            $setdata1['residence_pincode']=$case['AB'];
                                                        }
                                                        if(!empty($case['AC'])){
                                                            $setdata1['residence_state']=$case['AC'];
                                                        }
                                                        if(!empty($case['AD'])){
                                                            $setdata1['residence_city']=$case['AD'];
                                                        }
                                                        if(!empty($case['AE'])){
                                                            $setdata1['year_at_residence']=$case['AE'];
                                                        }
                                                        if(!empty($case['AF'])){
                                                            $setdata1['reference']=$case['AF'];
                                                        }
                                                        if(!empty($case['AG'])){
                                                            $setdata1['reference_number']=$case['AG'];
                                                        }
                                                        if(!empty($case['AH'])){
                                                            $setdata1['pan_number']=$case['AH'];
                                                        }
                                                        if(!empty($case['AI'])){
                                                            $setdata1['aadhar_number']=$case['AI'];
                                                        }
                                                        $this->common_model->InsertData('user_detail',$setdata1);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    $this->data['import_case']=$importCase;
                                    $this->data['unimport_case']=$unimportCase;
                                    if($update==false){
                                        $this->data['message_error']='Something Went Wrong!';
                                    }
                                    $this->session->set_flashdata('message','Excel Uploaded Successfully');
                                    $this->session->set_flashdata('message_type','success');
                                }else{
                                    $this->data['message_error']='Excel Is Empty';
                                }
                            }else{
                                $this->data['message_error']='Invalid Parameter passed in excel.';
                            }
                        }					
                    } else {
                        $this->data['message_error']='Only xlsx,csv file allowed';
                    }
                }else{
                    $this->data['message_error']='Invalid file selected.';
                }
			}else{
				$this->data['message_error']='The excel file is required';
            }
            
        }
        $this->data['content'] ='excel/case/add';
        $this->data['script'] ='excel/case/add_script';
        $this->load->view('dsa',$this->data);
    }
}