<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loginlog extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->output->delete_cache();
        $this->load->model(['super-admin/loginlog_model']);
        $this->load->helper('admin');
        isAdminLogin();
        if(!MainPermission(8)){
			redirect_admin('dashboard');
		}
    }
    public function index(){
        $this->common_model->UpdateData('login_log',['is_read'=>1],['is_read'=>0]);
        $per_page=50;
        $search=$keyword="";
        $keyword=$this->input->get('keyword');
        $date_range=$this->input->get('date_range');
        if($this->input->server('REQUEST_METHOD')=='GET'){
            $search="?date_range=".$this->input->get('date_range');
            if(!empty($keyword)){
                $search.='&keyword='.$keyword;
            }
        }
		$config=GetPagination($per_page);
		$config['base_url'] = admin_url("loginlog".$search);	
		$config['total_rows'] = $this->loginlog_model->CountLoginLog($date_range);
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		$this->data['pagination']=$this->pagination->create_links();
		$page=$this->input->get('page');
		if($page > 1){
			$page=($page-1)*$config["per_page"];
		}else{
			$page=0;
		}
		$this->data['results']=$this->loginlog_model->LoginLog($config['per_page'],$page,$date_range);
        $this->data['content']="loginlog/index";
       // $this->data['script']="loginlog/script";
        $this->load->view('super-admin',$this->data);
    }
    public function ExportLog(){
        $record=$this->loginlog_model->GetLog();
        $this->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Support");
		$objPHPExcel->getProperties()->setTitle('Loan Applicant');
		$objPHPExcel->getActiveSheet()->getStyle('A1:U1')->getFont()->setBold(true);
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A' . 1, 'File ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B' . 1, 'Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('C' . 1, 'Company Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('D' . 1, 'Login IP');
		$objPHPExcel->getActiveSheet()->SetCellValue('E' . 1, 'Login Time');
        $rowCount = 2;
		//echo "<pre>";print_r($data);die;
		foreach ($record as $row)
		{
			$objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $row->file_id);
			$objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $row->full_name);
			$objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $row->company_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $row->ip_address);
            $time=date('d M Y h:i A',strtotime($row->login_time));
			$objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $time);
            $rowCount++;
        }
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;Filename=Login Log.xls");
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');  
    }
}