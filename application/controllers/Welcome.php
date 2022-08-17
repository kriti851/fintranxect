<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
    }
    private $data=[];
	public function index()
	{
	    $this->data['content']="home/index2";
		$this->load->view('template.php',$this->data);
	}
	public function registration()
	{
	    $this->data['content']="registration/index";
		$this->load->view('template.php',$this->data);
	}
	public function login()
	{
	    if($this->input->server('REQUEST_METHOD')=='POST'){
	         $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|numeric');
	         $this->form_validation->set_rules('password', 'Password', 'required');
            if($this->form_validation->run()==TRUE){
                $data = $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->input->post('mobile_number'),'user_type!='=>'MERCHANT']);
                if($data){
                    if(password_verify($this->input->post('password'),$data->password)){
                        $loginlog=[];

                        $loginlog['file_id']=$data->file_id;
                        $loginlog['full_name']=$data->full_name;
                        $loginlog['company_name']=$data->company_name;
                        $loginlog['ip_address']=$this->input->ip_address();
                        $loginlog['login_time']=date('Y-m-d H:i:s');
                        $this->common_model->InsertData('login_log',$loginlog);

                        $setdata=[];
                        $setdata['email']=$data->email;
                        $setdata['full_name']=$data->full_name;
                        $setdata['user_name']=$data->user_name;
                        $setdata['mobile_number']=$data->mobile_number;
                        $setdata['file_id']=$data->file_id;
                        $setdata['user_type']=$data->user_type;
                        $setdata['profile_id']=$data->profile_id;
                        if($data->partner_id!="" && $data->user_type=='SUB-DSA'){
                            $setdata['user_id']=$data->partner_id;
                            $setdata['sub_user_id']=$data->user_id;
                            $maindsa=$this->common_model->GetRow(TBL_USERS,['user_id'=>$data->partner_id],'user_name');
                            $setdata['user_name']=$maindsa->user_name;
                            $profile_assign=$this->common_model->GetRow('partner_profile_assign',['user_id'=>$data->user_id]);
                            if(!empty($profile_assign)){
                                $permission= $this->common_model->GetRow('partner_profile',['id'=>$profile_assign->profile_id]);
                                if(!empty($permission)){
                                    $setdata['dsa']['main_permission']= json_decode($permission->permission);
                                    $setdata['dsa']['sub_permission']= json_decode($permission->sub_permission);
                                }
                            }
                        }else{
                            $setdata['user_id']=$data->user_id;
                        }
                        
                        
                        if(!empty($data->profile_id)){
                            $permission= $this->common_model->GetRow('profile',['profile_id'=>$data->profile_id]);
                            if(!empty($permission)){
                                $setdata['admin']['main_permission']= json_decode($permission->permission);
                                $setdata['admin']['sub_permission']= json_decode($permission->sub_permission);
                            }
                        }
                        $partner_ids=$this->common_model->GetResult('admin_users_permission',['user_id'=>$data->user_id],'partner_id');
                        if(!empty($partner_ids)){
                            $setdata['admin']['partner_ids']=array_column($partner_ids,'partner_id');
                        }else{
                            $setdata['admin']['partner_ids']=[];
                        }
                        $setdata['__token']='@&%$%&*^%&*%$*';
                        $url="";
                        if($data->user_type=='LENDERS'){
                            $url=site_url('lender/dashboard');
                        }elseif($data->user_type=='SUPER-ADMIN' || $data->user_type=='USERS'){
                            $setdata['__token']='@3$%&*^%&*%@#$';
                             $url=site_url('super-admin/dashboard');
                        }elseif($data->user_type=='DSA' || $data->user_type=='SUB-DSA'){
                            $url=site_url('dsa/dashboard');
                        }else{
                            $url=site_url('merchant/dashboard'); 
                        }
                        $this->session->set_userdata($setdata);
                        $last_login = date('Y-m-d H:i:s');
                        $this->common_model->UpdateData(TBL_USERS,['last_login'=>$last_login],['mobile_number'=>$this->input->post('mobile_number')]);
                        $this->session->set_flashdata('message','Login Successful');
                        $this->session->set_flashdata('message_type','success');
                        redirect($url);
                    }else{
                        $this->data['password_error']="Invalid Password";
                    }
                }else{
                    $this->data['mobile_number_error']="Mobile Number does not exists.";
                }
            }
	    }
	    $this->data['is_show_morquee']=true;
	    $this->data['content']="login/index";
		$this->load->view('template.php',$this->data);
    }
    private function GetPay1Token(){
        $url='http://loandev.pay1.in/sdk/tokens';
        $username=base64_encode("fintranxect:f!n+r@nxect@pay1");
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
	public function loan()
	{
        $otherapp_user_id='';
        $this->output->delete_cache();
        if(!empty($this->input->get('user_id'))){
            $this->session->set_userdata('pay1_user_id',$this->input->get('user_id'));
            $payToken = $this->GetPay1Token();
            if(!empty($payToken) && !empty($payToken['api_token'])){
                $token=$payToken['api_token'];
                $url='http://loandev.pay1.in/sdk/customers/'.$this->input->get('user_id');
                $headers=['x-api-token:Basic '.$token,'Content-type:application/json'];
                $response= $this->CallApi($url,$headers,[]);
                $this->data['pay1data']=(object)json_decode($response,true);
                if($this->data['pay1data']->id){
                    $this->data['otherapp_user_id']=$this->data['pay1data']->id;
                }
            }
        }elseif(!empty($this->session->userdata('pay1_user_id'))){
           /*  $payToken = $this->GetPay1Token();
            if(!empty($payToken) && !empty($payToken['api_token'])){
                $token=$payToken['api_token'];
                $url='http://loandev.pay1.in/sdk/customers/'.$this->session->userdata('pay1_user_id');
                $headers=['x-api-token:Basic '.$token,'Content-type:application/json'];
                $response= $this->CallApi($url,$headers,[]);
                $this->data['pay1data']=(object)json_decode($response,true);
            } */
        }
        if(!empty($this->uri->segment(1))){
            $this->data['agent']=$this->common_model->GetRow(TBL_USERS,['user_name'=>$this->uri->segment(1)]);
            $this->data['logoagent']=$this->data['agent'];
            if(empty($this->data['agent'])){
                redirect('/');
            }
        }
        $this->data['states']=$this->common_model->GetResult(TBL_STATE,['country_id'=>101],'id,name');
        //print_r(get_cookie('r_number'));die;
        if(!empty($this->session->userdata('r_number'))){
            $record = $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$this->session->userdata('r_number'),'status'=>'INCOMPLETE']);
            if($record){
                if($record->loan_type=='Salaried'){
                    $this->data['users']=$record;
                    $this->data['detail']=$this->common_model->GetRow('user_detail',['user_id'=>$record->user_id]);
                    $this->data['mobile_number']=$this->session->userdata('r_number');
                    $this->data['content']="loan/personal";
                    $this->data['scripts']="loan/personal_script";
                    $this->data['is_script']='No';
                    $this->session->unset_userdata("r_number");
                    $this->session->unset_userdata('pay1_user_id');
                    $this->data['showPartnerHeader']='Yes';
                }else{
                    $record->applicant=$this->common_model->GetResult(TBL_USER_COAPPLICANT,['user_id'=>$record->user_id]);
                    $this->data['users']=$record;
                    $this->data['detail']=$this->common_model->GetRow(TBL_USER_DETAIL,['user_id'=>$record->user_id]);
                    $this->data['partner']=$this->common_model->GetResult(TBL_USER_PARTNER,['user_id'=>$record->user_id]);
                    $this->data['content']="loan/index";
                    $this->data['mobile_number']=$this->session->userdata('r_number');
                    $this->session->unset_userdata("r_number");
                    $this->session->unset_userdata('pay1_user_id');
                    $this->data['showPartnerHeader']='Yes';
                }
            }else{
                $this->data['content']="loan/form";
            }
        }else{
            $this->data['content']="loan/form";
        }
        $this->data['showheader']='No';
        $this->data['is_show_morquee']=true;
		$this->load->view('template.php',$this->data);
    }
    public function about(){
        $this->data['content']="home/about";
		$this->load->view('template.php',$this->data);
    }
    public function service(){
        $this->data['content']="home/service";
		$this->load->view('template.php',$this->data);
    }
    public function terms_of_use(){
        $this->data['content']="term-of-use/index";
		$this->load->view('template.php',$this->data);
    }
    public function privacy_policy(){
        $this->data['content']="privacy-policy/index";
		$this->load->view('template.php',$this->data);
    }
    public function contact(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email','Email', 'required|valid_email');
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|numeric|min_length[10]|max_length[10]');
            $this->form_validation->set_rules('comments','Message', 'required');
             if($this->form_validation->run()==TRUE){
               
                $this->data['success_message']='Thanks for connecting with us.';
                
             }
        }
        /* $to      = 'kaushal.smtgroup@gmail.com';
        $subject = 'the subject';
        $message = 'hello';
        $headers = 'From: info@fintranxect.com' . "\r\n" .
            'Reply-To: info@fintranxect.com' . "\r\n" ;
        echo mail($to, $subject, $message, $headers); */
       /*  $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
        $this->email->from('info@fintranxect.com', 'Fintranxect');
        $this->email->to('kaushal.smtgroup@gmail.com');
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');
        $this->email->send(); */

        $this->data['content']="home/contact";
		$this->load->view('template.php',$this->data);
    }
    public function index2()
	{
	    $this->data['content']="home/index2";
		$this->load->view('template.php',$this->data);
    }
    public function sendmail(){
        $to      = 'kaushal.smtgroup@gmail.com';
        $subject = 'the subject';
        $message = 'This is testing mail of fintranxect.';
        $headers = 'From: info@fintranxect.com' . "\r\n" .
            'Reply-To: info@fintranxect.com' . "\r\n" ;
        if(mail($to, $subject, $message, $headers)){
            echo "success";
        }else{
            echo "Fail";
        }
    }
    public function sendcimail(){
        $this->load->library('email');
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
        $this->email->from('info@fintranxect.com', 'Fintranxect');
        $this->email->to('kaushal.smtgroup@gmail.com');
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');
        echo $this->email->send();
    }
    public function track_status(){
        $this->data['content']="track/index";
		$this->load->view('template.php',$this->data);
    }
    public function test(){
        return response(['status'=>'success','data'=>params()]);
    }
    public function s3bucket(){
        s3bucket(12,12);
    }


    public function UploadS3Image() {
                define('AWS_S3_KEY', 'AKIAUGG23JXEJMQ4WVBN');
                define('AWS_S3_SECRET', '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');
                define('AWS_S3_REGION', 'ap-northeast-1');
                define('AWS_S3_BUCKET', 'autism-images');
                define('AWS_S3_URL', 'http://s3.'.AWS_S3_REGION.'.amazonaws.com/'.AWS_S3_BUCKET.'/');

              
                //create S3Client object with access keys
                $client = new S3Client([
                    'credentials' => [
                        'key' => AWS_S3_KEY,
                    'secret' => AWS_S3_SECRET,
                    ],
                    'region' => AWS_S3_REGION,

                    'version' => '2006-03-01', //if you don’t know the current version, just write ‘latest’
                    'debug'   => [
                        'logfn'        => function ($msg) { echo $msg . "\n"; },
                        'stream_size'  => 0,
                        'scrub_auth'   => true,
                        'http'         => true,
                        'auth_headers' => [
                            'X-My-Secret-Header' => '[REDACTED]',
                        ],
                        'auth_strings' => [
                            '/SuperSecret=[A-Za-z0-9]{20}/i' => 'SuperSecret=[REDACTED]',
                        ],
                    ]
                ]);


                $fileName = "./Lendingkart.jpg";

                $changedFileName = str_replace(" ","",$fileName); //replace all spaces in filename if any with empty string, as S3 doesn’t allow files with spaces to be added as per naming conventions

                $uploadedFileName = trim($changedFileName); //remove any whitespaces from filename

                // Upload the file using putObject method of S3Client. The type and size of the file will be determined by the SDK.
                // try {
                // $response = $client->putObject([
                // 'Bucket' => AWS_S3_BUCKET,
                // 'Key' => $uploadedFileName,
                // 'ACL' => 'public-read', //giving public access to the file
                // ]);
                // print_r($response); //print the response coming from AWS

                // } catch (Aws\S3\Exception\S3Exception $e) {

                // echo "An error occurred while uploading the file on server.";
                // }
    }
    public function uploadImage(){
        $path = $_FILES['image']['tmp_name'];
       $filename='merchant/business/'.strtolower(uniqid() . $_FILES['image']['name']);
         uploadFile($path,$filename);
         echo s3_url($filename);
    }
    
}
