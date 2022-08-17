<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partner_wise_report extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
        $this->load->model(['super-admin/excel_model']);
        $this->load->helper('admin');
        isAdminLogin();
    }
    public function index(){
        $this->load->library('PHPExcel');
        $objPHPExcel = new PHPExcel();
        $filter_type=$this->input->post('filter_type');
        $status=$this->input->post('status');
        $data = $this->excel_model->MerchantPartnerWiseList($this->input->post());
        $fieldstatus='';
        if($status=='all' || $status=='incomlplete'){
            $fieldstatus='Created';
        }else{
            $fieldstatus=ucfirst($status);
        }
        $objPHPExcel->getProperties()->setCreator("Support");
        $objPHPExcel->getProperties()->setTitle('Loan Applicant');
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . 1, 'Partner Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . 1, 'FTM ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . 1, 'Merchant Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . 1, 'City');
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . 1, 'Mobile Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . 1, 'Created Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . 1, 'Created Month');
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . 1, 'Received Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . 1, 'Received Month');
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . 1, 'Varience');
        $objPHPExcel->getActiveSheet()->SetCellValue('K' . 1, 'Current Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('L' . 1, 'Current Status Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('M' . 1, 'Current Status Month');
        $objPHPExcel->getActiveSheet()->SetCellValue('N' . 1, 'Latest Comment');
        $objPHPExcel->getActiveSheet()->SetCellValue('O' . 1, 'Latest Remark');   
        
        $rowCount = 2;
        foreach ($data as $row)
        {
            if(!empty($row->lender_status)){
                $currentstatus=$row->lender_status;
            }elseif(!empty($row->status) && $row->status=='INCOMPLETE'){
                $currentstatus='INCOMPLETE';
            }else{
                $currentstatus='RECEIVED';
            }
            if($currentstatus!="DISBURSED"){
                $objPHPExcel->getActiveSheet()->SetCellValue('A' .$rowCount,$row->dsa_name);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->file_id);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->full_name);
                if($row->loan_type=='Business'){
                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->city);
                }else{
                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->residence_city);
                }
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $row->mobile_number);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' .$rowCount,date('d-m-Y',strtotime($row->created_at)));
                $objPHPExcel->getActiveSheet()->SetCellValue('G' .$rowCount,date('F',strtotime($row->created_at)));
                $objPHPExcel->getActiveSheet()->SetCellValue('H' .$rowCount,date('d-m-Y',strtotime($row->received_time)));
                $objPHPExcel->getActiveSheet()->SetCellValue('I' .$rowCount,date('F',strtotime($row->received_time)));
                $date1=date_create(date('Y-m-d',strtotime($row->created_at)));
                $date2=date_create(date('Y-m-d',strtotime($row->received_time)));
                $diff=date_diff($date1,$date2);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, (int)$diff->format("%R%a"));
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $currentstatus);
                $currentstatus=strtolower($currentstatus);
                $statustime=date('Y-m-d');
                if($currentstatus=='incomplete'){
                $statustime=$row->created_at;
                }elseif($currentstatus=='received')
                    $statustime=$row->received_time;
                elseif($currentstatus=='shortclose')
                    $statustime=$row->short_close_time;
                elseif($currentstatus=='assigned')
                    $statustime=$row->assigned_time;
                elseif($currentstatus=='logged')
                    $statustime=$row->logged_time;
                elseif($currentstatus=='pending')
                    $statustime=$row->pending_time;
                elseif($currentstatus=='approved')
                    $statustime=$row->approved_time;
                elseif($currentstatus=='rejected')
                    $statustime=$row->reject_time;
                elseif($currentstatus=='disbursed')
                    $statustime=$row->disbursed_time;
            
                $objPHPExcel->getActiveSheet()->SetCellValue('L' .$rowCount,date('d-m-Y',strtotime($statustime)));
                $objPHPExcel->getActiveSheet()->SetCellValue('M' .$rowCount,date('F',strtotime($statustime)));

                $comments = $this->common_model->GetOrderByRow('comments',['comment_id','DESC'],['merchant_id'=>$row->user_id]);
                if(!empty($comments)){
                    $objPHPExcel->getActiveSheet()->SetCellValue('N' .$rowCount,trim($comments->comment));
                }
                $remark = $this->common_model->GetOrderByRow('remark',['remark_id','DESC'],['merchant_id'=>$row->user_id]);
                if(!empty($remark)){
                    $objPHPExcel->getActiveSheet()->SetCellValue('O' .$rowCount,trim($remark->comments));
                }
                $rowCount++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;Filename=Partner-Wise-Report.xls");
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');   
    }
}