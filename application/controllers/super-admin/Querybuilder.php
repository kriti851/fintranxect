<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Querybuilder extends CI_Controller{
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
        $this->load->model(['super-admin/query_builder_model']);
        $this->load->helper('admin');
        isAdminLogin();
        if(!MainPermission(6)){
			redirect_admin('dashboard');
		}
    }
    private function select($data,$type=""){
        $partnerpermission= PartnerPermission();
        $select ="SELECT ".TBL_USERS.".*,dsa.company_name as dsa_name,dsa.file_id as dsa_id,".TBL_LENDER_ASSIGN.".lender_id,".TBL_LENDER_ASSIGN.".status as lender_status,lender.company_name as lender_companyname,".
			TBL_LENDER_ASSIGN.".pending_time,".TBL_LENDER_ASSIGN.".logged_time,".TBL_LENDER_ASSIGN.".approved_time,".TBL_LENDER_ASSIGN.".reject_time,".TBL_LENDER_ASSIGN.".disbursed_time,".TBL_LENDER_ASSIGN.".disbursed_amount,user_merchant_detail.business_type,user_detail.father_name";
        if($type=="Business"){
            $select.=",".TBL_USER_DETAIL.".*,".TBL_USERS.".user_id";
        }elseif($type=="Salaried"){
            $select.=",user_detail.*,".TBL_USERS.".user_id";
        }
            $query=$select." FROM `users` LEFT JOIN `users` as `dsa` ON `dsa`.`user_id`=`users`.`created_by` 
                LEFT JOIN `user_detail` ON `user_detail`.user_id=`users`.`user_id` 
                LEFT JOIN `user_merchant_detail` ON `user_merchant_detail`.user_id=`users`.`user_id` 
                LEFT JOIN `user_lender_assign` ON `user_lender_assign`.`merchant_id`=`users`.user_id 
                LEFT JOIN `users` as `lender` ON `lender`.`user_id`=`user_lender_assign`.`lender_id` WHERE `users`.`user_type` = 'MERCHANT' ";
        if(!empty($data->dsa_id)){
            $query .=" AND ".TBL_USERS.".created_by=".$data->dsa_id;
        } 
        if(!empty($partnerpermission)){
            $query .=" AND ".TBL_USERS.".created_by IN(".implode(',',$partnerpermission).") ";
        }
        if(!empty($data->lender_id)){
            $query .=" AND user_lender_assign.lender_id=".$data->lender_id;
        }
        if(!empty($data->users_loan_type_operator) && $data->users_loan_type!=""){
            $query .= $this->loan_type_response($data->users_loan_type_operator,$data->users_loan_type);
        }
        if(!empty($data->type_of_firm_operator) && $data->type_of_firm!=""){
            $query .= $this->firm_type_response($data->type_of_firm_operator,$data->type_of_firm);
        }
        if(!empty($data->users_file_id_operator) && $data->users_file_id!=""){
            $query .= $this->file_id_response($data->users_file_id_operator,$data->users_file_id);
        }
        if(!empty($data->users_full_name_operator) && $data->users_file_id!=""){
            $query .= $this->fullname_response($data->users_full_name_operator,$data->users_full_name);
        }
        if(!empty($data->users_email_operator) && $data->users_email!=""){
            $query .= $this->email_response($data->users_email_operator,$data->users_email);
        }
        if(!empty($data->users_mobile_number_operator) && $data->users_mobile_number!=""){
            $query .= $this->mobile_response($data->users_mobile_number_operator,$data->users_mobile_number);
        }
        $query .= $this->company_response($data->users_company_name_operator,$data->users_company_name);
        $query .= $this->company_response($data->users_age_operator,$data->users_age);
        $query .= $this->created_response($data->users_created_operator,$data->users_created_at);
        $query .= $this->received_response($data->users_received_operator,$data->users_received_time);
        $query .= $this->shortclose_response($data->users_short_close_operator,$data->users_short_close_time);
        $query .= $this->comment_response($data->users_comment_operator,$data->users_comment_time);
        $query .= $this->remark_response($data->users_remark_operator,$data->users_remark_time);
        $query .= $this->assigned_response($data->user_assigned_operator,$data->users_assigned_time);
        $query .= $this->logged_response($data->user_logged_operator,$data->user_logged_time);
        $query .= $this->pending_response($data->user_pending_operator,$data->user_pending_time);
        $query .= $this->approved_response($data->user_approved_operator,$data->user_approved_time);
        $query .= $this->reject_response($data->user_reject_operator,$data->user_reject_time);
        $query .= $this->disbursed_response($data->user_disbursed_operator,$data->user_disbursed_time);
        $query .= $this->city_response($data->city_operator,$data->city);
        $query .= $this->pincode_response($data->pincode_operator,$data->pincode);
        $query .= $this->state_response($data->state_operator,$data->state);
        $query .= $this->fathername_response($data->father_name_operator,$data->father_name);
        $query .= $this->qualification_response($data->qualification_operator,$data->qualification);
        $query .= $this->marital_status_response($data->marital_status_operator,$data->marital_status);
        $query .= $this->employer_name_response($data->employer_name_operator,$data->employer_name);
        if(!empty($data->status_operator) && $data->status!=""){
            $query .= $this->status_response($data->status_operator,$data->status);
        }
        $query.=" GROUP BY users.user_id";
        if($data->orderby_operator!="" && $data->order_by){
            $query.=$this->orderby_response($data->orderby_operator,$data->order_by);
        }
        return $query;
    }
    public function index(){
        $partnerpermission= PartnerPermission();
        $data=(object)$this->input->get();
        if(!empty($data->per_page)){
            $last_query=http_build_query($this->input->get());
            echo '<script>window.location.href="'.admin_url().'querybuilder/report?'.$last_query.'";
            </script>';
           
        }
        $this->data['dsa_list']=$this->common_model->GetWhereWithIn(TBL_USERS,['user_type'=>'DSA'],'user_id',$partnerpermission,'full_name,company_name,user_id,file_id');
        $this->data['lender_list']=$this->common_model->GetResult(TBL_USERS,['user_type'=>'LENDERS'],'full_name,company_name,user_id,file_id');
        $this->data['content']="query-builder/index";
        $this->data['script']="query-builder/script";
        $this->load->view('super-admin',$this->data);
    }
    public function report(){
        $data= (object)$this->input->get();
        $query = $this->select($data);
        $per_page=25;
		if($this->input->get('per_page')){
            $per_page=$this->input->get('per_page');
            
		}
        $config=GetPagination($per_page);
        $getParam=$this->input->get();
        unset($getParam['page']);
        $config['base_url'] = admin_url("querybuilder/report?".http_build_query($getParam));	
		$config['total_rows'] = $this->db->query($query)->num_rows();
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
        $this->data['results']=$this->query_builder_model->Get($config['per_page'],$page,$query);
        $this->data['content']="query-builder/record";
        $this->data['script']="query-builder/record_script";
        $this->load->view('super-admin',$this->data);
    }
    private function loan_type_response($operator,$fieldvalue){
            $sql=" AND users.loan_type='$fieldvalue'";
        return $sql;
    }
    private function firm_type_response($operator,$fieldvalue){
            $sql=" AND user_merchant_detail='$fieldvalue'";
        return $sql;
    }
    private function file_id_response($operator,$fieldvalue){
        $sql="";
        if($operator=="=" && $fieldvalue!=""){
            $sql=" AND users.file_id='$fieldvalue'";
        }elseif($operator=="LIKE"){
            $sql=" AND users.file_id LIKE '$fieldvalue'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND users.file_id LIKE '%$fieldvalue%'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND users.file_id NOT LIKE '$fieldvalue'";
        }elseif($operator=="IN(...)"){
            $sql=" AND users.file_id IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="NOT IN(...)"){
            $sql=" AND users.file_id NOT IN('".implode("','",explode(',',$fieldvalue))."')";
        }
        return $sql;
    } 
    private function fullname_response($operator,$fieldvalue){
        $sql="";
        if($operator=="=" && $fieldvalue!=""){
            $sql=" AND users.full_name='$fieldvalue'";
        }elseif($operator=="LIKE"){
            $sql=" AND users.full_name LIKE '$fieldvalue'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND users.full_name LIKE '%$fieldvalue%'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND users.full_name NOT LIKE '$fieldvalue'";
        }elseif($operator=="IN(...)"){
            $sql=" AND users.full_name IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="NOT IN(...)"){
            $sql=" AND users.full_name NOT IN('".implode("','",explode(',',$fieldvalue))."')";
        }
        return $sql;
    }
    private function email_response($operator,$fieldvalue){
        $sql="";
        if($operator=="=" && $fieldvalue!=""){
            $sql=" AND users.email='$fieldvalue'";
        }elseif($operator=="LIKE"){
            $sql=" AND users.email LIKE '$fieldvalue'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND users.email LIKE '%$fieldvalue%'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND users.email NOT LIKE '$fieldvalue'";
        }elseif($operator=="IN(...)"){
            $sql=" AND users.email IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="NOT IN(...)"){
            $sql=" AND users.email NOT IN('".implode("','",explode(',',$fieldvalue))."')";
        }
        return $sql;
    }
    private function mobile_response($operator,$fieldvalue){
        $sql="";
        if($operator=="=" && $fieldvalue!=""){
            $sql=" AND users.mobile_number='$fieldvalue'";
        }elseif($operator=="LIKE"){
            $sql=" AND users.mobile_number LIKE '$fieldvalue'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND users.mobile_number LIKE '%$fieldvalue%'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND users.mobile_number NOT LIKE '$fieldvalue'";
        }elseif($operator=="IN(...)"){
            $sql=" AND users.mobile_number IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="NOT IN(...)"){
            $sql=" AND users.mobile_number NOT IN('".implode("','",explode(',',$fieldvalue))."')";
        }
        return $sql;
    }
    private function company_response($operator,$fieldvalue){
        $sql="";
        if($operator=="=" && $fieldvalue!=""){
            $sql=" AND users.company_name='$fieldvalue'";
        }elseif($operator=="LIKE"){
            $sql=" AND users.company_name LIKE '$fieldvalue'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND users.company_name LIKE '%$fieldvalue%'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND users.company_name NOT LIKE '$fieldvalue'";
        }elseif($operator=="IN(...)"){
            $sql=" AND users.company_name IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="NOT IN(...)"){
            $sql=" AND users.company_name NOT IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="= ''"){
            $sql=" AND users.company_name =''";
        }elseif($operator=="!= ''"){
            $sql=" AND users.company_name != ''";
        }elseif($operator=="IS NULL"){
            $sql=" AND users.company_name IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND users.company_name IS NOT NULL";
        }
        return $sql;
    }
    private function age_response($operator,$fieldvalue){
        $sql="";
        if($operator=="=" && $fieldvalue!=""){
            $sql=" AND users.age='$fieldvalue'";
        }elseif($operator==">="){
            $sql=" AND users.age >= '$fieldvalue'";
        }elseif($operator=="<="){
            $sql=" AND users.age <= '$fieldvalue'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND users.age LIKE '%$fieldvalue%'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND users.age NOT LIKE '$fieldvalue'";
        }elseif($operator=="IN(...)"){
            $sql=" AND users.age IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="NOT IN(...)"){
            $sql=" AND users.age NOT IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="= ''"){
            $sql=" AND users.age =''";
        }elseif($operator=="!= ''"){
            $sql=" AND users.age != ''";
        }elseif($operator=="IS NULL"){
            $sql=" AND users.age IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND users.age IS NOT NULL";
        }elseif($operator=="BETWEEN"){
            $exp=explode(',',$fieldvalue);
            $sql=" AND (users.age >= $exp[0] AND users.age <=".end($exp).")";
        }
        return $sql;
    }
    public function created_response($operator,$fieldvalue){
        $sql="";
        if($operator=='BETWEEN'){
            $exp=explode(' - ',$fieldvalue);
            $sql=" AND ( DATE(users.created_at) >= '".date('Y-m-d',strtotime($exp[0]))."' AND DATE(users.created_at) <='".date('Y-m-d',strtotime(end($exp)))."')";
        }elseif($operator=="=" && $fieldvalue!=""){
            $sql=" AND DATE(users.created_at) ='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator==">="){
            $sql=" AND DATE(users.created_at) >='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="<="){
            $sql=" AND DATE(users.created_at) <='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND DATE(users.created_at) LIKE '".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND DATE(users.created_at) LIKE '%".date('Y-m-d',strtotime($fieldvalue))."%'";
        }elseif($operator=="IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(users.created_at) IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="NOT IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(users.created_at) NOT IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="= ''"){
            $sql=" AND DATE(users.created_at) =''";
        }elseif($operator=="!= ''"){
            $sql=" AND DATE(users.created_at) !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND DATE(users.created_at) IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND DATE(users.created_at) IS NOT NULL";
        }
        return $sql;
    }
    public function received_response($operator,$fieldvalue){
        $sql="";
        if($operator=='BETWEEN'){
            $exp=explode(' - ',$fieldvalue);
            $sql=" AND ( DATE(users.received_time) >= '".date('Y-m-d',strtotime($exp[0]))."' AND DATE(users.received_time) <='".date('Y-m-d',strtotime(end($exp)))."')";
        }elseif($operator=="=" && $fieldvalue!=""){
            $sql=" AND DATE(users.received_time) ='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator==">="){
            $sql=" AND DATE(users.received_time) >='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="<="){
            $sql=" AND DATE(users.received_time) <='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND DATE(users.received_time) LIKE '".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND DATE(users.received_time) LIKE '%".date('Y-m-d',strtotime($fieldvalue))."%'";
        }elseif($operator=="IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(users.received_time) IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="NOT IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(users.received_time) NOT IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="= ''"){
            $sql=" AND DATE(users.received_time) =''";
        }elseif($operator=="!= ''"){
            $sql=" AND DATE(users.received_time) !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND DATE(users.received_time) IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND DATE(users.received_time) IS NOT NULL";
        }
        return $sql;
    }
    public function shortclose_response($operator,$fieldvalue){
        $sql="";
        if($operator=='BETWEEN'){
            $exp=explode(' - ',$fieldvalue);
            $sql=" AND ( DATE(users.short_close_time) >= '".date('Y-m-d',strtotime($exp[0]))."' AND DATE(users.short_close_time) <='".date('Y-m-d',strtotime(end($exp)))."')";
        }elseif($operator=="=" && $fieldvalue!=""){
            $sql=" AND DATE(users.short_close_time) ='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator==">="){
            $sql=" AND DATE(users.short_close_time) >='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="<="){
            $sql=" AND DATE(users.short_close_time) <='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND DATE(users.short_close_time) LIKE '".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND DATE(users.short_close_time) LIKE '%".date('Y-m-d',strtotime($fieldvalue))."%'";
        }elseif($operator=="IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(users.short_close_time) IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="NOT IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(users.short_close_time) NOT IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="= ''"){
            $sql=" AND DATE(users.short_close_time) =''";
        }elseif($operator=="!= ''"){
            $sql=" AND DATE(users.short_close_time) !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND DATE(users.short_close_time) IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND DATE(users.short_close_time) IS NOT NULL";
        }
        return $sql;
    }
    public function comment_response($operator,$fieldvalue){
        $sql="";
        if($operator=='BETWEEN'){
            $exp=explode(' - ',$fieldvalue);
            $sql=" AND ( DATE(users.comment_time) >= '".date('Y-m-d',strtotime($exp[0]))."' AND DATE(users.comment_time) <='".date('Y-m-d',strtotime(end($exp)))."')";
        }elseif($operator=="=" && $fieldvalue!=""){
            $sql=" AND DATE(users.comment_time) ='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator==">="){
            $sql=" AND DATE(users.comment_time) >='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="<="){
            $sql=" AND DATE(users.comment_time) <='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND DATE(users.comment_time) LIKE '".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND DATE(users.comment_time) LIKE '%".date('Y-m-d',strtotime($fieldvalue))."%'";
        }elseif($operator=="IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(users.comment_time) IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="NOT IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(users.comment_time) NOT IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="= ''"){
            $sql=" AND DATE(users.comment_time) =''";
        }elseif($operator=="!= ''"){
            $sql=" AND DATE(users.comment_time) !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND DATE(users.comment_time) IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND DATE(users.comment_time) IS NOT NULL";
        }
        return $sql;
    }
    public function remark_response($operator,$fieldvalue){
        $sql="";
        if($operator=='BETWEEN'){
            $exp=explode(' - ',$fieldvalue);
            $sql=" AND ( DATE(users.remark_time) >= '".date('Y-m-d',strtotime($exp[0]))."' AND DATE(users.remark_time) <='".date('Y-m-d',strtotime(end($exp)))."')";
        }elseif($operator=="=" && $fieldvalue!=""){
            $sql=" AND DATE(users.remark_time) ='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator==">="){
            $sql=" AND DATE(users.remark_time) >='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="<="){
            $sql=" AND DATE(users.remark_time) <='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND DATE(users.remark_time) LIKE '".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND DATE(users.remark_time) LIKE '%".date('Y-m-d',strtotime($fieldvalue))."%'";
        }elseif($operator=="IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(users.remark_time) IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="NOT IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(users.remark_time) NOT IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="= ''"){
            $sql=" AND DATE(users.remark_time) =''";
        }elseif($operator=="!= ''"){
            $sql=" AND DATE(users.remark_time) !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND DATE(users.remark_time) IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND DATE(users.remark_time) IS NOT NULL";
        }
        return $sql;
    }
    public function assigned_response($operator,$fieldvalue){
        $sql="";
        if($operator=='BETWEEN'){
            $exp=explode(' - ',$fieldvalue);
            $sql=" AND ( DATE(users.assigned_time) >= '".date('Y-m-d',strtotime($exp[0]))."' AND DATE(user_lender_assign.assigned_time) <='".date('Y-m-d',strtotime(end($exp)))."')";
        }elseif($operator=="=" && $fieldvalue!=""){
            $sql=" AND DATE(users.assigned_time) ='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator==">="){
            $sql=" AND DATE(users.assigned_time) >='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="<="){
            $sql=" AND DATE(users.assigned_time) <='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND DATE(users.assigned_time) LIKE '".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND DATE(users.assigned_time) LIKE '%".date('Y-m-d',strtotime($fieldvalue))."%'";
        }elseif($operator=="IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(users.assigned_time) IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="NOT IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(users.assigned_time) NOT IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="= ''"){
            $sql=" AND DATE(users.assigned_time) =''";
        }elseif($operator=="!= ''"){
            $sql=" AND DATE(users.assigned_time) !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND DATE(users.assigned_time) IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND DATE(users.assigned_time) IS NOT NULL";
        }
        return $sql;
    }
    public function logged_response($operator,$fieldvalue){
        $sql="";
        if($operator=='BETWEEN'){
            $exp=explode(' - ',$fieldvalue);
            $sql=" AND ( DATE(user_lender_assign.logged_time) >= '".date('Y-m-d',strtotime($exp[0]))."' AND DATE(user_lender_assign.logged_time) <='".date('Y-m-d',strtotime(end($exp)))."')";
        }elseif($operator=="=" && $fieldvalue!=""){
            $sql=" AND DATE(user_lender_assign.logged_time) ='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator==">="){
            $sql=" AND DATE(user_lender_assign.logged_time) >='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="<="){
            $sql=" AND DATE(user_lender_assign.logged_time) <='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND DATE(user_lender_assign.logged_time) LIKE '".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND DATE(user_lender_assign.logged_time) LIKE '%".date('Y-m-d',strtotime($fieldvalue))."%'";
        }elseif($operator=="IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(user_lender_assign.logged_time) IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="NOT IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(user_lender_assign.logged_time) NOT IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="= ''"){
            $sql=" AND DATE(user_lender_assign.logged_time) =''";
        }elseif($operator=="!= ''"){
            $sql=" AND DATE(user_lender_assign.logged_time) !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND DATE(user_lender_assign.logged_time) IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND DATE(user_lender_assign.logged_time) IS NOT NULL";
        }
        return $sql;
    }
    public function pending_response($operator,$fieldvalue){
        $sql="";
        if($operator=='BETWEEN'){
            $exp=explode(' - ',$fieldvalue);
            $sql=" AND ( DATE(user_lender_assign.pending_time) >= '".date('Y-m-d',strtotime($exp[0]))."' AND DATE(user_lender_assign.pending_time) <='".date('Y-m-d',strtotime(end($exp)))."')";
        }elseif($operator=="=" && $fieldvalue!=""){
            $sql=" AND DATE(user_lender_assign.pending_time) ='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator==">="){
            $sql=" AND DATE(user_lender_assign.pending_time) >='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="<="){
            $sql=" AND DATE(user_lender_assign.pending_time) <='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND DATE(user_lender_assign.pending_time) LIKE '".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND DATE(user_lender_assign.pending_time) LIKE '%".date('Y-m-d',strtotime($fieldvalue))."%'";
        }elseif($operator=="IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(user_lender_assign.pending_time) IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="NOT IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(user_lender_assign.pending_time) NOT IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="= ''"){
            $sql=" AND DATE(user_lender_assign.pending_time) =''";
        }elseif($operator=="!= ''"){
            $sql=" AND DATE(user_lender_assign.pending_time) !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND DATE(user_lender_assign.pending_time) IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND DATE(user_lender_assign.pending_time) IS NOT NULL";
        }
        return $sql;
    }
    public function approved_response($operator,$fieldvalue){
        $sql="";
        if($operator=='BETWEEN'){
            $exp=explode(' - ',$fieldvalue);
            $sql=" AND ( DATE(user_lender_assign.approved_time) >= '".date('Y-m-d',strtotime($exp[0]))."' AND DATE(user_lender_assign.approved_time) <='".date('Y-m-d',strtotime(end($exp)))."')";
        }elseif($operator=="=" && $fieldvalue!=""){
            $sql=" AND DATE(user_lender_assign.approved_time) ='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator==">="){
            $sql=" AND DATE(user_lender_assign.approved_time) >='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="<="){
            $sql=" AND DATE(user_lender_assign.approved_time) <='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND DATE(user_lender_assign.approved_time) LIKE '".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND DATE(user_lender_assign.approved_time) LIKE '%".date('Y-m-d',strtotime($fieldvalue))."%'";
        }elseif($operator=="IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(user_lender_assign.approved_time) IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="NOT IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(user_lender_assign.approved_time) NOT IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="= ''"){
            $sql=" AND DATE(user_lender_assign.approved_time) =''";
        }elseif($operator=="!= ''"){
            $sql=" AND DATE(user_lender_assign.approved_time) !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND DATE(user_lender_assign.approved_time) IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND DATE(user_lender_assign.approved_time) IS NOT NULL";
        }
        return $sql;
    }

    public function reject_response($operator,$fieldvalue){
        $sql="";
        if($operator=='BETWEEN'){
            $exp=explode(' - ',$fieldvalue);
            $sql=" AND ( DATE(user_lender_assign.reject_time) >= '".date('Y-m-d',strtotime($exp[0]))."' AND DATE(user_lender_assign.reject_time) <='".date('Y-m-d',strtotime(end($exp)))."')";
        }elseif($operator=="=" && $fieldvalue!=""){
            $sql=" AND DATE(user_lender_assign.reject_time) ='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator==">="){
            $sql=" AND DATE(user_lender_assign.reject_time) >='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="<="){
            $sql=" AND DATE(user_lender_assign.reject_time) <='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND DATE(user_lender_assign.reject_time) LIKE '".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND DATE(user_lender_assign.reject_time) LIKE '%".date('Y-m-d',strtotime($fieldvalue))."%'";
        }elseif($operator=="IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(user_lender_assign.reject_time) IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="NOT IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(user_lender_assign.reject_time) NOT IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="= ''"){
            $sql=" AND DATE(user_lender_assign.reject_time) =''";
        }elseif($operator=="!= ''"){
            $sql=" AND DATE(user_lender_assign.reject_time) !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND DATE(user_lender_assign.reject_time) IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND DATE(user_lender_assign.reject_time) IS NOT NULL";
        }
        return $sql;
    }

    public function disbursed_response($operator,$fieldvalue){
        $sql="";
        if($operator=='BETWEEN'){
            $exp=explode(' - ',$fieldvalue);
            $sql=" AND ( DATE(user_lender_assign.disbursed_time) >= '".date('Y-m-d',strtotime($exp[0]))."' AND DATE(user_lender_assign.disbursed_time) <='".date('Y-m-d',strtotime(end($exp)))."')";
        }elseif($operator=="=" && $fieldvalue!=""){
            $sql=" AND DATE(user_lender_assign.disbursed_time) ='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator==">="){
            $sql=" AND DATE(user_lender_assign.disbursed_time) >='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="<="){
            $sql=" AND DATE(user_lender_assign.disbursed_time) <='".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND DATE(user_lender_assign.disbursed_time) LIKE '".date('Y-m-d',strtotime($fieldvalue))."'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND DATE(user_lender_assign.disbursed_time) LIKE '%".date('Y-m-d',strtotime($fieldvalue))."%'";
        }elseif($operator=="IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(user_lender_assign.disbursed_time) IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="NOT IN(...)"){
            $datein=explode('_&%',str_replace(array(',',' ',' , ',' - ','-'),'_&%',$fieldvalue));
            $datearray=[];
            foreach($datein as $string){
                if(date('Y-m-d',strtotime($string))!='1970-01-01'){
                    $datearray[]=date('Y-m-d',strtotime($string));
                }
            }
            if(!empty($datearray)){
                $sql=" AND DATE(user_lender_assign.disbursed_time) NOT IN('".implode("','",$datearray)."')";
            }
        }elseif($operator=="= ''"){
            $sql=" AND DATE(user_lender_assign.disbursed_time) =''";
        }elseif($operator=="!= ''"){
            $sql=" AND DATE(user_lender_assign.disbursed_time) !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND DATE(user_lender_assign.disbursed_time) IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND DATE(user_lender_assign.disbursed_time) IS NOT NULL";
        }
        return $sql;
    }
    public function city_response($operator,$fieldvalue){
        $sql="";
        if($operator=="=" && $fieldvalue!=""){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.city,user_detail.residence_city) ='$fieldvalue'";
        }elseif($operator=="LIKE"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.city,user_detail.residence_city) LIKE '$fieldvalue'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.city,user_detail.residence_city) LIKE '%$fieldvalue%'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.city,user_detail.residence_city) NOT LIKE '$fieldvalue'";
        }elseif($operator=="IN(...)"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.city,user_detail.residence_city) IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="NOT IN(...)"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.city,user_detail.residence_city) NOT IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="= ''"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.city,user_detail.residence_city) =''";
        }elseif($operator=="!= ''"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.city,user_detail.residence_city) !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.city,user_detail.residence_city) IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.city,user_detail.residence_city) IS NOT NULL";
        }
        return $sql;
    }
    public function pincode_response($operator,$fieldvalue){
        $sql="";
        if($operator=="=" && $fieldvalue!=""){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.pincode,user_detail.residence_pincode) ='$fieldvalue'";
        }elseif($operator=="LIKE"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.pincode,user_detail.residence_pincode) LIKE '$fieldvalue'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.pincode,user_detail.residence_pincode) LIKE '%$fieldvalue%'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.pincode,user_detail.residence_pincode) NOT LIKE '$fieldvalue'";
        }elseif($operator=="IN(...)"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.pincode,user_detail.residence_pincode) IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="NOT IN(...)"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.pincode,user_detail.residence_pincode) NOT IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="= ''"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.pincode,user_detail.residence_pincode) =''";
        }elseif($operator=="!= ''"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.pincode,user_detail.residence_pincode) !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.pincode,user_detail.residence_pincode) IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.pincode,user_detail.residence_pincode) IS NOT NULL";
        }
        return $sql;
    }
    public function state_response($operator,$fieldvalue){
        $sql="";
        if($operator=="=" && $fieldvalue!=""){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.state,user_detail.residence_state) ='$fieldvalue'";
        }elseif($operator=="LIKE"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.state,user_detail.residence_state) LIKE '$fieldvalue'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.state,user_detail.residence_state) LIKE '%$fieldvalue%'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.state,user_detail.residence_state) NOT LIKE '$fieldvalue'";
        }elseif($operator=="IN(...)"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.state,user_detail.residence_state) IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="NOT IN(...)"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.state,user_detail.residence_state) NOT IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="= ''"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.state,user_detail.residence_state) =''";
        }elseif($operator=="!= ''"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.state,user_detail.residence_state) !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.state,user_detail.residence_state) IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND IF(users.loan_type='Business',user_merchant_detail.state,user_detail.residence_state) IS NOT NULL";
        }
        return $sql;
    }
    public function fathername_response($operator,$fieldvalue){
        $sql="";
        if($operator=="=" && $fieldvalue!=""){
            $sql=" AND user_detail.father_name ='$fieldvalue'";
        }elseif($operator=="LIKE"){
            $sql=" AND user_detail.father_name LIKE '$fieldvalue'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND user_detail.father_name LIKE '%$fieldvalue%'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND user_detail.father_name NOT LIKE '$fieldvalue'";
        }elseif($operator=="IN(...)"){
            $sql=" AND user_detail.father_name IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="NOT IN(...)"){
            $sql=" AND user_detail.father_name NOT IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="= ''"){
            $sql=" AND user_detail.father_name =''";
        }elseif($operator=="!= ''"){
            $sql=" AND user_detail.father_name !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND user_detail.father_name IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND user_detail.father_name IS NOT NULL";
        }
        return $sql;
    }
    public function qualification_response($operator,$fieldvalue){
        $sql="";
        if($operator=="=" && $fieldvalue!=""){
            $sql=" AND user_detail.qualification ='$fieldvalue'";
        }elseif($operator=="LIKE"){
            $sql=" AND user_detail.qualification LIKE '$fieldvalue'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND user_detail.qualification LIKE '%$fieldvalue%'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND user_detail.qualification NOT LIKE '$fieldvalue'";
        }elseif($operator=="IN(...)"){
            $sql=" AND user_detail.qualification IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="NOT IN(...)"){
            $sql=" AND user_detail.qualification NOT IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="= ''"){
            $sql=" AND user_detail.qualification =''";
        }elseif($operator=="!= ''"){
            $sql=" AND user_detail.qualification !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND user_detail.qualification IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND user_detail.qualification IS NOT NULL";
        }
        return $sql;
    }

    public function marital_status_response($operator,$fieldvalue){
        $sql="";
        if($operator=="=" && $fieldvalue!=""){
            $sql=" AND user_detail.marital_status ='$fieldvalue'";
        }elseif($operator=="LIKE"){
            $sql=" AND user_detail.marital_status LIKE '$fieldvalue'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND user_detail.marital_status LIKE '%$fieldvalue%'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND user_detail.marital_status NOT LIKE '$fieldvalue'";
        }elseif($operator=="IN(...)"){
            $sql=" AND user_detail.marital_status IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="NOT IN(...)"){
            $sql=" AND user_detail.marital_status NOT IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="= ''"){
            $sql=" AND user_detail.marital_status =''";
        }elseif($operator=="!= ''"){
            $sql=" AND user_detail.marital_status !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND user_detail.marital_status IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND user_detail.marital_status IS NOT NULL";
        }
        return $sql;
    }
    public function employer_name_response($operator,$fieldvalue){
        $sql="";
        if($operator=="=" && $fieldvalue!=""){
            $sql=" AND user_detail.employer_name ='$fieldvalue'";
        }elseif($operator=="LIKE"){
            $sql=" AND user_detail.employer_name LIKE '$fieldvalue'";
        }elseif($operator=="LIKE %...%"){
            $sql=" AND user_detail.employer_name LIKE '%$fieldvalue%'";
        }elseif($operator=="NOT LIKE"){
            $sql=" AND user_detail.employer_name NOT LIKE '$fieldvalue'";
        }elseif($operator=="IN(...)"){
            $sql=" AND user_detail.employer_name IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="NOT IN(...)"){
            $sql=" AND user_detail.employer_name NOT IN('".implode("','",explode(',',$fieldvalue))."')";
        }elseif($operator=="= ''"){
            $sql=" AND user_detail.employer_name =''";
        }elseif($operator=="!= ''"){
            $sql=" AND user_detail.employer_name !=''";
        }elseif($operator=="IS NULL"){
            $sql=" AND user_detail.employer_name IS NULL";
        }elseif($operator=="IS NOT NULL"){
            $sql=" AND user_detail.employer_name IS NOT NULL";
        }
        return $sql;
    }
    private function status_response($operator,$type){
        $sql="";
        if($type=='SHORTCLOSE'){
			$sql =" AND ".TBL_LENDER_ASSIGN.".status = 'SHORTCLOSE'";
		}elseif($type=='incomplete'){
			$sql =" AND ".TBL_USERS.".status = 'INCOMPLETE' AND NOT EXISTS (SELECT * FROM user_lender_assign WHERE user_lender_assign.merchant_id=".TBL_USERS.'.user_id)';
		}elseif($type=='received'){
			$sql =" AND ".TBL_USERS.".status IS NULL AND NOT EXISTS (SELECT * FROM user_lender_assign WHERE user_lender_assign.merchant_id=".TBL_USERS.'.user_id)';
		}elseif($type=='assigned'){
            $sql =" AND ".TBL_USERS.".status = 'ASSIGNED'";
		}elseif($type=='logged'){
            $sql =" AND ".TBL_LENDER_ASSIGN.".status = 'LOGGED'";
		}elseif($type=='pending'){
            $sql =" AND ".TBL_LENDER_ASSIGN.".status = 'PENDING'";
		}elseif($type=='approved'){
            $sql =" AND ".TBL_LENDER_ASSIGN.".status = 'APPROVED'";
		}elseif($type=='rejected'){
			$sql =" AND ".TBL_LENDER_ASSIGN.".status = 'REJECTED'";
		}elseif($type=='disbursed'){
			$sql =" AND ".TBL_LENDER_ASSIGN.".status = 'DISBURSED'";
        }
        return $sql;
    } 
    private function orderby_response($operator,$type){
        return " ORDER BY ".$type." ".$operator;
    }

    public function downloads(){
        $this->load->library('PHPExcel');
        $this->load->library('zip');
        $data= (object)$this->input->get();
        $businessrecord=[];
        $salariedrecord=[];
        if($data->users_loan_type=='Business'){
            $query = $this->select($data,'Business');
            $businessrecord =$this->query_builder_model->GetRecord($query);
        }elseif($data->users_loan_type=='Salaried'){
            $query = $this->select($data,'Salaried');
            $salariedrecord =$this->query_builder_model->GetRecord($query);
        }else{
            $data->users_loan_type='Business';
            $query = $this->select($data,'Business');
            $businessrecord =$this->query_builder_model->GetRecord($query);

            $data->users_loan_type='Salaried';
            $query = $this->select($data,'Salaried');
            $salariedrecord =$this->query_builder_model->GetRecord($query);
        }
        if(!empty($businessrecord)){
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
            //$objPHPExcel->getActiveSheet()->SetCellValue('AO' . 1, 'Lender Detail');
            
            $rowCount = 2;
            foreach ($businessrecord as $row)
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
                //$objPHPExcel->getActiveSheet()->SetCellValue('AO' .$rowCount,$row->lender_file_id.' - '.$row->lender_companyname);
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
        if(!empty($salariedrecord)){
            
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
            //$objPHPExcel->getActiveSheet()->SetCellValue('AT' . 1, 'Lender Detail');
            

            $rowCount = 2;
            foreach ($salariedrecord as $row)
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

                //$objPHPExcel->getActiveSheet()->SetCellValue('AT' .$rowCount,$row->lender_file_id.' - '.$row->lender_companyname);
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