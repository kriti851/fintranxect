<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class Newgrowth extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model(['super-admin/newgrowth_model']);
    }
    /* private $secretKey='9D7N6-0lU2tp4WlQ4nucSQ';
    private $createurl='https://uat.advancesuite.in:3030/create_lead';
    private $detailurl='https://uat.advancesuite.in:3030/partner/lead_details';
    private $metaurl='https://uat.advancesuite.in:3030/document_meta';
    private $documentUpload='https://uat.advancesuite.in:3030/upload_document';
    private $documentDelete='https://uat.advancesuite.in:3030/delete_document'; */
    private $secretKey='zfNgflFNo8LX9eEnJra5kw';
    private $createurl='https://alliance.advancesuite.in/create_lead';
    private $detailurl='https://alliance.advancesuite.in/partner/lead_details';
    private $metaurl='https://alliance.advancesuite.in/document_meta';
    private $documentUpload='https://alliance.advancesuite.in/upload_document';
    private $documentDelete='https://alliance.advancesuite.in/delete_document';
   /*  public function index(){
       return response($_FILES);
    } */
    public function create_lead(){
       if($this->input->server('REQUEST_METHOD')=='POST'){
            $user = $this->common_model->GetRow(TBL_USERS,['user_id'=>$this->input->post('merchant_id')]);
            $where=['user_id'=>$this->input->post('merchant_id')];
            $table="user_detail";
            if($user->loan_type=='Business'){
                $table='user_merchant_detail';
            }
            $detail = $this->common_model->GetRow($table,['user_id'=>$this->input->post('merchant_id')]);
            $setdata=[];
            $setdata['partner_name']='FINTRANXECT DIGITAL SOLUTIONS PRIVATE LIMITED';
            $fullName=explode(' ',trim($user->full_name));
            $lastName = array_pop($fullName);
            $setdata['first_name']=implode(' ',$fullName);
            $setdata['last_name']=$lastName;
            $setdata['city']=$this->input->post('city');
            $setdata['loan_amount']=$this->input->post('loanamount');
            $setdata['email']=$user->email;
            $setdata['pan']=$detail->pan_number;
            $setdata['mobile']=$user->mobile_number;
            $setdata['employement']=$user->loan_type;
            if(!empty($detail->date_of_birth))
            $setdata['date_of_birth']=date('d/m/Y',strtotime($detail->date_of_birth));

            if($user->loan_type=='Business'){
                $setdata['pincode']=$detail->pincode;
            }else{
                $setdata['pincode']=$detail->residence_pincode;
            }
            if($user->company_name){
                $setdata['merchant_name']=$user->company_name;
            }else{
                $setdata['merchant_name']=$user->full_name;
            }
            if(!empty($detail->vintage))
                $setdata['business_vintage']=$detail->vintage;
                
            if(!empty($detail->business_address))
                $setdata['office_address']=$detail->business_address;
                        
            if(!empty($detail->business_type)){
                if($detail->business_type=='Proprietorship' || $detail->business_type=='Partnership'){
                    $setdata['business_type']=$detail->business_type;
                }else{
                    $setdata['business_type']='Company';
                }
            }
            $setdata['checksum_hash']=base64_encode(hex2bin(hash_hmac('sha1',$setdata['city'].','.$setdata['mobile'].','.$this->secretKey,$this->secretKey)));
            $headers=['Content-type:application/json'];
            $response=$this->CallApi($this->createurl,$headers,json_encode($setdata));
            if($response->status==200){
                $this->common_model->InsertData('newgrowth_lead',['user_id'=>$this->input->post('merchant_id'),'lead_id'=>$response->id,'create_data'=>json_encode($setdata)]);
                $this->GetDetail($this->input->post('merchant_id'),$response->id);
                return response(['status'=>'success','message'=>$response->message]);
            }else{
                return response(['status'=>'failure','message'=>$response->message]);
            }
            
        }
    }
    public function getSatus(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $data=$this->GetDetail($this->input->post('merchant_id'),$this->input->post('lead_id'));
            $data->documents=$this->newgrowth_model->getdocuments($this->input->post('merchant_id'));
            return response(['status'=>'success','data'=>$data]);
        }
    }
    private function GetDetail($uid,$id){
        $data=json_decode(file_get_contents($this->detailurl.'?id='.$id));
        $this->common_model->UpdateData('newgrowth_lead',['detail_response'=>json_encode($data),'case_status'=>$data->current_status],['user_id'=>$uid,'lead_id'=>$data->lead_id]);
        return $data;
    }
    /* public function getDocumentType(){
        $setdata=[];
        $setdata['partner_name']='FINTRANXECT DIGITAL SOLUTIONS PRIVATE LIMITED';
        $setdata['checksum_hash']=base64_encode(hex2bin(hash_hmac('sha1','FINTRANXECT DIGITAL SOLUTIONS PRIVATE LIMITED,'.$this->secretKey,$this->secretKey)));
        
        $url=$this->metaurl.'?'.http_build_query($setdata);
        //$data=json_decode(file_get_contents());
        echo "<pre>";print_r($url);die;
    } */
    public function uploadsDocuments(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $url=$this->documentUpload;
            //$url='https://testing.fintranxect.com/super-admin/newgrowth';
            $headers=["cache-control: no-cache",'content-type: multipart/form-data;'];
            $setdata=[];
            $setdata['partner_name']='FINTRANXECT DIGITAL SOLUTIONS PRIVATE LIMITED';
            $setdata['lead_id']=$this->input->post('lead_id');
            $setdata['document_meta_id']=$this->input->post('document_meta_id');
            $setdata['file']=curl_file_create($_FILES['dsa_document']['tmp_name'],$_FILES['dsa_document']['type'],$_FILES['dsa_document']['name']);
            $setdata['checksum_hash']=base64_encode(hex2bin(hash_hmac('sha1',$this->input->post('document_meta_id').','.$this->input->post('lead_id').','.$this->secretKey,$this->secretKey)));
            $response = $this->callApi($url,$headers,$setdata);
            if(!empty($response->document_id)){
                $record= $this->common_model->GetRow('newgrowth_documents',['user_id'=>$this->input->post('merchant_id'),'type_id'=>$this->input->post('document_meta_id')]);
                if($record){
                    $this->common_model->UpdateData('newgrowth_documents',['document_id'=>$response->document_id],['id'=>$record->id]);
                }else{
                    $insertdata=[];
                    $insertdata['user_id']=$this->input->post('merchant_id');
                    $insertdata['type_id']=$this->input->post('document_meta_id');
                    $insertdata['document_id']=$response->document_id;
                    $this->common_model->InsertData('newgrowth_documents',$insertdata);
                }
                return response(['status'=>'success','data'=>$response]);
            }else{
                return response(['status'=>'fail','data'=>$response]);
            }
            //print_r($response);die;
        }
    }
    public function delete_document(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            $setdata=[];
            $setdata['partner_name']='FINTRANXECT DIGITAL SOLUTIONS PRIVATE LIMITED';
            $setdata['lead_id']=$this->input->post('lead_id');
            $setdata['document_id']=$this->input->post('document_id');
            $setdata['checksum_hash']=base64_encode(hex2bin(hash_hmac('sha1',$this->input->post('lead_id').','.$this->input->post('document_id').','.$this->secretKey,$this->secretKey)));
            $url=$this->documentDelete.'?'.http_build_query($setdata);
            $data=json_decode(file_get_contents($url));
            $this->common_model->DeleteData('newgrowth_documents',['user_id'=>$this->input->post('merchant_id'),'document_id'=>$this->input->post('document_id')]);
            return response(['status'=>'success','data'=>$data]);
        }
    }
    private function CallApi($url,$headers,$data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return json_decode($response);
    }
}