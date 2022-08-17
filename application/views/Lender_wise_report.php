<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lender_wise_report extends CI_Controller {
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
        $status=$this->input->post('status');
        $data = $this->excel_model->MerchantLinderWiseList($this->input->post());    
        $objPHPExcel->getProperties()->setCreator("Support");
        $objPHPExcel->getProperties()->setTitle('Loan Applicant');
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . 1, 'Lender Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . 1, 'FTM ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . 1, 'Merchant Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . 1, 'City');
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . 1, 'Mobile Number');
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . 1, 'Created Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . 1, 'Created Month');
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . 1, 'Logged Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . 1, 'Logged Month');
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . 1, 'Current Status');
        $objPHPExcel->getActiveSheet()->SetCellValue('K' . 1, 'Current Status Date');
        $objPHPExcel->getActiveSheet()->SetCellValue('L' . 1, 'Current Status Month');
        $objPHPExcel->getActiveSheet()->SetCellValue('M' . 1, 'Latest Comment');
        $objPHPExcel->getActiveSheet()->SetCellValue('N' . 1, 'Latest Remark');      

        $rowCount = 2;
        foreach ($data as $row)
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' .$rowCount,$row->lender_companyname);
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
            $objPHPExcel->getActiveSheet()->SetCellValue('H' .$rowCount,date('d-m-Y',strtotime($row->logged_time)));
            $objPHPExcel->getActiveSheet()->SetCellValue('I' .$rowCount,date('F',strtotime($row->logged_time)));
            $currentstatus='';
            if(!empty($row->lender_status)){
                $currentstatus=$row->lender_status;
            }elseif(!empty($row->status) && $row->status=='INCOMPLETE'){
                $currentstatus='INCOMPLETE';
            }else{
                $currentstatus='RECEIVED';
            }
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $currentstatus);
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

            $objPHPExcel->getActiveSheet()->SetCellValue('K' .$rowCount,date('d-m-Y',strtotime($statustime)));
            $objPHPExcel->getActiveSheet()->SetCellValue('L' .$rowCount,date('F',strtotime($statustime)));
            $remark = $this->common_model->GetOrderByRow('remark',['remark_id','DESC'],['merchant_id'=>$row->user_id]);
            if(!empty($remark)){
                $objPHPExcel->getActiveSheet()->SetCellValue('M' .$rowCount,trim($remark->comments));
            }
            $comments = $this->common_model->GetOrderByRow('comments',['comment_id','DESC'],['merchant_id'=>$row->user_id]);
            if(!empty($comments)){
                $objPHPExcel->getActiveSheet()->SetCellValue('N' .$rowCount,trim($comments->comment));
            }
            $rowCount++;
        }
        
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;Filename=Lender-Wise-Report.xls");
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');   
    }
}