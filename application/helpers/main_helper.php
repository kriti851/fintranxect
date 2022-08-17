<?php

require_once APPPATH.'third_party/Bucket/vendor/autoload.php';
use Aws\S3\S3Client;

if(!function_exists('response')){
    function response($response){
        $ci =& get_instance();
        return $ci->output
		->set_content_type('application/json')
		->set_status_header(200)
		->set_output(json_encode($response));
    }
}
if(!function_exists('SendOtpMessage')){
    function SendOtpMessage($message,$mobileNumber){
	       $url = "http://bulksms.msghouse.in/api/sendhttp.php?authkey=8631AZZeTzqTr5eb44510P11&mobiles=".$mobileNumber."&message=".urlencode($message)."&sender=TEXCTV&route=4&country=91";
	 $ch = curl_init();  
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//  curl_setopt($ch,CURLOPT_HEADER, false); 
    $output=curl_exec($ch);
    curl_close($ch);
    //return $output;
	    return true;

	}
}
if(!function_exists('SendEmail')){
    function SendEmail($to,$name){
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.googlemail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "kaushal.smtgroup@gmail.com";
        $config['smtp_pass'] = "Kaushal@123#";

        $message = 'Hi $name,
        Thank you for writing to us. We have received your message and will get back to you within 24 hours.
        Your sincerely,
        Team FinTranxect.';

        $config['mailtype'] = "text";
        $ci = & get_instance();
        $ci->load->library('email', $config);
        //$ci->email->set_newline("\r\n");
        $ci->email->from("kaushal.smtgroup@gmail.com ");
        $ci->email->to($to);
        $ci->email->subject("Reply From Team FinTranxect");
        $ci->email->message($message);
        $ci->email->send();  
        echo $ci->email->print_debugger();

    }
}
if(!function_exists('params')){
    function params(){
        $ci =& get_instance();
		$get = $ci->input->get();
		$post = $ci->input->post();
		$jsonpost = (array)json_decode($ci->input->raw_input_stream);
		return (array)array_merge($jsonpost,$get,$post);
	}
}

if(!function_exists('uploadFile')){
    function uploadFile($filename,$file){
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => S3_REGION,
            //'endpoint' => 'https://www.fintranxect.com',
          //  'use_path_style_endpoint' => true,
            'use_aws_shared_config_files' => false,
          //  'csm'=>false,
            'credentials' => [
                'key'    => S3_key,
                'secret' => S3_secret
            ]
        ]);
        $key = $filename;
        try {
            $result = $s3Client->putObject([
                'Bucket' => S3_bucket,
                'Key'    => $key,
                'Body'   => $file,
                'ACL'    => 'public-read',
            ]);
        } catch (Aws\S3\Exception\S3Exception $e) {
            echo $e->getMessage();die;
        }
        return true;
    }
}

if(!function_exists('s3_url')){
    function s3_url($str=""){
        return 'https://fintranxect.s3.ap-south-1.amazonaws.com/'.$str;
    }
}
