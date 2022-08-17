<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->output->delete_cache();
        $this->load->helper('admin');
        isAdminLogin();
        $this->load->model('super-admin/excel_model');
    }
    public function upload() {
        $case_data = [];
		if ($this->input->server('REQUEST_METHOD') == "POST") {
			$this->load->library('PHPExcel');
			if (!empty($_FILES['csvexcel']['name'])) {
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
						}
                    }
                    $update=false;
                    if($this->input->post('occupationtype')=='Business'){
                        if(!empty($case_data)){
                            foreach($case_data as $case){
                                if(!empty($case['A'])){
                                    $record=$this->common_model->GetRow(TBL_USERS,['file_id'=>trim($case['A']),'loan_type'=>'Business','user_type'=>'MERCHANT']);
                                    if($record){
                                        $userdata=[];
                                        if(!empty($case['B']))
                                            $userdata['full_name']=trim($case['B']);
                                        if(!empty($case['C']))
                                            $userdata['company_name']=trim($case['C']);
                                        if(!empty($case['D']))
                                            $userdata['age']=trim($case['D']);
                                        
                                        if(!empty($userdata)){
                                            $update=true;
                                            $userdata['updated_at']=date('Y-m-d H:i:s');
                                            $this->common_model->UpdateData(TBL_USERS,$userdata,['user_id'=>$record->user_id]);
                                        }

                                        $setdata=[];
                                        if(!empty($case['E']))
                                            $setdata['loan_type1']=trim($case['E']);
                                        if(!empty($case['F']))
                                            $setdata['houseno']=trim($case['F']);
                                        if(!empty($case['G']))
                                            $setdata['city']=trim($case['G']);
                                        if(!empty($case['H']))
                                            $setdata['state']=trim($case['H']);
                                        if(!empty($case['I']))
                                            $setdata['pincode']=trim($case['I']);
                                        if(!empty($case['J']))
                                            $setdata['vintage']=trim($case['J']);
                                        if(!empty($case['K']))
                                            $setdata['turn_over']=trim($case['K']);
                                        if(!empty($case['L']))
                                            $setdata['nature_of_business']=trim($case['L']);
                                        if(!empty($case['M']))
                                            $setdata['type_of_nature']=trim($case['M']);
                                        if(!empty($case['N']))
                                            $setdata['desired_amount']=trim($case['N']);
                                        if(!empty($case['O']))
                                            $setdata['reference']=trim($case['O']);
                                        if(!empty($case['P']))
                                            $setdata['reference_number']=trim($case['P']);
                                        if(!empty($case['Q']))
                                            $setdata['pan_number']=trim($case['Q']);
                                        if(!empty($case['R']))
                                            $setdata['business_address']=trim($case['R']);
                                        if(!empty($case['S']))
                                            $setdata['resident_address']=trim($case['S']);
                                        
                                        if(!empty($setdata)){
                                            $update=true;
                                            $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$record->user_id]);
                                            $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata,['user_id'=>$record->user_id]);
                                        }
                                    }
                                }
                            }
                            if($update){
                                $this->session->set_flashdata('message','Excel Uploaded Successfully');
                                $this->session->set_flashdata('message_type','success');
                                redirect_admin('merchant');
                            }else{
                                $this->session->set_flashdata('message','Unable to read file');
                                $this->session->set_flashdata('message_type','danger');
                                redirect_admin('excel/upload');
                            }
                        }else{
                           $this->data['message_error']='Excel Is Empty';
                        }
                    }else{
                        if(!empty($case_data)){
                            foreach($case_data as $case){
                                if(!empty($case['A'])){
                                    $record=$this->common_model->GetRow(TBL_USERS,['file_id'=>$case['A'],'loan_type'=>'Salaried','user_type'=>'MERCHANT']);
                                    if($record){
                                        $userdata=[];
                                        if(!empty($case['B']))
                                            $userdata['full_name']=$case['B'];
                                        if(!empty($case['D']))
                                            $userdata['age']=$case['D'];
                                        
                                        if(!empty($userdata)){
                                            $update=true;
                                            $userdata['updated_at']=date('Y-m-d H:i:s');
                                            $this->common_model->UpdateData(TBL_USERS,$userdata,['user_id'=>$record->user_id,'user_type'=>'MERCHANT']);
                                        }

                                        $setdata=[];
                                        if(!empty($case['C']))
                                            $setdata['father_name']=$case['C'];
                                        if(!empty($case['E']))
                                            $setdata['date_of_birth']=$case['E'];
                                        if(!empty($case['F']))
                                            $setdata['gender']=$case['F'];
                                        if(!empty($case['G']))
                                            $setdata['qualification']=$case['G'];
                                        if(!empty($case['H']))
                                            $setdata['marital_status']=$case['H'];
                                        if(!empty($case['I']))
                                            $setdata['number_of_kids']=$case['I'];
                                        if(!empty($case['J']))
                                            $setdata['vehicle_type']=$case['J'];
                                        if(!empty($case['K']))
                                            $setdata['employer_name']=$case['K'];
                                        if(!empty($case['L']))
                                            $setdata['designation']=$case['L'];
                                        if(!empty($case['M']))
                                            $setdata['organization']=$case['M'];
                                        if(!empty($case['N']))
                                            $setdata['organization_type']=$case['N'];
                                        if(!empty($case['O']))
                                            $setdata['total_experience']=$case['O'];
                                        if(!empty($case['P']))
                                            $setdata['company_building']=$case['P'];
                                        if(!empty($case['Q']))
                                            $setdata['company_area']=$case['Q'];
                                        if(!empty($case['R']))
                                            $setdata['company_pincode']=$case['R'];
                                        if(!empty($case['S']))
                                            $setdata['comapny_city']=$case['S'];
                                        if(!empty($case['T']))
                                            $setdata['company_state']=$case['T'];
                                        if(!empty($case['U']))
                                            $setdata['company_email']=$case['U'];
                                        if(!empty($case['V']))
                                            $setdata['company_website']=$case['V'];
                                        if(!empty($case['W']))
                                            $setdata['salery_inhand']=$case['W'];
                                        if(!empty($case['X']))
                                            $setdata['salary_mode']=$case['X'];
                                        if(!empty($case['Y']))
                                            $setdata['residence_building']=$case['Y'];
                                        if(!empty($case['Z']))
                                            $setdata['residence_area']=$case['Z'];
                                        if(!empty($case['Z']))
                                            $setdata['residence_pincode']=$case['Z'];
                                        if(!empty($case['AA']))
                                            $setdata['residence_pincode']=$case['AA'];
                                        if(!empty($case['AA']))
                                            $setdata['residence_pincode']=$case['AA'];
                                        if(!empty($case['AA']))
                                            $setdata['residence_pincode']=$case['AA'];
                                        if(!empty($case['AB']))
                                            $setdata['residence_state']=$case['AB'];
                                        if(!empty($case['AC']))
                                            $setdata['residence_city']=$case['AC'];
                                        if(!empty($case['AD']))
                                            $setdata['residence_type']=$case['AD'];
                                        if(!empty($case['AE']))
                                            $setdata['year_at_residence']=$case['AE'];
                                        if(!empty($case['AF']))
                                            $setdata['reference']=$case['AF'];
                                        if(!empty($case['AG']))
                                            $setdata['reference_number']=$case['AG'];
                                        if(!empty($case['AH']))
                                            $setdata['pan_number']=$case['AH'];
                                        if(!empty($case['AI']))
                                            $setdata['aadhar_number']=$case['AI'];
                                        
                                        if(!empty($setdata)){
                                            $update=true;
                                            $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$record->user_id]);
                                            $this->common_model->UpdateData('user_detail',$setdata,['user_id'=>$record->user_id]);
                                        }
                                    }
                                }

                            }
                            if($update){
                                $this->session->set_flashdata('message','Excel Uploaded Successfully');
                                $this->session->set_flashdata('message_type','success');
                                redirect_admin('merchant');
                            }else{
                                $this->session->set_flashdata('message','Unable to read file');
                                $this->session->set_flashdata('message_type','danger');
                                redirect_admin('excel/upload');
                            }
                        }else{
                            $this->data['message_error']='Excel Is Empty';
                        }
                    }					
				} else {
                    $this->data['message_error']='Only xlsx,csv file allowed';
				}
			} else {
				$this->data['message_error']='The excel file is required';
            }
            
        }
        $this->data['content'] ='excel/case/update';
        $this->data['script'] ='excel/case/update_script';
        $this->load->view('super-admin',$this->data);
    }
    public function add(){
        $case_data = [];
        $first_data = [];
		if ($this->input->server('REQUEST_METHOD') == "POST") {
			$this->load->library('PHPExcel');
			if (!empty($_FILES['csvexcel']['name'])) {
                $isupload=true;
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
                                                    if($this->input->post('partner_id')){
                                                        $setdata['created_by']=$this->input->post('partner_id');
                                                    }else{
                                                        $setdata['created_by']=$this->session->userdata('user_id');
                                                    }
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
                                    if($update==false){
                                        $this->data['message_error']='Something Went Wrong!';
                                    }
                                    $this->data['import_case']=$importCase;
                                    $this->data['unimport_case']=$unimportCase;
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
                                                    $update =true;
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
                                                    if(!empty($case['D'])){
                                                        $setdata['age']=$case['D'];
                                                    }
                                                    $password=substr(str_replace(' ','',$setdata['full_name']),0,4).preg_replace('~[+\d-](?=[\d-]{4})~', '',$case['B']);
                                                    $setdata['password']=password_hash($password,PASSWORD_DEFAULT);
                                                    $setdata['loan_type']='Salaried';
                                                    if($this->input->post('partner_id')){
                                                        $setdata['created_by']=$this->input->post('partner_id');
                                                    }else{
                                                        $setdata['created_by']=$this->session->userdata('user_id');
                                                    }
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
        $this->data['dsalist']=$this->common_model->GetResult(TBL_USERS,['user_type'=>'DSA']);
        $this->data['content'] ='excel/case/add';
        $this->data['script'] ='excel/case/add_script';
        $this->load->view('super-admin',$this->data);
    }
    public function download_report(){
        $partnerpermission= PartnerPermission();
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $filter_type=$this->input->post('filter_type');
        $rangepicker=$this->input->post('rangepicker');
        $status=$this->input->post('status');
        $dsa_id=$this->input->post('dsa_id');
        $lender_id=$this->input->post('lender_id');
        $data = $this->excel_model->MerchantList($filter_type,$rangepicker,$status,$dsa_id,$lender_id,$partnerpermission);
        $fieldstatus='';
        if($status=='all' || $status=='incomlplete'){
            $fieldstatus='Created';
        }else{
            $fieldstatus=ucfirst($status);
        }
        if($this->input->post('filter_type')=='Business'){
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

            $objPHPExcel->getActiveSheet()->SetCellValue('AF' . 1, 'Partner Detail');
            $objPHPExcel->getActiveSheet()->SetCellValue('AG' . 1, 'Created Time');
            $objPHPExcel->getActiveSheet()->SetCellValue('AH' . 1, 'Last Remark');
            $objPHPExcel->getActiveSheet()->SetCellValue('AI' . 1, 'Last Remark Time');
            $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . 1, 'Last Comment');
            $objPHPExcel->getActiveSheet()->SetCellValue('AK' . 1, 'Last Comment Time');
            $objPHPExcel->getActiveSheet()->SetCellValue('AL' . 1, 'Current Status Time');
            $objPHPExcel->getActiveSheet()->SetCellValue('AM' . 1, $fieldstatus.' At');
            $objPHPExcel->getActiveSheet()->SetCellValue('AN' . 1, 'Bank Statuement');
            $objPHPExcel->getActiveSheet()->SetCellValue('AN' . 1, 'Date Of Birth');
            $objPHPExcel->getActiveSheet()->SetCellValue('AO' . 1, 'Lender Detail');
            
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
                if(!empty($row->created_by)){
                    $partnerrecord=$this->common_model->GetRow(TBL_USERS,['user_id'=>$row->created_by]);
                    if(!empty($partnerrecord)){
                        $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rscount, $partnerrecord->file_id);
                    }
                }
                $created_at=date('d M Y h:i A',strtotime($row->created_at));
                $objPHPExcel->getActiveSheet()->SetCellValue('AG' .$rowCount,$created_at);
                $remark = $this->common_model->GetOrderByRow('remark',['remark_id','DESC'],['merchant_id'=>$row->user_id]);
                if(!empty($remark)){
                    $objPHPExcel->getActiveSheet()->SetCellValue('AH' .$rowCount,$remark->comments);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AI' .$rowCount,$remark->created_at);
                }
                $comments = $this->common_model->GetOrderByRow('comments',['comment_id','DESC'],['merchant_id'=>$row->user_id]);
                if(!empty($comments)){
                    $objPHPExcel->getActiveSheet()->SetCellValue('AJ' .$rowCount,$comments->comment);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AK' .$rowCount,$comments->created_at);
                }

                $currentstatus=strtolower($currentstatus);
                if($currentstatus=='incomplete')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->created_at);
                elseif($currentstatus=='received')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->received_time);
                elseif($currentstatus=='shortclose')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->short_close_time);
                elseif($currentstatus=='assigned')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->assigned_time);
                elseif($currentstatus=='logged')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->logged_time);
                elseif($currentstatus=='pending')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->pending_time);
                elseif($currentstatus=='approved')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->approved_time);
                elseif($currentstatus=='rejected')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->reject_time);
                elseif($currentstatus=='disbursed')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->disbursed_time);
                    
                if($this->input->post('status')){
                    if($status=='incomplete' || $status=='all')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AM' .$rowCount,$row->created_at);
                    elseif($status=='received')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AM' .$rowCount,$row->received_time);
                    elseif($status=='short_close')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AM' .$rowCount,$row->short_close_time);
                    elseif($status=='assigned')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AM' .$rowCount,$row->assigned_time);
                    elseif($status=='logged')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AM' .$rowCount,$row->logged_time);
                    elseif($status=='pending')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AM' .$rowCount,$row->pending_time);
                    elseif($status=='approved')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AM' .$rowCount,$row->approved_time);
                    elseif($status=='rejected')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AM' .$rowCount,$row->reject_time);
                    elseif($status=='disbursed')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AM' .$rowCount,$row->disbursed_time);
                }
                $objPHPExcel->getActiveSheet()->SetCellValue('AN' .$rowCount,$row->bankstatement_password);
                $objPHPExcel->getActiveSheet()->SetCellValue('AO' .$rowCount,$row->date_of_birth);
                $objPHPExcel->getActiveSheet()->SetCellValue('AP' .$rowCount,$row->lender_file_id.' - '.$row->lender_companyname);

                if($arowcount>$newrowcount){
                    $rowCount=($arowcount-1);
                }elseif($newrowcount>$rowCount){
                    $rowCount=($newrowcount-1);
                }
                $rowCount++;
            }
            
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;Filename=Download.xls");
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }else{
            
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
            $objPHPExcel->getActiveSheet()->SetCellValue('AM' . 1, 'Partner File Id');
            $objPHPExcel->getActiveSheet()->SetCellValue('AN' . 1, 'Created Time');
            $objPHPExcel->getActiveSheet()->SetCellValue('AO' . 1, 'Remark');
            $objPHPExcel->getActiveSheet()->SetCellValue('AP' . 1, 'Remark Time');
            $objPHPExcel->getActiveSheet()->SetCellValue('AQ' . 1, 'Last Comment');
            $objPHPExcel->getActiveSheet()->SetCellValue('AR' . 1, 'Last Comment Time');
            $objPHPExcel->getActiveSheet()->SetCellValue('AS' . 1, 'Current Status Time');
            $objPHPExcel->getActiveSheet()->SetCellValue('AT' . 1, $fieldstatus.' At');
            $objPHPExcel->getActiveSheet()->SetCellValue('AU' . 1, 'Lender Detail');

            $rowCount = 2;
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
                
                if(!empty($row->created_by)){
                    $partnerrecord=$this->common_model->GetRow(TBL_USERS,['user_id'=>$row->created_by]);
                    if(!empty($partnerrecord)){
                        $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $rowCount, $partnerrecord->file_id);
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
                $currentstatus=strtolower($currentstatus);
                if($currentstatus=='incomplete')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->created_at);
                elseif($currentstatus=='received')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->received_time);
                elseif($currentstatus=='shortclose')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->short_close_time);
                elseif($currentstatus=='assigned')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->assigned_time);
                elseif($currentstatus=='logged')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->logged_time);
                elseif($currentstatus=='pending')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->pending_time);
                elseif($currentstatus=='approved')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->approved_time);
                elseif($currentstatus=='rejected')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->reject_time);
                elseif($currentstatus=='disbursed')
                    $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->disbursed_time);
                    
                if($this->input->post('status')){
                    if($status=='incomplete' || $status=='all')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AT' .$rowCount,$row->created_at);
                    elseif($status=='received')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AT' .$rowCount,$row->received_time);
                    elseif($status=='short_close')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AT' .$rowCount,$row->short_close_time);
                    elseif($status=='assigned')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AT' .$rowCount,$row->assigned_time);
                    elseif($status=='logged')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AT' .$rowCount,$row->logged_time);
                    elseif($status=='pending')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AT' .$rowCount,$row->pending_time);
                    elseif($status=='approved')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AT' .$rowCount,$row->approved_time);
                    elseif($status=='rejected')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AT' .$rowCount,$row->reject_time);
                    elseif($status=='disbursed')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AT' .$rowCount,$row->disbursed_time);
                }
                $objPHPExcel->getActiveSheet()->SetCellValue('AU' .$rowCount,$row->lender_file_id.' - '.$row->lender_companyname);
                $rowCount++;
            }
            
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;Filename=Download.xls");
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');   
        }
    }
    public function download_disbursed(){
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $data = $this->excel_model->DisbursedCase();
        $objPHPExcel->getProperties()->setCreator("Support");
        $objPHPExcel->getProperties()->setTitle('Loan Applicant');
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . 1, 'Partner Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . 1, 'Lender Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . 1, 'FTM ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . 1, 'Merchant Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . 1, 'City');
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . 1, 'Mobile Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . 1, 'Disbursed Amount');   
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . 1, 'Disbursed Date');   
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . 1, 'Disbursed Month');   
        $rowCount = 2;
        foreach ($data as $row)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' .$rowCount,$row->dsa_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' .$rowCount,$row->lender_companyname);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->file_id);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->full_name);
            if($row->loan_type=='Business'){
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->city);
            }else{
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->residence_city);
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $row->mobile_number);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $row->disbursed_amount);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, date('d-m-Y',strtotime($row->disbursed_time)));
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, date('F',strtotime($row->disbursed_time)));
            $rowCount++;
        
        }
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;Filename=Disbursed-Case-Report.xls");
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');   
    }
}