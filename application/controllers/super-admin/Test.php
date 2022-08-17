<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
    }
    public function import(){
        $case_data = [];
		if ($this->input->server('REQUEST_METHOD') == "POST") {
			$this->load->library('PHPExcel');
			if (!empty($_FILES['csvexcel']['name'])) {
				$extension = pathinfo($_FILES['csvexcel']['name'], PATHINFO_EXTENSION);
				$_FILES['csvexcel']['name'] = "ExcelImport." . $extension;
				$config['upload_path']          = 'uploads';
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
                    $total_import_case=0;
                    $unimportCase=[];
					if(!empty($case_data)){
                        foreach($case_data as $case){
                            $setdata=[];
                            $email = $this->common_model->GetRow(TBL_USERS,['email'=>$case['I'],'status'=>null]);
                            $number = $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$case['J']]);
                            if(empty($email)  && empty($number)){
                                $lastsubfileid=1;
                                $lastMerchant=$this->common_model->GetOrderByRow(TBL_USERS,['user_id','DESC'],['user_type'=>'MERCHANT']);
                                if($lastMerchant){
                                    $lastsubfileid = $lastMerchant->sub_id+1;
                                }
                                $setdata['sub_id']=$lastsubfileid;
                                $setdata['status']='INCOMPLETE';
                                $setdata['user_type']='MERCHANT';
                                $setdata['file_id']='FTM'.sprintf('%07u', $lastsubfileid);
                                $setdata['full_name']=$case['C'];
                                $setdata['email']=$case['I'];
                                $setdata['mobile_number']=$case['J'];
                                $setdata['loan_type']='Business';
                                $setdata['company_name']=$case['E'];
                                $setdata['age']=$case['L'];
                                $setdata['created_by']=29;
                                $setdata['created_at']=date('Y-m-d H:i:s');
                                $setdata['updated_at']=date('Y-m-d H:i:s');
                                if($insertId = $this->common_model->InsertData(TBL_USERS,$setdata)){
                                    $setdata2=[];
                                    $setdata2['user_id']=$insertId;
                                    $setdata2['desired_amount']=$case['D'];
                                    $setdata2['vintage']=$case['F'];
                                    $setdata2['turn_over']=$case['G'];
                                    $setdata2['state']=$case['K'];
                                    $setdata2['city']=$case['H'];
                                    $setdata2['pincode']=$case['M'];
                                    $setdata2['pan_number']=$case['N'];
                                    $this->common_model->InsertData(TBL_USER_DETAIL,$setdata2);
                                }
                            }else{
                                if(!empty($number)){
                                    $unimportCase[]=$case['C'].' '.$number->mobile_number;
                                }else{
                                    $unimportCase[]=$case['C'].' '.$email->email;
                                }

                            }
                        }
                        $return =[];
                        $return['import_case']=$total_import_case;
                        $return['unimportCase']=$unimportCase;
                        return response(['status'=>'success','message'=>'Excel Import Successful','data'=>$return]);
                    }else{
                        return response(['status'=>'fail','message'=>'The Excel file is empty']);
                    }					
				} else {
                    return response(['status'=>'fail','message'=>'The Excel file must only xlsx file']);
				}
			} else {
				return response(['status'=>'fail','message'=>'The Excel File is Required']);
			}
        }
        $this->load->view('import_case');
    }
    public function changestatus(){
        /* $this->load->library('PHPExcel');
        $file_path =  '/var/www/html/testing/uploads/Rajat_Short close.xlsx';
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
        $total_import_case=0;
        
        if(!empty($case_data)){
            foreach($case_data as $case){
                $userdata = $this->common_model->GetRow(TBL_USERS,['mobile_number'=>$case['C'],'status'=>null]);
                if(!empty($userdata)){
                    $total_import_case+=1;
                    $setdata['status']='SHORTCLOSE';
                    $setdata['notification']='case is rejected because there were no documents.';
                    $setdata['dsa_id']=$userdata->created_by;
                    $setdata['merchant_id']=$userdata->user_id;
                    $setdata['updated_at']=date('Y-m-d H:i:s');
                    $setdata['created_at']=date('Y-m-d H:i:s');
                    $this->common_model->InsertData('user_lender_assign',$setdata);
                    $this->common_model->UpdateData(TBL_USERS,['short_close_time'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],['user_id'=>$userdata->user_id]);
                 
                }  
            }
            echo "<pre>"; print_r($total_import_case);die;
            return response(['status'=>'success','message'=>'Excel Import Successful']);
        }else{
            return response(['status'=>'fail','message'=>'The Excel file is empty']);
        } */
        
    }
}