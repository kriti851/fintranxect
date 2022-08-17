<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Basic extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
        $this->load->model(['super-admin/merchant_model']);
        $this->load->helper('admin');
        isAdminLogin();
    }
    /* public function pl(){
        $this->load->library('PHPExcel');
        $case_data = [];
        $first_data = [];
        $file_path =  '/var/www/html/testing/uploads/Fintranxect PL 14th Oct.xlsx';
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
        $importCase=0;
        if(!empty($case_data)){
            foreach($case_data as $case){
                if(!empty($case['H'])){
                    $email=$this->common_model->GetRow(TBL_USERS,['email'=>trim($case['G']),'status'=>null],'user_id');
                    if($email){
                        $unimportCase[]=$case['G'].' already exists';
                    }else{
                        $mobile_number=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>trim($case['H'])]);
                        if($mobile_number){
                            $unimportCase[]=$case['H'].' already exists';
                        }else{
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
                            $setdata['mobile_number']=$case['H'];
                            $setdata['email']=$case['G'];
                            $setdata['loan_type']='Salaried';
                            $setdata['created_by']=5;

                            $setdata['created_at']=date('Y-m-d H:i:s');
                            $setdata['updated_at']=date('Y-m-d H:i:s');
                            if($insertId=$this->common_model->InsertData(TBL_USERS,$setdata)){
                                $setdata1=[];
                                $setdata1['user_id']=$insertId;
                                if(!empty($case['J'])){
                                    $setdata1['date_of_birth']=$case['J'];
                                }
                                if(!empty($case['D'])){
                                    $setdata1['employer_name']=$case['D'];
                                }
                                if(!empty($case['C'])){
                                    $setdata1['organization_type']=$case['C'];
                                }
                                if(!empty($case['E'])){
                                    $setdata1['salery_inhand']=$case['E'];
                                }
                                if(!empty($case['F'])){
                                    $setdata1['residence_city']=$case['F'];
                                }
                                
                                if(!empty($case['K'])){
                                    $setdata1['residence_pincode']=$case['K'];
                                }
                                if(!empty($case['I'])){
                                    $setdata1['residence_state']=$case['I'];
                                }
                                if(!empty($case['L'])){
                                    $setdata1['pan_number']=$case['L'];
                                }
                                
                                $this->common_model->InsertData('user_detail',$setdata1);
                            }
                        }
                    }
                }
            }
            
        }else{
            $this->data['message_error']='Excel Is Empty';
        }
        print_r($this->data);die;
    }
    public function bl(){
        $this->load->library('PHPExcel');
        $file_path =  '/var/www/html/testing/uploads/Fintranxect BL 14th Oct.xlsx';
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
        if(!empty($case_data)){
            foreach($case_data as $case){
                if(!empty($case['H'])){
                    $email=$this->common_model->GetRow(TBL_USERS,['email'=>trim($case['G']),'status'=>null],'user_id');
                    if($email){
                       
                    }else{
                        $mobile_number=$this->common_model->GetRow(TBL_USERS,['mobile_number'=>trim($case['B'])]);
                        if($mobile_number){
                        }else{
                            $update=true;
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
                            $setdata['mobile_number']=$case['H'];
                            $setdata['email']=$case['G'];
                            $setdata['company_name']=$case['C'];
                            $setdata['age']=$case['J'];
                            $setdata['loan_type']='Business';
                            $setdata['created_by']=5;
                            $setdata['created_at']=date('Y-m-d H:i:s');
                            $setdata['updated_at']=date('Y-m-d H:i:s');
                            if($insertId=$this->common_model->InsertData(TBL_USERS,$setdata)){
                                $setdata1=[];
                                $setdata1['user_id']=$insertId;
                              
                                if(!empty($case['F'])){
                                    $setdata1['city']=$case['F'];
                                }
                                if(!empty($case['K'])){
                                    $setdata1['pincode']=$case['K'];
                                }
                                if(!empty($case['I'])){
                                    $setdata1['state']=$case['I'];
                                }
                                
                                if(!empty($case['E'])){
                                    $setdata1['turn_over']=$case['E'];
                                }
                              
                                if(!empty($case['B'])){
                                    $setdata1['desired_amount']=$case['B'];
                                }
                                if(!empty($case['L'])){
                                    $setdata1['pan_number']=$case['L'];
                                }
                               
                                $this->common_model->InsertData(TBL_USER_DETAIL,$setdata1);
                            }
                        }
                    }
                }
            }
            
        }else{
            $this->data['message_error']='Excel Is Empty';
        }
        print_r($this->data);die;
    } */
}