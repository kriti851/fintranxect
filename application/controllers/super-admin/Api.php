<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
        $this->load->helper('admin');
        $this->load->model(['super-admin/merchant_model']);
        isAdminLogin();
    }

    public function CallJsonApi($url,$data){
        $json= json_encode($data);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
                "X-Api-Key:c301a286-bcfe-4d5f-b8e3-6e4650a224e6"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return false;
        } else {
            return $response;
        }
    }
    public function LendingCart($merchant_id){
        $user = $this->common_model->GetRow(TBL_USERS,['user_id'=>$merchant_id]);
        if($user->loan_type!='Salaried'){
            $userdata=$this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$user->user_id]);
            $setdata=[];
            $fullname=explode(' ',$user->full_name);
            $setdata['firstName']=$fullname[0];
            $setdata['lastName']=end($fullname);
            $setdata['email']=$user->email;
            $setdata['mobile']=$user->mobile_number;
            $setdata['businessAge']=$user->age;
            $registeredAs='';
            if($userdata->business_type=='PVT .ltd'){
                $registeredAs='Pvt. Ltd.';
            }elseif($userdata->business_type=='Individual'){
                $registeredAs='One Person Company';
            }else{
                $registeredAs=$userdata->business_type;
            }
            $setdata['registeredAs']=$registeredAs;
            $setdata['cibilConsentForLK']=true;
            $setdata['mobileNoVerified']=true;
            $setdata['personalAddress']=[
                "pincode"=>$userdata->pincode,
                "city"=>$userdata->city,
                "state"=>$userdata->state,
                "address"=>$userdata->houseno.' '.$userdata->city.' '.$userdata->state,
            ];
            //$setdata['personalPAN']=$userdata->pan_number;
            $setdata['businessRevenue']=$userdata->turn_over;
            $setdata['natureOfBusinessOthers']=$userdata->nature_of_business;
            if($userdata->business_type=='PVT .ltd'){
                $director=[];
                $directorData= $this->common_model->GetResult(TBL_USER_PARTNER,['user_id'=>$user->user_id]);
                foreach($directorData as $data){
                    $dname=explode(' ',$data->name);
                    $director[]=[
                        'pan'=>$data->pan_number,
                        'firstName'=>$dname[0],
                        'lastName'=>end($dname)
                    ];
                }
                $setdata['otherDirectors']=$director;
            }
            $setdata['uniqueId']=$user->file_id;
           // $setdata['otherFields']='';
            $url='https://lkext.lendingkart.com/admin/lead/v2/partner/leads/create-application';
            //$url=site_url('ajax/Test');
            $response = $this->CallJsonApi($url,$setdata);
            echo "<pre>";print_r($response);die;
        }
    }
    public function LendingCart2(){

        $url=site_url('ajax/Test');
        $post = array('val1' => 'value','val2' => 'value','file'=>new CURLFile('/var/www/html/uploads/Loan Applicant.xls'));
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $post,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        echo $response;
        }
    }
}