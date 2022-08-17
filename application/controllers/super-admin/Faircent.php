<?php

class Faircent extends CI_Controller{
    private $data=[];
    public function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->output->delete_cache();
        $this->load->model('super-admin/merchant_model');
        $this->load->helper('admin');
        isAdminLogin();
    }
    public function index(){
        $record=$this->merchant_model->GetUserDetail2(2578);
        //echo "<pre>";print_r($record);die;
        $explode=explode(' ',$record->full_name);
        $setdata['user']='test';
        $setdata['password']='test@123';
        $setdata['first_name']=$explode[0];
        $setdata['last_name']=end($explode);
        $setdata['dob']=date('d-m-Y',strtotime($record->date_of_birth));
        $setdata['pan']=$record->pan_number;
        $setdata['mobile']=$record->mobile_number;
        $setdata['pin']=$record->residence_pincode;
        $setdata['state']=$record->residence_state;
        $setdata['city']=$record->residence_city;
        if($record->gender=='Male'){
            $setdata['gender']='M';
        }elseif($record->gender=='Female'){
            $setdata['gender']='F';
        }
        $setdata['email']=$record->email;
        if(!empty($record->pancard_image)){
            $panarray=explode(',',$record->pancard_image);
            if(file_exists(FCPATH.'uploads/merchant/pancard/'.$panarray[0])){
                $setdata['pan_card_img']=base_url('uploads/merchant/pancard/'.$panarray[0]);
            }
        }
        if(!empty($record->salery_slip)){
            $salaryarray=explode(',',$record->salery_slip);
            if(file_exists(FCPATH.'uploads/merchant/salery_slip/'.$salaryarray[0])){
                $setdata['salary_slip1']=base_url('uploads/merchant/salery_slip/'.$salaryarray[0]);
            }
        }
        if(!empty($record->bank_statement)){
            $bankarray=explode(',',$record->bank_statement);
            if(file_exists(FCPATH.'uploads/merchant/bankstatement/'.$bankarray[0])){
                $setdata['bankstatement']=base_url('uploads/merchant/bankstatement/'.$bankarray[0]);
            }
        }
        $data = json_encode($setdata);
        echo $data;die;
        $url='https://qc1.faircent.com/borrower_registration_api_with_downloads';
        //$url=site_url('welcome/test');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array
        (
            'Access-Control-Allow-Origin: *',
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);
        echo $result;
    }
    
}