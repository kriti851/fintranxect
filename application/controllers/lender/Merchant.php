<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Merchant extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
        $this->load->helper('lender');
        $this->load->model(['lender/merchant_model']);
        isLenderLogin();
    }
    public function index(){
        $per_page=10;
        $search=$keyword="";
		if($this->input->get('per_page')){
			$per_page=$this->input->get('per_page');
		}
		$type=$this->input->get('type');
		$keyword=$this->input->get('keyword');
		$date_range=$this->input->get('date_range');
		$loan_type=$this->input->get('loan_type');
		if($this->input->server('REQUEST_METHOD')=='GET'){
            $search.='?type='.$type;
            if(!empty($keyword)){
                $search.='&keyword='.$keyword;
            }if(!empty($loan_type)){
                $search.='&loan_type='.$loan_type;
            }
        }
		$config=GetPagination($per_page);
		$config['base_url'] = lender_url("merchant/index".$search);	
		$config['total_rows'] = $this->merchant_model->CountMerchantList($keyword,$type,$date_range,$loan_type);
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$this->data['pagination']=$this->pagination->create_links();
		$page=$this->input->get('page');
		if($page > 1){
			$page=($page-1)*$config["per_page"];
		}else{
			$page=0;
		}
        $this->data['results']=$this->merchant_model->MerchantList($config['per_page'],$page,$keyword,$type,$date_range,$loan_type);
        $this->data['content']="merchant/index";
        $this->data['script']="merchant/script";
        $this->load->view('lender',$this->data);
	}
	public function detail($userid){
        $this->common_model->UpdateData('comments',['is_read'=>'1'],['merchant_id'=>$userid,'is_read'=>0,'comment_by'=>$this->session->userdata('user_id'),'comment_for'=>'LENDER']);
        $this->data['comments']=$this->common_model->GetResult('comments',['comment_by'=>$this->session->userdata('user_id'),'merchant_id'=>$userid,'comment_for'=>'LENDER']);
        $record =$this->common_model->GetRow(TBL_USERS,['user_id'=>$userid]);
        if($record->loan_type=='Business'){
            $this->data['record'] = $this->merchant_model->GetUserDetail($userid);
            $this->data['content']="merchant/detail";
        }else{
            $this->data['record'] = $this->merchant_model->GetUserDetail2($userid);
            $this->data['content']="merchant/detail2";
        }
        $this->data['script']="merchant/detail_script";
        $this->load->view('lender',$this->data);
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
    public function LeaveComment(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $record= $this->common_model->GetRow(TBL_LENDER_ASSIGN,['merchant_id'=>$this->input->post('merchant_id')]);
            if(!empty($record->status) && $record->status=='LOGGED'){
                $this->common_model->UpdateData(TBL_LENDER_ASSIGN,['status'=>'PENDING','updated_at'=>date('Y-m-d H:i:s')],['merchant_id'=>$this->input->post('merchant_id')]);
                $caselog=[];
                $caselog['merchant_id']=$this->input->post('merchant_id');
                $caselog['change_by']=$this->session->userdata('full_name');
                $caselog['change_by_user_type']=$this->session->userdata('user_type');
                $caselog['log_text']='Pending';
                $caselog['log_type']='STATUS';
                $caselog['status']='PENDING';
                $this->common_model->InsertData('case_log',$caselog);
                $this->common_model->UpdateData(TBL_USERS,['pending_time'=>date('Y-m-d H:i:s')],['user_id'=>$this->input->post('merchant_id')]);
            }
            $setdata=[];
            $setdata['merchant_id']=$this->input->post('merchant_id');
            $setdata['comment_by']=$this->input->post('comment_by');
            $setdata['comment']=$this->input->post('comment');
            $setdata['comment_for']=$this->input->post('comment_for');
            $setdata['is_read']='1';
            $setdata['commented_by']='LENDER';
            $setdata['created_at']=date('Y-m-d H:i:s');
            if($insertId=$this->common_model->InsertData('comments',$setdata)){
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
    public function IsResolved(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $record = $this->common_model->GetRow('comments',['comment_id'=>$this->input->post('comment_id')]);
            $setdata=[];
            $setdata['is_read']=1;
            $setdata['admin_read']=0;
            $setdata['is_resolved']=$this->input->post('is_resolved');
            $setdata['resolved_by']='LENDER';
            $this->common_model->UpdateData('comments',$setdata,['comment_id'=>$this->input->post('comment_id')]);
            
            $caselog=[];
            $caselog['merchant_id']=$record->merchant_id;
            $caselog['change_by']=$this->session->userdata('full_name');
            $caselog['change_by_user_type']=$this->session->userdata('user_type');
            $caselog['log_text']='Resolved status of comment ('.$record->comment.')';
            $caselog['log_type']='COMMENT';
            $this->common_model->InsertData('case_log',$caselog);
            $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s'),'comment_time'=>date('Y-m-d H:i:s')],['user_id'=>$record->merchant_id]);
            return response(['status'=>'success']);
        }
    }
    public function approve($userid){
        $setdata=[];
        $setdata['status']='APPROVED';
        $setdata['approved_time']=date('Y-m-d H:i:s');
        $setdata['updated_at']=date('Y-m-d H:i:s');
        $this->common_model->UpdateData('user_lender_assign',$setdata,['merchant_id'=>$userid,'lender_id'=>$this->session->userdata('user_id')]);
        
        $caselog=[];
        $caselog['merchant_id']=$userid;
        $caselog['change_by']=$this->session->userdata('full_name');
        $caselog['change_by_user_type']=$this->session->userdata('user_type');
        $caselog['log_text']='Approved Case';
        $caselog['log_type']='STATUS';
        $caselog['status']='APPROVED';
        $this->common_model->InsertData('case_log',$caselog);

        $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$userid]);
        redirect_lender('merchant/detail/'.$userid);
    }
    public function reject($userid){
        $setdata=[];
        $setdata['status']='REJECT';
        $setdata['updated_at']=date('Y-m-d H:i:s');
        $this->common_model->UpdateData('user_lender_assign',$setdata,['merchant_id'=>$userid]);

        $caselog=[];
        $caselog['merchant_id']=$userid;
        $caselog['change_by']=$this->session->userdata('full_name');
        $caselog['change_by_user_type']=$this->session->userdata('user_type');
        $caselog['log_text']='Reject Case';
        $caselog['log_type']='STATUS';
        $caselog['status']='REJECTED';
        $this->common_model->InsertData('case_log',$caselog);
        $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s'),'reject_time'=>date('Y-m-d H:i:s')],['user_id'=>$userid]);
        redirect_lender('merchant/detail/'.$userid);
    }
    public function RejectCase(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $user_id=$this->input->post('user_id');
            $user=$this->common_model->GetRow(TBL_USERS,['user_id'=>$user_id]);
            $setdata=[];
            $record=$this->common_model->GetRow('user_lender_assign',['merchant_id'=>$user_id,'lender_id'=>$this->session->userdata('user_id')]);
            if($record){
                $setdata['status']='REJECTED';
                $setdata['reject_time']=date('Y-m-d H:i:s');
                $setdata['notification']=$this->input->post('comments');
                $setdata['updated_at']=date('Y-m-d H:i:s');
                $this->common_model->UpdateData('user_lender_assign',$setdata,['merchant_id'=>$user_id]);
            }else{
                $setdata['status']='REJECTED';
                $setdata['reject_time']=date('Y-m-d H:i:s');
                $setdata['notification']=$this->input->post('comments');
                $setdata['dsa_id']=$user->created_by;
                $setdata['merchant_id']=$user_id;
                $setdata['updated_at']=date('Y-m-d H:i:s');
                $setdata['created_at']=date('Y-m-d H:i:s');
                $this->common_model->InsertData('user_lender_assign',$setdata);
            }
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
            $setdata2=[];
            $setdata2['merchant_id']=$this->input->post('user_id');
            $setdata2['comment_by']=$this->session->userdata('user_id');
            $setdata2['comment']=$this->input->post('comments');
            $setdata2['comment_for']='LENDER';
            $setdata2['is_read']='1';
            $setdata2['commented_by']='LENDER';
            $setdata2['created_at']=date('Y-m-d H:i:s');
            $this->common_model->InsertData('comments',$setdata2);

            $setdata4=[];
            $setdata4['merchant_id']=$user_id;
            if(!empty($record->lender_id)){
                $setdata4['lender_id']=$record->lender_id;
            }
            $setdata4['reject_by']='LENDER';
            $setdata4['comments']=$this->input->post('comments');
            $setdata4['rejector_id']=$this->session->userdata('user_id');
            $setdata4['created_at']=date('Y-m-d H:i:s');
            $this->common_model->InsertData('reject_case',$setdata4);

            $caselog=[];
            $caselog['merchant_id']=$user_id;
            $caselog['change_by']=$this->session->userdata('full_name');
            $caselog['change_by_user_type']=$this->session->userdata('user_type');
            $caselog['log_text']='Reject Case ('.$this->input->post('comments').')';
            $caselog['log_type']='STATUS';
            $caselog['status']='REJECTED';
            $this->common_model->InsertData('case_log',$caselog);

            $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$user_id]);
            return response(['status'=>'success','message'=>'Success']);
        }
    }
    public function disburse(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['status']='DISBURSED';
            $setdata['disbursed_time']=date('Y-m-d H:i:s');
            $setdata['updated_at']=date('Y-m-d H:i:s');
            $setdata['disbursed_amount']=$this->input->post('disburse_amount');
            $this->common_model->UpdateData('user_lender_assign',$setdata,['merchant_id'=>$this->input->post('merchant_id'),'lender_id'=>$this->session->userdata('user_id')]);
            
            $user=$this->common_model->GetRow(TBL_USERS,['user_id'=>$this->input->post('merchant_id')]);
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
            $caselog=[];
            $caselog['merchant_id']=$this->input->post('merchant_id');
            $caselog['change_by']=$this->session->userdata('full_name');
            $caselog['change_by_user_type']=$this->session->userdata('user_type');
            $caselog['log_text']='Disbursed Case ( Amount '.$this->input->post('disburse_amount').')';
            $caselog['log_type']='STATUS';
            $caselog['status']='DISBURSED';
            $this->common_model->InsertData('case_log',$caselog);

            $this->common_model->UpdateData(TBL_USERS,['updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$this->input->post('merchant_id')]);
            return response(['status'=>'success']);
        }
    }
    public function comments($merchant_id){
        $this->common_model->UpdateData('comments',['is_read'=>'1'],['merchant_id'=>$merchant_id,'is_read'=>0,'comment_by'=>$this->session->userdata('user_id'),'comment_for'=>'LENDER']);
        $this->data['record'] = $this->merchant_model->GetUserDetail($merchant_id);
        $this->data['comments']=$this->common_model->GetResult('comments',['comment_by'=>$this->session->userdata('user_id'),'merchant_id'=>$merchant_id,'comment_for'=>'LENDER']);
        $this->data['content']="merchant/verify";
        $this->data['script']="merchant/verify_script";
        $this->load->view('lender',$this->data);
    }
    public function IsVerifyRequest(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
	        $data=$this->common_model->GetRow(TBL_LENDER_ASSIGN,['id'=>$this->input->post('assign_id')]);
            $setdata=[];
            if($data->status=='LOGGED'){
                $setdata['status']='PENDING';
                $this->common_model->UpdateData(TBL_USERS,['pending_time'=>date('Y-m-d H:i:s')],['user_id'=>$data->merchant_id]);
            }
            $setdata['reason']=$this->input->post('message');
            if($data){
                $this->common_model->UpdateData(TBL_LENDER_ASSIGN,$setdata,['id'=>$this->input->post('assign_id')]);
                $setdata=[];
                $setdata['merchant_id']=$data->merchant_id;
                $setdata['comment_by']=$this->session->userdata('user_id');
                $setdata['comment']=$this->input->post('message');
                $setdata['commented_by']='LENDER';
                $setdata['is_read']='1';
                $setdata['comment_for']='LENDER';
                $setdata['created_at']=date('Y-m-d H:i:s');
                $this->common_model->InsertData('comments',$setdata);
                $this->common_model->UpdateData(TBL_USERS,['comment_time'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$data->merchant_id]);
            }
            return response(['status'=>'Success','message'=>'Successful']);
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
        $setdata['resolved_by']='LENDER';
        $this->common_model->UpdateData('comments',$setdata,['comment_id'=>$commentid]);
        return redirect_lender('merchant/comments/'.$record->merchant_id);
    }
    
    public function DownloadApplicant($user_id=""){
		$data=$this->merchant_model->GetMerchantResult($user_id);
		$this->load->library('PHPExcel');
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
		
		$objPHPExcel->getActiveSheet()->SetCellValue('AF' . 1, 'Bankstatement Password');
		$objPHPExcel->getActiveSheet()->SetCellValue('AG' . 1, 'Date Of Birth');

		$rowCount = 2;
        //echo "<pre>";print_r($data);die;
        $this->load->library('zip');
		foreach ($data as $row)
		{
            $multifiles = [];
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row->file_id);
            $currentstatus='';
            if(!empty($row->status) && $row->status=='INCOMPLETE'){
                $currentstatus='INCOMPLETE';
            }else{
                $assign = $this->common_model->GetRow('user_lender_assign',['merchant_id'=>$row->user_id]);
                if(!empty($assign)){
                    $currentstatus=$assign->status;
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
			$objPHPExcel->getActiveSheet()->SetCellValue('AG' . $rowCount, $row->date_of_birth);
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
            $objPHPExcel->getActiveSheet()->SetCellValue('AF' .$rowCount,$row->bankstatement_password);
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
				$rowCount=($arowcount-1);
			}elseif($newrowcount>$rowCount){
				$rowCount=($newrowcount-1);
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
        $objPHPExcel->getActiveSheet()->SetCellValue('AO' . 1, 'Bankstatement Password');

		$rowCount = 2;
        $this->load->library('zip');
		foreach ($data as $row)
		{
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row->file_id);
            $currentstatus='';
            
            $assign = $this->common_model->GetRow('user_lender_assign',['merchant_id'=>$row->user_id]);
            if(!empty($assign)){
                $currentstatus=$assign->status;
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
            $objPHPExcel->getActiveSheet()->SetCellValue('AO' .$rowCount,$row->bankstatement_password);
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
}