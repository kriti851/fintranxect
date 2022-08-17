<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merchant extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
        $this->load->model(['super-admin/merchant_model']);
        $this->load->helper('admin');
        isAdminLogin();
    }
    /* private function SubP($type){
        if($type!=""){
            if($type=="incomplete"){
                if(!SubPermission(2)){
                    $this->session->set_flashdata('message','Permission denied.');
                    $this->session->set_flashdata('message_type','error');
                    redirect_admin('dashboard');
                }
            }elseif($type=="short_close"){
                if(!SubPermission(3)){
                    $this->session->set_flashdata('message','Permission denied.');
                    $this->session->set_flashdata('message_type','error');
                    redirect_admin('dashboard');
                }
            }elseif($type=="received"){
                if(!SubPermission(4)){
                    $this->session->set_flashdata('message','Permission denied.');
                    $this->session->set_flashdata('message_type','error');
                    redirect_admin('dashboard');
                }
            }elseif($type=="assigned"){
                if(!SubPermission(5)){
                    $this->session->set_flashdata('message','Permission denied.');
                    $this->session->set_flashdata('message_type','error');
                    redirect_admin('dashboard');
                }
            }elseif($type=="logged"){
                if(!SubPermission(6)){
                    $this->session->set_flashdata('message','Permission denied.');
                    $this->session->set_flashdata('message_type','error');
                    redirect_admin('dashboard');
                }
            }elseif($type=="pending"){
                if(!SubPermission(7)){
                    $this->session->set_flashdata('message','Permission denied.');
                    $this->session->set_flashdata('message_type','error');
                    redirect_admin('dashboard');
                }
            }elseif($type=="approved"){
                if(!SubPermission(8)){
                    $this->session->set_flashdata('message','Permission denied.');
                    $this->session->set_flashdata('message_type','error');
                    redirect_admin('dashboard');
                }
            }elseif($type=="rejected"){
                if(!SubPermission(9)){
                    $this->session->set_flashdata('message','Permission denied.');
                    $this->session->set_flashdata('message_type','error');
                    redirect_admin('dashboard');
                }
            }elseif($type=="disbursed"){
                if(!SubPermission(10)){
                    $this->session->set_flashdata('message','Permission denied.');
                    $this->session->set_flashdata('message_type','error');
                    redirect_admin('dashboard');
                }
            }else{
                $this->session->set_flashdata('message','Permission denied.');
                $this->session->set_flashdata('message_type','error');
                redirect_admin('dashboard');
            }
        }else{
            if(!SubPermission(1)){
                $this->session->set_flashdata('message','Permission denied.');
                $this->session->set_flashdata('message_type','error');
                redirect_admin('dashboard');
            }
        }
        return true;
    } */
    public function index(){
        $partnerpermission= PartnerPermission();
        if(!MainPermission(4)){
			redirect_admin('dashboard');
        }
        $type=$this->input->get('type');
        //$this->SubP($type);
        $per_page=10;
        $search=$keyword="";
		if($this->input->get('per_page')){
			$per_page=$this->input->get('per_page');
		}
        
        $keyword=trim($this->input->get('keyword'));
        $date_range=$this->input->get('date_range');
        $loan_type=$this->input->get('loan_type');
        $order_by=$this->input->get('order_by');
        $record_type=$this->input->get('record_type');
        $remark=$this->input->get('remark');
        $incomplete_status=$this->input->get('title');
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
            if(!empty($incomplete_status)){
                $search.='&incomplete_status='.$incomplete_status;
            }
        }
		$dsaid="";
        $config=GetPagination($per_page);
		$config['base_url'] = admin_url("merchant".$search);	
		$config['total_rows'] = $this->merchant_model->CountMerchantList($keyword,$type,$date_range,$loan_type,$dsaid,$record_type,$remark,$incomplete_status);
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
		$this->data['results']=$this->merchant_model->MerchantList($config['per_page'],$page,$keyword,$type,$date_range,$loan_type,$dsaid,$order_by,$record_type,$remark,$incomplete_status);
       /*  echo '<pre>';
        print_r($this->data['results']);die; */
        $this->data['dsa']=$this->common_model->GetWhereWithIn(TBL_USERS,['user_type'=>'DSA'],'user_id',$partnerpermission,'user_id,full_name,company_name');
        $this->data['lenderlist']=$this->common_model->GetResult(TBL_USERS,['user_type'=>'LENDERS']);
        $this->data['is_download']=true;
        $this->data['is_uplod']=true;
        $this->data['is_add']=true;
        $this->data['case_report']=true;
        $this->data['content']="merchant/index";
        $this->data['script']="merchant/script";
        $this->load->view('super-admin',$this->data);
    }
    public function ExportCasesByFilter(){
        $partnerpermission= PartnerPermission();
        if($this->input->server("REQUEST_METHOD")=='POST'){
            $this->load->library('PHPExcel');
            $this->load->library('zip');
            if(in_array('Business',$this->input->post('filter_type'))){
                $data=$this->merchant_model->GetExportFilter($this->input->post(),$partnerpermission);
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

                $objPHPExcel->getActiveSheet()->SetCellValue('AF' . 1, 'Partner Detail');
                $objPHPExcel->getActiveSheet()->SetCellValue('AG' . 1, 'Created Time');
                $objPHPExcel->getActiveSheet()->SetCellValue('AH' . 1, 'Last Remark');
                $objPHPExcel->getActiveSheet()->SetCellValue('AI' . 1, 'Last Remark Time');
                $objPHPExcel->getActiveSheet()->SetCellValue('AJ' . 1, 'Last Comment');
                $objPHPExcel->getActiveSheet()->SetCellValue('AK' . 1, 'Last Comment Time');
                $objPHPExcel->getActiveSheet()->SetCellValue('AL' . 1, 'Current Status Time');
                $objPHPExcel->getActiveSheet()->SetCellValue('AM' . 1, 'Bankstatement Password');
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
                   
                    $objPHPExcel->getActiveSheet()->SetCellValue('AF' . $rscount, $row->dsa_id.' - '.$row->dsa_name);
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
                    if($currentstatus=='INCOMPLETE')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->created_at);
                    elseif($currentstatus=='RECEIVED')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->received_time);
                    elseif($currentstatus=='SHORTCLOSE')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->short_close_time);
                    elseif($currentstatus=='ASSIGNED')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->assigned_time);
                    elseif($currentstatus=='LOGGED')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->logged_time);
                    elseif($currentstatus=='PENDING')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->pending_time);
                    elseif($currentstatus=='APPROVED')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->approved_time);
                    elseif($currentstatus=='REJECTED')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->reject_time);
                    elseif($currentstatus=='DISBURSED')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->disbursed_time);

                    $objPHPExcel->getActiveSheet()->SetCellValue('AM' .$rowCount,$row->bankstatement_password);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AN' .$rowCount,$row->date_of_birth);
                    $objPHPExcel->getActiveSheet()->SetCellValue('AO' .$rowCount,$row->lender_file_id.' - '.$row->lender_companyname);
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
                $data=$this->merchant_model->GetExportFilter2($this->input->post(),$partnerpermission);
                
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
                $objPHPExcel->getActiveSheet()->SetCellValue('AM' . 1, 'Partner Detail');
                $objPHPExcel->getActiveSheet()->SetCellValue('AN' . 1, 'Created Time');
                $objPHPExcel->getActiveSheet()->SetCellValue('AO' . 1, 'Remark');
                $objPHPExcel->getActiveSheet()->SetCellValue('AP' . 1, 'Remark Time');
                $objPHPExcel->getActiveSheet()->SetCellValue('AQ' . 1, 'Last Comment');
                $objPHPExcel->getActiveSheet()->SetCellValue('AR' . 1, 'Last Comment Time');
                $objPHPExcel->getActiveSheet()->SetCellValue('AS' . 1, 'Current Status Time');
                $objPHPExcel->getActiveSheet()->SetCellValue('AT' . 1, 'Lender Detail');
                
    
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
                    
                   
                    $objPHPExcel->getActiveSheet()->SetCellValue('AM' . $rowCount, $row->dsa_id.' - '.$row->dsa_name);
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
                    elseif($currentstatus=='ASSIGNED')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->assigned_time);
                    elseif($currentstatus=='LOGGED')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->logged_time);
                    elseif($currentstatus=='PENDING')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->pending_time);
                    elseif($currentstatus=='APPROVED')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->approved_time);
                    elseif($currentstatus=='REJECTED')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->reject_time);
                    elseif($currentstatus=='DISBURSED')
                        $objPHPExcel->getActiveSheet()->SetCellValue('AS' .$rowCount,$row->disbursed_time);

                    $objPHPExcel->getActiveSheet()->SetCellValue('AT' .$rowCount,$row->lender_file_id.' - '.$row->lender_companyname);
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
    public function detail($userid){
        
        $this->common_model->UpdateData('comments',['admin_read'=>'1'],['merchant_id'=>$userid,'admin_read'=>0]);
        $user=$this->common_model->GetRow(TBL_USERS,['user_id'=>$userid]);
        if($user->loan_type=='Business'){
            $this->data['record'] = $this->merchant_model->GetUserDetail($userid);
            $this->data['checklist'] = $this->common_model->GetRow('check_form_business_type',['merchant_id'=>$userid]);
            $this->data['content']="merchant/detail";
        }else{
            $this->data['record'] = $this->merchant_model->GetUserDetail2($userid);
            $this->data['content']="merchant/detail2";
        }
        $this->data['comments']=$this->merchant_model->GetComments($userid);
        $this->data['remarks']=$this->common_model->GetResult('remark',['merchant_id'=>$userid]);
        $this->data['follow_up']=$this->common_model->GetOrderByResult('remark',['follow_up','ASC'],['merchant_id'=>$userid,'follow_up!='=>""]);
        $this->data['rejectedcase']=$this->common_model->GetResult('reject_case',['merchant_id'=>$userid]);
        $this->data['script']="merchant/detail_script";
        $this->load->view('super-admin',$this->data);
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
	public function DownloadApplicant($user_id=""){
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
        
        $objPHPExcel->getActiveSheet()->SetCellValue('AF' . 1, 'Partner Id');
        $objPHPExcel->getActiveSheet()->SetCellValue('AG' . 1, 'Created Time');
        $objPHPExcel->getActiveSheet()->SetCellValue('AH' . 1, 'Remark');
        $objPHPExcel->getActiveSheet()->SetCellValue('AI' . 1, 'Remark Time');
		$objPHPExcel->getActiveSheet()->SetCellValue('AJ' . 1, 'Last Comment');
        $objPHPExcel->getActiveSheet()->SetCellValue('AK' . 1, 'Last Comment Time');
        $objPHPExcel->getActiveSheet()->SetCellValue('AL' . 1, 'Current Status Time');
        $objPHPExcel->getActiveSheet()->SetCellValue('AM' . 1, 'Bankstatement Password');
        $objPHPExcel->getActiveSheet()->SetCellValue('AN' . 1, 'Date Of Birth');

		$rowCount = 2;
        //echo "<pre>";print_r($data);die;
        $this->load->library('zip');
		foreach ($data as $row)
		{
            $multifiles = [];
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row->file_id);
            $currentstatus='';
            
            $assign = $this->common_model->GetResult('user_lender_assign',['merchant_id'=>$row->user_id]);
            if(!empty($assign) && count($assign)>1){
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . 5, 'Lender Id');
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . 5, 'Lender Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . 5, 'Status');
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . 5, 'At');
                $rowcount2=6;
                foreach($assign as $as){
                    $lenderRecord = $this->common_model->GetRow(TBL_USERS,['user_id'=>$as->lender_id]);
                    if($lenderRecord){
                        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowcount2, $lenderRecord->file_id);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowcount2, $lenderRecord->company_name);
                        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowcount2, $as->status);
                        $time='';
                        if($as->status=='ASSIGNED'){
                            $time=$as->assigned_time;
                        }elseif($as->status=='LOGGED'){
                            $time=$as->logged_time;
                        }elseif($as->status=='PENDING'){
                            $time=$as->pending_time;
                        }elseif($as->status=='APPROVED'){
                            $time=$as->approved_time;
                        }elseif($as->status=='REJECTED'){
                            $time=$as->reject_time;
                        }elseif($as->status=='DISBURSED'){
                            $time=$as->disbursed_time;
                        }
                        if($time!=""){
                            $time=date('d M Y h:i A',strtotime($time));
                            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowcount2, $time);
                        }
                        $rowcount2++;
                    }
                    
                }
            }elseif(!empty($assign) && count($assign)==1){
                if($assign[0]->lender_id!=""){
                    $objPHPExcel->getActiveSheet()->SetCellValue('A' . 5, 'Lender Id');
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . 5, 'Lender Name');
                    $objPHPExcel->getActiveSheet()->SetCellValue('C' . 5, 'Status');
                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . 5, 'At');
                    $rowcount2=6;
                    foreach($assign as $as){
                        $lenderRecord = $this->common_model->GetRow(TBL_USERS,['user_id'=>$assign[0]->lender_id]);
                        if($lenderRecord){
                            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowcount2, $lenderRecord->file_id);
                            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowcount2, $lenderRecord->company_name);
                            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowcount2, $as->status);
                            $time ='';
                            if($as->status='ASSIGNED'){
                               $time=$as->assigned_time;
                            }elseif($as->status='LOGGED'){
                                $time=$as->logged_time;
                            }elseif($as->status='PENDING'){
                                $time=$as->pending_time;
                            }elseif($as->status='APPROVED'){
                                $time=$as->approved_time;
                            }elseif($as->status='REJECTED'){
                                $time=$as->reject_time;
                            }elseif($as->status='DISBURSED'){
                                $time=$as->disbursed_time;
                            }
                            if($time!=""){
                                $time=date('d M Y h:i A',strtotime($time));
                                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowcount2, $time);
                            }
                        }
                    }
                }else{
                    $currentstatus=$assign[0]->status;
                }
            }else{
                if($row->status=='INCOMPLETE'){
                    $currentstatus='INCOMPLETE';
                }else{
                    $currentstatus='RECEIVED';
                }
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
            if($currentstatus=='INCOMPLETE')
                $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->created_at);
            elseif($currentstatus=='RECEIVED')
                $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->received_time);
            elseif($currentstatus=='SHORTCLOSE')
                $objPHPExcel->getActiveSheet()->SetCellValue('AL' .$rowCount,$row->short_close_time);
            

            
            $objPHPExcel->getActiveSheet()->SetCellValue('AM' .$rowCount,$row->bankstatement_password);
            $objPHPExcel->getActiveSheet()->SetCellValue('AN' .$rowCount,$row->date_of_birth);
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
        $objPHPExcel->getActiveSheet()->SetCellValue('AM' . 1, 'File Id');
        $objPHPExcel->getActiveSheet()->SetCellValue('AN' . 1, 'Created Time');
        $objPHPExcel->getActiveSheet()->SetCellValue('AO' . 1, 'Remark Time');
        $objPHPExcel->getActiveSheet()->SetCellValue('AQ' . 1, 'Last Comment');
        $objPHPExcel->getActiveSheet()->SetCellValue('AR' . 1, 'Last Comment Time');
        $objPHPExcel->getActiveSheet()->SetCellValue('AS' . 1, 'Current Status Time');
        $objPHPExcel->getActiveSheet()->SetCellValue('AT' . 1, 'Bankstatement Password');

		$rowCount = 2;
        //echo "<pre>";print_r($data);die;
        $this->load->library('zip');
		foreach ($data as $row)
		{
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row->file_id);
            $currentstatus='';
            $assign = $this->common_model->GetResult('user_lender_assign',['merchant_id'=>$row->user_id]);
            if(!empty($assign) && count($assign)>1){
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . 5, 'Lender Id');
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . 5, 'Lender Name');
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . 5, 'Status');
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . 5, 'At');
                $rowcount2=6;
                foreach($assign as $as){
                    $lenderRecord = $this->common_model->GetRow(TBL_USERS,['user_id'=>$as->lender_id]);
                    if($lenderRecord){
                        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowcount2, $lenderRecord->file_id);
                        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowcount2, $lenderRecord->company_name);
                        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowcount2, $as->status);
                        $time='';
                        if($as->status=='ASSIGNED'){
                            $time=$as->assigned_time;
                        }elseif($as->status=='LOGGED'){
                            $time=$as->logged_time;
                        }elseif($as->status=='PENDING'){
                            $time=$as->pending_time;
                        }elseif($as->status=='APPROVED'){
                            $time=$as->approved_time;
                        }elseif($as->status=='REJECTED'){
                            $time=$as->reject_time;
                        }elseif($as->status=='DISBURSED'){
                            $time=$as->disbursed_time;
                        }
                        if($time!=""){
                            $time=date('d M Y h:i A',strtotime($time));
                            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowcount2, $time);
                        }
                        $rowcount2++;
                    }
                    
                }
            }elseif(!empty($assign) && count($assign)==1){
                if($assign[0]->lender_id!=""){
                    $objPHPExcel->getActiveSheet()->SetCellValue('A' . 5, 'Lender Id');
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . 5, 'Lender Name');
                    $objPHPExcel->getActiveSheet()->SetCellValue('C' . 5, 'Status');
                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . 5, 'At');
                    $rowcount2=6;
                    foreach($assign as $as){
                        $lenderRecord = $this->common_model->GetRow(TBL_USERS,['user_id'=>$assign->lender_id]);
                        if($lenderRecord){
                            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowcount2, $lenderRecord->file_id);
                            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowcount2, $lenderRecord->company_name);
                            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowcount2, $as->status);
                            $time='';
                            if($as->status='ASSIGNED'){
                                $time=$as->assigned_time;
                            }elseif($as->status='LOGGED'){
                                $time=$as->logged_time;
                            }elseif($as->status='PENDING'){
                                $time=$as->pending_time;
                            }elseif($as->status='APPROVED'){
                                $time=$as->approved_time;
                            }elseif($as->status='REJECTED'){
                                $time=$as->reject_time;
                            }elseif($as->status='DISBURSED'){
                                $time=$as->disbursed_time;
                            }
                            if($time!=""){
                                $time=date('d M Y h:i A',strtotime($time));
                                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowcount2, $time);
                            }
                        }
                    }
                }else{
                    $currentstatus=$assign[0]->status;
                }
            }else{
                if($row->status=='INCOMPLETE'){
                    $currentstatus='INCOMPLETE';
                }else{
                    $currentstatus='RECEIVED';
                }
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
	public function lender_assign($merchant_id){
		$this->data['content']="merchant/assign-lender";
		$this->data['script']="merchant/assign_script";
		$this->data['merchant_id']=$merchant_id;
        $this->data['results']=$this->merchant_model->GetLenderList($this->input->get('keyword'));
        $this->data['merchant_lender']=$this->common_model->GetResult('user_lender_assign',['merchant_id'=>$merchant_id,'lender_id!='=>'','status!='=>'REJECTED'],'lender_id');
        $this->load->view('super-admin',$this->data);
    }
    
	public function loggedLenderToMerchant(){
		if($this->input->server('REQUEST_METHOD')=='POST'){
			$merchant= $this->common_model->GetRow(TBL_USERS,['user_id'=>$this->input->post('merchant_id')]);
            if($this->input->post('logged_type')=='' || $this->input->post('logged_type')=='undefined'){
                $this->common_model->DeleteData(TBL_LENDER_ASSIGN,['merchant_id'=>$this->input->post('merchant_id')]);
            }
            $setdata=[];
            $setdata['status']='LOGGED';
            $setdata['logged_time']=date('Y-m-d H:i:s');
            $setdata['notification']='A loan request of '.$merchant->full_name.' has received';
			foreach($this->input->post('multi_lender_id') as $lenderid){
                $setdata['lender_id']=$lenderid;
                $record=$this->common_model->GetRow(TBL_LENDER_ASSIGN,['merchant_id'=>$merchant->user_id,'lender_id'=>$lenderid]);
                if($record){
                    $setdata['updated_at']=date('Y-m-d H:i:s');
                    $this->common_model->UpdateData(TBL_LENDER_ASSIGN,$setdata,['id'=>$record->id]);
                }else{
                    $setdata['merchant_id']=$merchant->user_id;
                    $setdata['dsa_id']=$merchant->created_by;
                    $setdata['created_at']=date('Y-m-d H:i:s');
                    $setdata['updated_at']=date('Y-m-d H:i:s');
                    $this->common_model->InsertData(TBL_LENDER_ASSIGN,$setdata);
                }
                $caselog=[];
                $caselog['merchant_id']=$merchant->user_id;
                $caselog['lender_id']=$lenderid;
                $caselog['change_by']=$this->session->userdata('full_name');
                $caselog['change_by_user_type']=$this->session->userdata('user_type');
                $caselog['log_text']='Logged Case';
                $caselog['log_type']='STATUS';
                $caselog['status']='LOGGED';
                $this->common_model->InsertData('case_log',$caselog);
            }
            if($this->input->post('logged_type')=='' || $this->input->post('logged_type')=='undefined'){
                $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s'),'total_assigned'=>count($this->input->post('multi_lender_id')),'total_reject'=>0],['user_id'=>$merchant->user_id]);
            }else{
                $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s'),'total_assigned'=>$merchant->total_assigned+count($this->input->post('multi_lender_id'))],['user_id'=>$merchant->user_id]);
            }
            $this->session->set_flashdata('message','Lender Assigned Successfully');
            $this->session->set_flashdata('message','success');
			return response(['status'=>'Success','message'=>'Successful']);
		}
    }
    public function assign_case($id){
        $merchant= $this->common_model->GetRow(TBL_USERS,['user_id'=>$id]);
        $setdata=[];
        $setdata['status']='ASSIGNED';
        $record=$this->common_model->GetRow(TBL_LENDER_ASSIGN,['merchant_id'=>$merchant->user_id]);
        if($record){
            $setdata['updated_at']=date('Y-m-d H:i:s');
            $this->common_model->UpdateData(TBL_LENDER_ASSIGN,$setdata,['id'=>$record->id]);
        }else{
            $setdata['merchant_id']=$merchant->user_id;
            $setdata['dsa_id']=$merchant->created_by;
            $setdata['created_at']=date('Y-m-d H:i:s');
            $setdata['updated_at']=date('Y-m-d H:i:s');
            $this->common_model->InsertData(TBL_LENDER_ASSIGN,$setdata);
        }
        $caselog=[];
        $caselog['merchant_id']=$merchant->user_id;
        $caselog['lender_id']=null;
        $caselog['change_by']=$this->session->userdata('full_name');
        $caselog['change_by_user_type']=$this->session->userdata('user_type');
        $caselog['log_text']='Assigned Case';
        $caselog['log_type']='STATUS';
        $caselog['status']='ASSIGNED';
        $this->common_model->InsertData('case_log',$caselog);
        $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s'),'assigned_time'=>date('Y-m-d H:i:s')],['user_id'=>$merchant->user_id]);
        $this->session->set_flashdata('message','Case Assigned Successfully');
        $this->session->set_flashdata('message','success');
        redirect_admin('merchant/detail/'.$id);
    }
	public function edit($user_id){
        //$partnerpermission= PartnerPermission();
        $this->data['states']=$this->common_model->GetResult(TBL_STATE,['country_id'=>101],'id,name');
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
            }else{
                $this->data['users']=$record;
                $this->data['detail']=$this->common_model->GetRow('user_detail',['user_id'=>$record->user_id]);
                $this->data['mobile_number']=$this->session->userdata('r_number');
                $this->data['content']="merchant/add2";
                $this->data['script']="merchant/add_script2";
            }
            $this->session->unset_userdata('r_number');
        }else{
            $this->data['detail']=$this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$record->user_id]);
            $this->data['users']=$record;
            $this->data['content']="merchant/edit";
            $this->data['script']="merchant/edit_script";
        }
        $this->load->view('super-admin',$this->data);
	}
	public function email_validation(){
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
                    if($this->input->post('date_of_birth') && $this->input->post('employment_type')=='Business'){
                        $detail = $this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$record->user_id]);
                        if(!empty($detail)){
                            $this->common_model->UpdateData(TBL_USER_DETAIL,['date_of_birth'=>$this->input->post('date_of_birth')],['user_id'=>$record->user_id]);
                        }else{
                            $this->common_model->InsertData(TBL_USER_DETAIL,['user_id'=>$record->user_id,'date_of_birth'=>$this->input->post('date_of_birth')]);
                        }
                    }
                    $insertId= $record->user_id;
                    $this->session->set_userdata(['r_number'=>$record->mobile_number]);
                    return response(['status'=>"success",'message'=>'Successful','id'=>$insertId]);
                }else{
                    return response(['status'=>"fail",'message'=>'Failure']);
                }
            }
        }
    }
    public function update_merchant(){
        if($this->input->server('REQUEST_METHOD')=='POST'){

            $setdata=[];
            $setdata['company_name']=$this->input->post('business_name');
            $setdata['status']=null;

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
            
			$insertId= $this->input->post('merchant_id');
            if($this->common_model->UpdateData(TBL_USERS,$setdata,['user_id'=>$insertId])){
                $setdata2['user_id']=$insertId;
                $this->common_model->UpdateData(TBL_USER_DETAIL,$setdata2,['user_id'=>$insertId]);
                
				$this->session->set_flashdata('message','Case Updated Successfully');
				$this->session->set_flashdata('message_type','success');
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
    public function add(){
        $partnerpermission= PartnerPermission();
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
        $this->data['dsalist']=$this->common_model->GetWhereWithIn(TBL_USERS,['user_type'=>'DSA'],'user_id',$partnerpermission,'user_id,company_name,full_name,file_id');
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
        $this->load->view('super-admin',$this->data);
    }
    public function add_email_validation(){
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
    public function edit_phone_validation(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|numeric');
            if($this->form_validation->run()==TRUE){
                $mobile_number=$this->input->post('mobile_number');
                $data = $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$mobile_number,'user_id!='=>$this->input->post('merchant_id')]);
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
    public function IncompleteForm(){
        $this->load->helper('cookie');
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['full_name']=$this->input->post('first_name').' '.$this->input->post('last_name');
            $record=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('phone')]);
            if(empty($record)){
                $lastsubfileid=1;
                $lastMerchant=$this->common_model->GetOrderByRow(TBL_USERS,['user_id','DESC'],['user_type'=>'MERCHANT']);
                if($lastMerchant){
                    $lastsubfileid = $lastMerchant->sub_id+1;
                }
                $setdata['sub_id']=$lastsubfileid;
                $setdata['file_id']='FTM'.sprintf('%07u', $lastsubfileid);
                $password=substr(str_replace(' ','',$setdata['full_name']),0,4).preg_replace('~[+\d-](?=[\d-]{4})~', '', $this->input->post('phone'));
                $setdata['password']=password_hash($password,PASSWORD_DEFAULT);
            }
            $setdata['user_type']='MERCHANT';
            $setdata['mobile_number']=$this->input->post('phone');
            $setdata['email']=$this->input->post('email');
            $setdata['age']=$this->input->post('age');
            $setdata['loan_type']=$this->input->post('employment_type');
            if($this->input->post('dsaid')){
                $setdata['created_by']=$this->input->post('dsaid');
            }else{
                $setdata['created_by']=$this->session->userdata('user_id');
            }

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
                $password=123456;
                $setdata['password']=password_hash($password,PASSWORD_DEFAULT);
                $setdata['status']='INCOMPLETE';
                $setdata['created_at']=date('Y-m-d H:i:s');
                $setdata['updated_at']=date('Y-m-d H:i:s');
                if($insertId= $this->common_model->InsertData(TBL_USERS,$setdata)){
                    $setdata2['user_id']=$insertId;
                    if($this->input->post('employment_type')=='Business'){
                        $setdata2['date_of_birth']=$this->input->post('date_of_birth');
                    }
                    $this->common_model->InsertData(TBL_USER_DETAIL,$setdata2);
                    $this->session->set_userdata(['r_number'=>$this->input->post('phone')]);
                    $message='Thanks for showing your interest in unsecured business loan. Our team will contact you shortly. www.fintranxect.com';
                    if($this->input->post('dsaid')==1746){
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

                if($this->input->post('key')=='no_of_partner')
                $setdata2['total_director_partner']=$this->input->post('value');
                
                if($this->input->post('key')=='no_of_director')
                $setdata2['total_director_partner']=$this->input->post('value');

                if($this->input->post('key')=='pan_number')
                $setdata2['pan_number']=$this->input->post('value');
                
                if($this->input->post('key')=='loan_type1')
                $setdata2['loan_type1']=$this->input->post('value');

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
                //$message='Dear '.$setdata['full_name'].' '.$password." is your login password. Please do not share to anyone";
                //SendOtpMessage($message,$this->input->post('mobile_number'));
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
                        $this->common_model->UpdateData(TBL_USERS,['status'=>null,'received_time'=>date('Y-m-d H:i:s')],['user_id'=>$insertId]);
                    }
                }
                $shortclose=$this->common_model->GetRow('user_lender_assign',['merchant_id'=>$insertId,'lender_id'=>null,'status'=>'SHORTCLOSE']);
                if(!empty($shortclose)){
                    $this->common_model->DeleteData('user_lender_assign',['id'=>$shortclose->id]);
                }
                $this->session->set_flashdata('message','Case Added Successfully');
				$this->session->set_flashdata('message_type','success');
                return response(['status'=>"success",'message'=>'Successful']);
            }else{
                return response(['status'=>"fail",'message'=>'Failure']);
            }
        }
    }
    
    public function comments($user_id){
        $this->data['record'] = $this->merchant_model->GetUserDetail($user_id);
        $this->data['comments']=$this->merchant_model->GetComments($user_id);
        $this->data['content']="merchant/comments";
        $this->data['script']="merchant/comment_script";
        $this->load->view('super-admin',$this->data);
    }
     public function Incomplete_status($user_id){
        $this->data['record'] = $this->merchant_model->GetIncompleteStatus($user_id);
        $this->load->view('super-admin',$this->data);
    }
    public function LeaveComment(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['merchant_id']=$this->input->post('merchant_id');
            $setdata['comment_by']=$this->input->post('comment_by');
            $setdata['comment']=$this->input->post('comment');
            $setdata['comment_for']=$this->input->post('comment_for');
            $setdata['admin_read']='1';
            $setdata['commented_by']='SUPER-ADMIN';
            $setdata['created_at']=date('Y-m-d H:i:s');
            if($insertId=$this->common_model->InsertData('comments',$setdata)){
                if($this->input->post('comment_for')=='LENDER'){
                    $merchant=$this->common_model->GetRow('user_lender_assign',['merchant_id'=>$this->input->post('merchant_id'),'lender_id'=>$this->input->post('comment_by')]);
                    if(!empty($merchant) && $merchant->status=='LOGGED'){
                        $this->common_model->UpdateData('user_lender_assign',['updated_at'=>date('Y-m-d H:i:s'),'pending_time'=>date('Y-m-d H:i:s'),'status'=>'PENDING'],['merchant_id'=>$this->input->post('merchant_id'),'lender_id'=>$merchant->lender_id]);
                        $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$this->input->post('merchant_id')]);
                    }
                }else{
                    $merchant=$this->common_model->GetRow('user_lender_assign',['merchant_id'=>$this->input->post('merchant_id'),'status'=>'LOGGED']);
                    if(!empty($merchant) && $merchant->status=='LOGGED'){
                        $this->common_model->UpdateData('user_lender_assign',['updated_at'=>date('Y-m-d H:i:s'),'status'=>'PENDING','pending_time'=>date('Y-m-d H:i:s')],['merchant_id'=>$this->input->post('merchant_id'),'status'=>'LOGGED']);
                        $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$this->input->post('merchant_id')]);
                    }
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
    
    public function pending($merchant_id,$lender_id){
        $setdata=[];
        $this->common_model->UpdateData(TBL_LENDER_ASSIGN,
						['status'=>'PENDING','updated_at'=>date('Y-m-d H:i:s'),'pending_time'=>date('Y-m-d H:i:s')],
						['merchant_id'=>$merchant_id,'lender_id'=>$lender_id]
                );
        $caselog=[];
        $caselog['merchant_id']=$merchant_id;
        $caselog['lender_id']=$lender_id;
        $caselog['change_by']=$this->session->userdata('full_name');
        $caselog['change_by_user_type']=$this->session->userdata('user_type');
        $caselog['log_text']='Logged Case';
        $caselog['log_type']='STATUS';
        $caselog['status']='PENDING';
        $this->common_model->InsertData('case_log',$caselog);
        $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$merchant_id]);
        redirect_admin('merchant/detail/'.$merchant_id);
    }
    public function approve($merchant_id,$lender_id){
        $setdata=[];
        $this->common_model->UpdateData(TBL_LENDER_ASSIGN,
						['status'=>'APPROVED','updated_at'=>date('Y-m-d H:i:s'),'approved_time'=>date('Y-m-d H:i:s')],
						['merchant_id'=>$merchant_id,'lender_id'=>$lender_id]
                );
        $caselog=[];
        $caselog['merchant_id']=$merchant_id;
        $caselog['lender_id']=$lender_id;
        $caselog['change_by']=$this->session->userdata('full_name');
        $caselog['change_by_user_type']=$this->session->userdata('user_type');
        $caselog['log_text']='Approved Case';
        $caselog['log_type']='STATUS';
        $caselog['status']='APPROVED';
        $this->common_model->InsertData('case_log',$caselog);
        $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$merchant_id]);
        redirect_admin('merchant/detail/'.$merchant_id);
    }
    
    public function RejectCase(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $user_id=$this->input->post('user_id');
            $lender_id=$this->input->post('lender_id');
            $user=$this->common_model->GetRow(TBL_USERS,['user_id'=>$user_id]);
            if(!empty($lender_id)){
                $setdata=[];
                $record=$this->common_model->GetRow('user_lender_assign',['merchant_id'=>$user_id,'lender_id'=>$lender_id]);
                if($user->created_by=='1793' && $user->other_app_user_id!=""){
                    $payToken = $this->GetPay1Token();
                    if(!empty($payToken) && !empty($payToken['api_token'])){
                        $token=$payToken['api_token'];
                        $url='https://loan.pragaticapital.in/sdk/loans/'.$user->file_id;
                        $headers=['x-api-token:Basic '.$token,'Content-type:application/json'];
                        $setpay1=[];
                        $setpay1['user_id']=$user->other_app_user_id;
                        $setpay1['interest_rate_yearly']=0;
                        $setpay1['emi_counts']=0;
                        $setpay1['amount_disbursed']=null;
                        $setpay1['loan_uid']=$user->file_id;
                        $setpay1['loan_amount']=0;
                        $setpay1['processing_fee']=0;
                        $setpay1['tenure']=0;
                        $setpay1['emi_amount_interest']=0;
                        $setpay1['emi_amount']=0;
                        $setpay1['type']=3;
                        $setpay1['amount_offered']=0;
                        $setpay1['emi_amount_principle']=0;
                        $this->CallApi($url,$headers,$setpay1);
                    }
                }
                $setdata['status']='REJECTED';
                $setdata['notification']=$this->input->post('comments');
                $setdata['updated_at']=date('Y-m-d H:i:s');
                $setdata['reject_time']=date('Y-m-d H:i:s');
                $this->common_model->UpdateData('user_lender_assign',$setdata,['merchant_id'=>$user_id,'lender_id'=>$lender_id]);
                
                if($user->total_assigned>0 && $user->total_assigned==($user->total_reject+1)){
                    $setdata2=[];
                    $setdata2['merchant_id']=$this->input->post('user_id');
                    $setdata2['lender_id']=$this->input->post('lender_id');
                    $setdata2['comment_by']=$user->created_by;
                    $setdata2['comment']=$this->input->post('comments');
                    $setdata2['comment_for']='PARTNER';
                    $setdata2['admin_read']='1';
                    $setdata2['commented_by']='SUPER-ADMIN';
                    $setdata2['created_at']=date('Y-m-d H:i:s');
                    $this->common_model->InsertData('comments',$setdata2);
                }
                $setdata4=[];
                $setdata4['merchant_id']=$user_id;
                if(!empty($record->lender_id)){
                    $setdata4['lender_id']=$record->lender_id;
                }
                $setdata4['reject_by']='SUPER-ADMIN';
                $setdata4['comments']=$this->input->post('comments');
                $setdata4['rejector_id']=$this->session->userdata('user_id');
                $setdata4['created_at']=date('Y-m-d H:i:s');
                $this->common_model->InsertData('reject_case',$setdata4);

                $caselog=[];
                $caselog['merchant_id']=$this->input->post('user_id');
                $caselog['lender_id']=$this->input->post('lender_id');
                $caselog['change_by']=$this->session->userdata('full_name');
                $caselog['change_by_user_type']=$this->session->userdata('user_type');
                $caselog['log_text']='Reject Case ('.$this->input->post('comments').')';
                $caselog['log_type']='STATUS';
                $caselog['status']='REJECTED';
                $this->common_model->InsertData('case_log',$caselog);
                
                $this->db->where(['user_id'=>$this->input->post('user_id')]);
                $this->db->set('total_reject', 'total_reject+1', FALSE);
                $this->db->update(TBL_USERS);
                return response(['status'=>'success','message'=>'Success']);
            }else{
                if($user->created_by=='1793' && $user->other_app_user_id!=""){
                    $payToken = $this->GetPay1Token();
                    if(!empty($payToken) && !empty($payToken['api_token'])){
                        $token=$payToken['api_token'];
                        $url='https://loan.pragaticapital.in/sdk/loans/'.$user->file_id;
                        $headers=['x-api-token:Basic '.$token,'Content-type:application/json'];
                        $setpay1=[];
                        $setpay1['user_id']=$user->other_app_user_id;
                        $setpay1['interest_rate_yearly']=0;
                        $setpay1['emi_counts']=0;
                        $setpay1['amount_disbursed']=null;
                        $setpay1['loan_uid']=$user->file_id;
                        $setpay1['loan_amount']=0;
                        $setpay1['processing_fee']=0;
                        $setpay1['tenure']=0;
                        $setpay1['emi_amount_interest']=0;
                        $setpay1['emi_amount']=0;
                        $setpay1['type']=3;
                        $setpay1['amount_offered']=0;
                        $setpay1['emi_amount_principle']=0;
                        $this->CallApi($url,$headers,$setpay1);
                    }
                }
                $record=$this->common_model->GetRow('user_lender_assign',['merchant_id'=>$user_id]);
                if($record){
                    $setdata['status']='REJECTED';
                    $setdata['notification']=$this->input->post('comments');
                    $setdata['updated_at']=date('Y-m-d H:i:s');
                    $setdata['reject_time']=date('Y-m-d H:i:s');
                    $this->common_model->UpdateData('user_lender_assign',$setdata,['merchant_id'=>$user_id]);
                }else{
                    $setdata['merchant_id']=$user->user_id;
                    $setdata['dsa_id']=$user->created_by;
                    $setdata['status']='REJECTED';
                    $setdata['notification']=$this->input->post('comments');
                    $setdata['created_at']=date('Y-m-d H:i:s');
                    $setdata['updated_at']=date('Y-m-d H:i:s');
                    $setdata['reject_time']=date('Y-m-d H:i:s');
                    $this->common_model->InsertData('user_lender_assign',$setdata);
                }
                $setdata2=[];
                $setdata2['merchant_id']=$this->input->post('user_id');
                $setdata2['lender_id']=$this->input->post('lender_id');
                $setdata2['comment_by']=$user->created_by;
                $setdata2['comment']=$this->input->post('comments');
                $setdata2['comment_for']='PARTNER';
                $setdata2['admin_read']='1';
                $setdata2['commented_by']='SUPER-ADMIN';
                $setdata2['created_at']=date('Y-m-d H:i:s');
                $this->common_model->InsertData('comments',$setdata2);

                $setdata4=[];
                $setdata4['merchant_id']=$user_id;
                if(!empty($record->lender_id)){
                    $setdata4['lender_id']=$record->lender_id;
                }
                $setdata4['reject_by']='SUPER-ADMIN';
                $setdata4['comments']=$this->input->post('comments');
                $setdata4['rejector_id']=$this->session->userdata('user_id');
                $setdata4['created_at']=date('Y-m-d H:i:s');
                $this->common_model->InsertData('reject_case',$setdata4);

                $caselog=[];
                $caselog['merchant_id']=$this->input->post('user_id');
                $caselog['change_by']=$this->session->userdata('full_name');
                $caselog['change_by_user_type']=$this->session->userdata('user_type');
                $caselog['log_text']='Reject Case ('.$this->input->post('comments').')';
                $caselog['log_type']='STATUS';
                $caselog['status']='REJECTED';
                $this->common_model->InsertData('case_log',$caselog);
                $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$this->input->post('user_id')]);
                return response(['status'=>'success','message'=>'Success']);
            }
        }
    }
    public function shortclose($user_id){
        $user=$this->common_model->GetRow(TBL_USERS,['user_id'=>$user_id]);
        $setdata=[];
        $record=$this->common_model->GetRow('user_lender_assign',['merchant_id'=>$user_id]);
        if($record){
            
        }else{
            $setdata['status']='SHORTCLOSE';
            $setdata['notification']='case is rejected because there were no documents.';
            $setdata['dsa_id']=$user->created_by;
            $setdata['merchant_id']=$user_id;
            $setdata['updated_at']=date('Y-m-d H:i:s');
            $setdata['created_at']=date('Y-m-d H:i:s');
            $this->common_model->InsertData('user_lender_assign',$setdata);
        }
        $setdata2=[];
        $setdata2['merchant_id']=$user_id;
        $setdata2['comment_by']=$user->created_by;
        $setdata2['comment']='case is rejected because there were no documents.';
        $setdata2['comment_for']='PARTNER';
        $setdata2['admin_read']='1';
        $setdata2['commented_by']='SUPER-ADMIN';
        $setdata2['created_at']=date('Y-m-d H:i:s');
        $this->common_model->InsertData('comments',$setdata2);

        $caselog=[];
        $caselog['merchant_id']=$user_id;
        $caselog['change_by']=$this->session->userdata('full_name');
        $caselog['change_by_user_type']=$this->session->userdata('user_type');
        $caselog['log_text']='Short Close Case (case is rejected because there were no documents )';
        $caselog['log_type']='STATUS';
        $caselog['status']='SHORTCLOSE';
        $this->common_model->InsertData('case_log',$caselog);

        $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s'),'short_close_time'=>date('Y-m-d H:i:s')],['user_id'=>$user_id]);
        redirect_admin('merchant/detail/'.$user_id);
    }
    public function reactive($merchant_id){
        $setdata=[];
        $this->common_model->DeleteData(TBL_LENDER_ASSIGN,['merchant_id'=>$merchant_id]);
        $caselog=[];
        $caselog['merchant_id']=$merchant_id;
        $caselog['change_by']=$this->session->userdata('full_name');
        $caselog['change_by_user_type']=$this->session->userdata('user_type');
        $caselog['log_text']='Incomplete Case';
        $caselog['log_type']='STATUS';
        $caselog['status']='INCOMPLETE';
        $this->common_model->InsertData('case_log',$caselog);
        $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s'),'total_assigned'=>null,'total_reject'=>null],['user_id'=>$merchant_id]);
        redirect_admin('merchant/detail/'.$merchant_id);
    }
    
    public function incompletecase($merchant_id){
        $setdata=[];
        $this->common_model->UpdateData(TBL_USERS,
						['status'=>'INCOMPLETE','updated_at'=>date('Y-m-d H:i:s')],
						['user_id'=>$merchant_id]
                );
        $caselog=[];
        $caselog['merchant_id']=$merchant_id;
        $caselog['change_by']=$this->session->userdata('full_name');
        $caselog['change_by_user_type']=$this->session->userdata('user_type');
        $caselog['log_text']='Incomplete Case';
        $caselog['log_type']='STATUS';
        $caselog['status']='INCOMPLETE';
        $this->common_model->InsertData('case_log',$caselog);
        //$this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s'),'approved_time'=>date('Y-m-d H:i:s')],['user_id'=>$merchant_id]);
        redirect_admin('merchant/detail/'.$merchant_id);
    }
    public function disburse(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $user_id=$this->input->post('merchant_id');
            $lender_id=$this->input->post('lender_id');
            $record=$this->common_model->GetRow('user_lender_assign',['merchant_id'=>$user_id,'lender_id'=>$lender_id]);
            $setdata=[];
            if($record){
                $user=$this->common_model->GetRow(TBL_USERS,['user_id'=>$user_id]);
                if($user->created_by=='1793' && $user->other_app_user_id!=""){
                    $payToken = $this->GetPay1Token();
                    if(!empty($payToken) && !empty($payToken['api_token'])){
                        $token=$payToken['api_token'];
                        $url='https://loan.pragaticapital.in/sdk/loans/'.$user->file_id;
                        $headers=['x-api-token:Basic '.$token,'Content-type:application/json'];
                        $setpay1=[];
                        $setpay1['user_id']=$user->other_app_user_id;
                        $setpay1['interest_rate_yearly']=0;
                        $setpay1['emi_counts']=0;
                        $setpay1['amount_disbursed']=$this->input->post('disburse_amount');
                        $setpay1['loan_uid']=$user->file_id;
                        $setpay1['loan_amount']=null;
                        $setpay1['processing_fee']=0;
                        $setpay1['tenure']=0;
                        $setpay1['emi_amount_interest']=0;
                        $setpay1['emi_amount']=0;
                        $setpay1['type']=7;
                        $setpay1['amount_offered']=0;
                        $setpay1['emi_amount_principle']=0;
                        $this->CallApi($url,$headers,$setpay1);
                    }
                }
                $setdata['status']='DISBURSED';
                $setdata['disbursed_amount']=$this->input->post('disburse_amount');
                $setdata['disbursed_time']=date('Y-m-d H:i:s');
                $setdata['updated_at']=date('Y-m-d H:i:s');
                $this->common_model->UpdateData('user_lender_assign',$setdata,['merchant_id'=>$user_id,'lender_id'=>$lender_id]);
                
                $caselog=[];
                $caselog['merchant_id']=$user_id;
                $caselog['lender_id']=$lender_id;
                $caselog['change_by']=$this->session->userdata('full_name');
                $caselog['change_by_user_type']=$this->session->userdata('user_type');
                $caselog['log_text']='Disbursed Case ( Amount '.$this->input->post('disburse_amount').')';
                $caselog['log_type']='STATUS';
                $caselog['status']='DISBURSED';
                $this->common_model->InsertData('case_log',$caselog);
                $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$user_id]);
            }
            return response(['status'=>'success']);
        }
    }
    public function LeaveRemark(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['merchant_id']=$this->input->post('merchant_id');
            $setdata['comments']=$this->input->post('comment');
            $setdata['comment_by']=$this->session->userdata('user_id');
            $setdata['created_at']=date('Y-m-d H:i:s');
            if(!empty($this->input->post('followuptime'))){
                $setdata['follow_up']=date('Y-m-d H:i:s',strtotime($this->input->post('followuptime')));
            }
            $this->common_model->InsertData('remark',$setdata);
            $caselog=[];
            $caselog['merchant_id']=$this->input->post('merchant_id');
            $caselog['change_by']=$this->session->userdata('full_name');
            $caselog['change_by_user_type']=$this->session->userdata('user_type');
            $caselog['log_text']=$this->input->post('comment');
            $caselog['log_type']='REMARK';
            $this->common_model->InsertData('case_log',$caselog);

            $this->common_model->UpdateData(TBL_USERS,['remark_time'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$this->input->post('merchant_id')]);
            return response(['status'=>'success','message'=>'Success','date'=>$setdata['created_at']]);
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
    public function IsResolved(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $record =$this->common_model->GetRow('comments',['comment_id'=>$this->input->post('comment_id')]);
            $setdata=[];
            $setdata['is_read']=0;
            $setdata['admin_read']=1;
            $setdata['is_resolved']=$this->input->post('is_resolved');
            $setdata['resolved_by']='SUPER-ADMIN';
            $this->common_model->UpdateData('comments',$setdata,['comment_id'=>$this->input->post('comment_id')]);

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
    public function IsRemarked(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $record =$this->common_model->GetRow('remark',['remark_id'=>$this->input->post('remark_id')]);
            $setdata=[];
            $setdata['resolved']=$this->input->post('is_resolved');
            $this->common_model->UpdateData('remark',$setdata,['remark_id'=>$this->input->post('remark_id')]);
            $caselog=[];
            $caselog['merchant_id']=$record->merchant_id;
            $caselog['change_by']=$this->session->userdata('full_name');
            $caselog['change_by_user_type']=$this->session->userdata('user_type');
            $caselog['log_text']='Change Status '.$this->input->post('is_resolved').' of ('.$record->comments.')';
            $caselog['log_type']='REMARK';
            $this->common_model->InsertData('case_log',$caselog);
            return response(['status'=>'success']);
        }
    }
    public function ActivateCase(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $user=$this->common_model->GetRow(TBL_USERS,['user_id'=>$this->input->post('user_id')]);
            $this->common_model->DeleteData('user_lender_assign',['merchant_id'=>$this->input->post('user_id')]);
            
            $setassign=[];
            $setassign['merchant_id']=$this->input->post('user_id');
            $setassign['dsa_id']=$user->created_by;
            $setassign['status']='ASSIGNED';
            $setassign['created_at']=$user->assigned_time;
            $setassign['updated_at']=$user->assigned_time;
            $this->common_model->InsertData('user_lender_assign',$setassign);

            $setdata4=[];
            $setdata4['merchant_id']=$this->input->post('user_id');
            $setdata4['reject_by']='SUPER-ADMIN';
            $setdata4['status']='ACTIVATE';
            $setdata4['rejector_id']=$this->session->userdata('user_id');
            $setdata4['created_at']=date('Y-m-d H:i:s');
            $this->common_model->InsertData('reject_case',$setdata4);

            $caselog=[];
            $caselog['merchant_id']=$this->input->post('user_id');
            $caselog['change_by']=$this->session->userdata('full_name');
            $caselog['change_by_user_type']=$this->session->userdata('user_type');
            $caselog['log_text']='Activate Case';
            $caselog['log_type']='STATUS';
            $this->common_model->InsertData('case_log',$caselog);

            $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s'),'total_reject'=>NULL,'total_assigned'=>null],['user_id'=>$this->input->post('user_id')]);
            return response(['status'=>'success']);
        }
    }
    public function personalDocuments(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $user=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('mobile_number')]);
            if($user){
                $setdata=[];
                if($this->input->post('bankstatement_password'))
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
    public function GetFollowup($userid){
        
         $this->data['follow_up']=$this->common_model->GetOrderByResult('remark',['follow_up','ASC'],['merchant_id'=>$userid,'follow_up!='=>""]);
         $this->load->view('super-admin/merchant/followup',$this->data);
         
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
    public function check_case_list(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
                if(!empty($this->input->post('key')) && !empty($this->input->post('value'))){
                    $setdata=[];
                    $setdata[$this->input->post('key')]=$this->input->post('value');
                    $record =$this->common_model->GetRow('check_form_business_type',['merchant_id'=>$this->input->post('merchant_id')]);
                    if($record){
                        $this->common_model->UpdateData('check_form_business_type',$setdata,['merchant_id'=>$this->input->post('merchant_id')]);
                    }else{
                        $setdata['merchant_id']=$this->input->post('merchant_id');
                        $this->common_model->InsertData('check_form_business_type',$setdata);
                    }
                    if($this->input->post('key')=='full_name' || $this->input->post('key')=='age' || $this->input->post('key')=='mobile_number' || $this->input->post('key')=='email'){
                        $this->common_model->UpdateData(TBL_USERS,[$this->input->post('key')=>$this->input->post('value'),'updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$this->input->post('merchant_id')]);
                    }elseif($this->input->post('key')=='business_type'){
                        $this->common_model->UpdateData(TBL_USER_DETAIL,['loan_type1'=>$this->input->post('value')],['user_id'=>$this->input->post('merchant_id')]);
                    }else{
                        $this->common_model->UpdateData(TBL_USER_DETAIL,[$this->input->post('key')=>$this->input->post('value')],['user_id'=>$this->input->post('merchant_id')]);
                    }
                    $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$this->input->post('merchant_id')]);
                }
        }
    }
    public function check_list(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            if(!empty($this->input->post('key'))){
                $setdata=[];
                $setdata[$this->input->post('key')]=$this->input->post('value');
                $record =$this->common_model->GetRow('check_form_business_type',['merchant_id'=>$this->input->post('merchant_id')]);
                if($record){
                    $this->common_model->UpdateData('check_form_business_type',$setdata,['merchant_id'=>$this->input->post('merchant_id')]);
                }else{
                    $setdata['merchant_id']=$this->input->post('merchant_id');
                    $this->common_model->InsertData('check_form_business_type',$setdata);
                }
            }
        }
    }
}