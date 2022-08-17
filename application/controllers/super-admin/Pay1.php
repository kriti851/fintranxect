<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class Pay1 extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
        $this->load->model(['super-admin/pay1_model']);
        $this->load->helper('admin');
        isAdminLogin();
    }
    /* public function index(){
        $this->data['content']='pay1/index';
        $this->load->view('super-admin',$this->data);
    } */
    public function GetToken(){
        $url='https://loan.pragaticapital.in/sdk/tokens';
        $username=base64_encode("fintranxect:p@y1@f!n+r@nkey");
        $headers=['Authorization:Basic '.$username,'Content-type:application/json'];
        $response = $this->CallApi($url,$headers,[]);
        return json_decode($response,true);
    }
    private function GettxnData($token,$page_number){

    }
    public function DataApi(){
        $tResponse =  $this->GetToken();
        $token=$tResponse['api_token'];
        $url='https://loan.pragaticapital.in/sdk/get-transaction-data';
        $headers=['x-api-token:Basic '.$token,'Content-type:application/json'];
        $page_number=1;
        if($this->session->userdata('pay1_page_number')){
            $page_number=$this->session->userdata('pay1_page_number')+1;
            $this->session->set_userdata('pay1_page_number',$page_number);
        }
        $response= $this->CallApi($url,$headers,['page_number'=>$page_number]);
        $data[]=json_decode($response,true);
        /* echo "<pre>";
        print_r($data);die; */
        if(!empty($data) && $data[0]['status']=='success'){
            $this->load->library('PHPExcel');
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("Support");
            $objPHPExcel->getProperties()->setTitle('Loan Applicant');
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . 1, 'Pay1 User Id');
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . 1, 'Joined On');
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . 1, 'Pincode');
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . 1, 'Tenure In Days');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . 1, 'Processing Fee');
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . 1, 'Annual Interest Rate');
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . 1, 'Approved Amount');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . 1, 'Txn Summary ->');
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . 2, 'Count');
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . 2, 'Max Wallet Balance');
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . 2, 'Min Wallet Balance');
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . 2, 'Month');
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . 2, 'Volume');
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . 2, 'Total Days');
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . 2, 'Active Days');
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . 2, 'Year');
            $objPHPExcel->getActiveSheet()->SetCellValue('Q' . 2, 'Verticals ->');
            $objPHPExcel->getActiveSheet()->SetCellValue('R' . 3, 'Volume');
            $objPHPExcel->getActiveSheet()->SetCellValue('S' . 3, 'Service Count');
            $objPHPExcel->getActiveSheet()->SetCellValue('T' . 3, 'Count');
            $rowCount=4;
            if(!empty($data)){
                foreach($data as $result){
                    if(!empty($result['transactional_data'])){
                        foreach($result['transactional_data'] as $txndata){
                            $txndata=(object)$txndata;
                            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $txndata->user_id);
                            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $txndata->joined_on);
                            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $txndata->pincode);
                            foreach($txndata->transaction_summary as $summary){
                                $summary=(object)$summary;
                                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $summary->count);
                                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $summary->max_wallet_balance);
                                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $summary->min_wallet_balance);
                                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $summary->month);
                                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $summary->volume);
                                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $summary->total_days);
                                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $summary->active_days);
                                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $summary->year);
                                foreach($summary->verticals as $vertical){
                                    $vertical=(object)$vertical;
                                    $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $vertical->volume);
                                    $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $vertical->service_name);
                                    $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $vertical->count);
                                    $rowCount+=1;
                                }
                                $rowCount+=1;
                            }
                            $rowCount+=1;
                        }
                    }
                    header('Content-Type: application/vnd.ms-excel');
                    header("Content-Disposition: attachment;Filename=Download.xls");
                    header('Cache-Control: max-age=0');
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                    $objWriter->save('php://output');
                }
            }
        }
    }

    public function updateapidatabase($page_number=1)
    {
        $result=$this->db->get_where("apidata",['page_number'=>$page_number]);
        if ($result->num_rows() > 0) 
        {
            $page_number=$page_number+1;
            if ($page_number <= 481) {
               // redirect("https://testing.fintranxect.com/super-admin/pay1/updatedatabase/".$page_number);
               ?>
               <a href="https://testing.fintranxect.com/super-admin/pay1/updateapidatabase/<?php echo $page_number ?>">Next Page</a>
               <?php
            }

        }else
        {
            $tResponse =  $this->GetToken();
            $token=$tResponse['api_token'];
            $url='https://loan.pragaticapital.in/sdk/get-transaction-data';
            $headers=['x-api-token:Basic '.$token,'Content-type:application/json'];
        
            $response= $this->CallApi($url, $headers, ['page_number'=>$page_number]);

            $savedata['data']= $response;
            $savedata['page_number']= $page_number;
            $this->db->insert("apidata", $savedata);
            $page_number=$page_number+1;
            if ($page_number <= 481) {
                //redirect("https://testing.fintranxect.com/super-admin/pay1/updatedatabase/".$page_number);

                ?>
                <a href="https://testing.fintranxect.com/super-admin/pay1/updateapidatabase/<?php echo $page_number ?>">Next Page</a>
                <?php
            }
        }
       
    }
    public function datadownload()
    {
        /* $data=[];
        $result=$this->db->select('*')->from("apidata")->limit(500,400)->get()->result();
        foreach ($result as $response) {
            $data[]=json_decode($response->data, true);
        }
        $result="";
            
            if (!empty($data)) {
                $this->load->library('PHPExcel');
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()->setCreator("Support");
                $objPHPExcel->getProperties()->setTitle('Loan Applicant');
                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . 1, 'Pay1 User Id');
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . 1, 'Joined On');
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . 1, 'Pincode');
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . 1, 'Tenure In Days');
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . 1, 'Processing Fee');
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . 1, 'Annual Interest Rate');
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . 1, 'Approved Amount');
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . 1, 'Txn Summary ->');
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . 2, 'Count');
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . 2, 'Max Wallet Balance');
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . 2, 'Min Wallet Balance');
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . 2, 'Month');
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . 2, 'Volume');
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . 2, 'Total Days');
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . 2, 'Active Days');
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . 2, 'Year');
                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . 2, 'Verticals ->');
                $objPHPExcel->getActiveSheet()->SetCellValue('R' . 3, 'Volume');
                $objPHPExcel->getActiveSheet()->SetCellValue('S' . 3, 'Service Count');
                $objPHPExcel->getActiveSheet()->SetCellValue('T' . 3, 'Count');
                $rowCount=4;
                if (!empty($data)) {
                    foreach($data as $result) {
                        if(!empty($result['transactional_data'])) {
                            foreach ($result['transactional_data'] as $txndata) {
                                $txndata=(object)$txndata;
                                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $txndata->user_id);
                                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $txndata->joined_on);
                                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $txndata->pincode);
                                $loop1=$rowCount;
                                foreach ($txndata->transaction_summary as $summary) {
                                    $summary=(object)$summary;
                                    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $loop1, $summary->count);
                                    $objPHPExcel->getActiveSheet()->SetCellValue('J' . $loop1, $summary->max_wallet_balance);
                                    $objPHPExcel->getActiveSheet()->SetCellValue('K' . $loop1, $summary->min_wallet_balance);
                                    $objPHPExcel->getActiveSheet()->SetCellValue('L' . $loop1, $summary->month);
                                    $objPHPExcel->getActiveSheet()->SetCellValue('M' . $loop1, $summary->volume);
                                    $objPHPExcel->getActiveSheet()->SetCellValue('N' . $loop1, $summary->total_days);
                                    $objPHPExcel->getActiveSheet()->SetCellValue('O' . $loop1, $summary->active_days);
                                    $objPHPExcel->getActiveSheet()->SetCellValue('P' . $loop1, $summary->year);
                                    $loop2=$loop1;
                                    foreach ($summary->verticals as $vertical) {
                                        $vertical=(object)$vertical;
                                        $objPHPExcel->getActiveSheet()->SetCellValue('R' . $loop2, $vertical->volume);
                                        $objPHPExcel->getActiveSheet()->SetCellValue('S' . $loop2, $vertical->service_name);
                                        $objPHPExcel->getActiveSheet()->SetCellValue('T' . $loop2, $vertical->count);
                                        $loop2+=1;
                                    }
                                    if($loop1<$loop2){
                                        $loop1=($loop2-1);
                                    }
                                    $loop1+=1;
                                }
                                if($rowCount<$loop1){
                                    $rowCount=($loop1-1);
                                }
                                $rowCount+=1;
                            }
                        }
                    }
                }
                $filename="fintranxect".date("Y-m-d-h-i-s-a");
                header('Content-Type: application/vnd.ms-excel');
                header("Content-Disposition: attachment;Filename=$filename.xls");
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
            } */
        
       
    }
    public function index(){
        if($this->input->server('REQUEST_METHOD')=='POST'){
            if(!empty($_FILES['excel']['name'])){
                $_FILES['excel']['name']=time().$_FILES['excel']['name'];
                $config['upload_path']          = 'uploads/pay1';
                $config['allowed_types']        = 'xlsx|csv|xls';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('excel'))
                {
                    $this->data['excel_error']= $this->upload->display_errors();
                }
                else
                {
                    $file =  $this->upload->data();
                    $this->load->library('PHPExcel');
                    $file_path = $file['full_path'];
                    $objPHPExcel = PHPExcel_IOFactory::load($file_path);
                    $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                    $data_value = array_filter($cell_collection);
                    $data=[];
                    foreach ($cell_collection as $cell) {
                        $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                        $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                        $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                        if ($row >3) {
                            $data[$row][$column] = $data_value;
                        }
                    }
                    $setdata=[];
                    $pay1=[];
                    if(!empty($data)){
                        $key=1;
                        $step0=0;
                        $step1=0;
                        $step2=0;
                        $t=0;
                        foreach($data as $row){
                            if(!empty($row['A'])){
                                if($t>1){
                                    $step0++;
                                }
                                $t=0;
                                $step1=0;
                                $step2=0;
                                $lastkey=$key;
                                $setdata[$step0]=[
                                    'user_id'=>(isset($row['A']))?$row['A']:'',
                                    'joined_on'=>(isset($row['B']))?$row['B']:'',
                                    'pincode'=>(isset($row['C']))?$row['C']:'',
                                    'tenure_in_days'=>(isset($row['D']))?$row['D']:'',
                                    'processing_fees'=>(isset($row['E']))?$row['E']:'',
                                    'annual_interest_rate'=>(isset($row['F']))?$row['F']:'',
                                    'approved_amount'=>(isset($row['G']))?$row['G']:''
                                ];
                                $pay1[]=[
                                    'user_id'=>(isset($row['A']))?$row['A']:'',
                                    'tenure_in_days'=>(isset($row['D']))?$row['D']:'',
                                    'processing_fee'=>(isset($row['E']))?$row['E'].'%':'',
                                    'annual_interest_rate'=>(isset($row['F']))?$row['F'].'%':'',
                                    'approved_amount'=>(isset($row['G']))?$row['G']:''
                                ];
                                $setdata[$step0]['txn_data'][$step1]=[
                                    'count'=>(isset($row['I']))?$row['I']:'',
                                    'max_wallet_balance'=>(isset($row['J']))?$row['J']:'',
                                    'min_wallet_balance'=>(isset($row['K']))?$row['K']:'',
                                    'month'=>(isset($row['L']))?$row['L']:'',
                                    'volume'=>(isset($row['M']))?$row['M']:'',
                                    'total_days'=>(isset($row['N']))?$row['N']:'',
                                    'active_days'=>(isset($row['O']))?$row['O']:'',
                                    'year'=>(isset($row['P']))?$row['P']:''
                                ];
                                $setdata[$step0]['txn_data'][$step1]['vertical'][$step2]=[
                                    'volume'=>(isset($row['R']))?$row['R']:'',
                                    'service_name'=>(isset($row['S']))?$row['S']:'',
                                    'count'=>(isset($row['T']))?$row['T']:''
                                ];
                            }elseif(!empty($row['I'])){
                                $step1++;
                                $setdata[$step0]['txn_data'][$step1]=[
                                    'count'=>(isset($row['I']))?$row['I']:'',
                                    'max_wallet_balance'=>(isset($row['J']))?$row['J']:'',
                                    'min_wallet_balance'=>(isset($row['K']))?$row['K']:'',
                                    'month'=>(isset($row['L']))?$row['L']:'',
                                    'volume'=>(isset($row['M']))?$row['M']:'',
                                    'total_days'=>(isset($row['N']))?$row['N']:'',
                                    'active_days'=>(isset($row['O']))?$row['O']:'',
                                    'year'=>(isset($row['P']))?$row['P']:''
                                ];
                                if(!empty($row['R'])){
                                    $step2++;
                                    $setdata[$step0]['txn_data'][$step1]['vertical'][$step2]=[
                                        'volume'=>(isset($row['R']))?$row['R']:'',
                                        'service_name'=>(isset($row['S']))?$row['S']:'',
                                        'count'=>(isset($row['T']))?$row['T']:''
                                    ];
                                }
                            }elseif(!empty($row['R'])){
                                $step2++;
                                $setdata[$step0]['txn_data'][$step1]['vertical'][$step2]=[
                                    'volume'=>(isset($row['R']))?$row['R']:'',
                                    'service_name'=>(isset($row['S']))?$row['S']:'',
                                    'count'=>(isset($row['T']))?$row['T']:''
                                ];
                            }
                            $t++;
                            $key++;
                        }
                    }else{
                        $this->data['excel_error']= 'Excel is Empty';
                    }
                    if(!empty($setdata)){
                        $count =  count($setdata);
                        if($count<=50){
                            foreach($setdata as $set){
                                if(!empty($set['user_id'])){
                                    $record= $this->common_model->GetRow('pay1_data',['user_id'=>$set['user_id']]);
                                    if(empty($record)){
                                        $insertData=[
                                            'user_id'=>$set['user_id'],
                                            'joined_on'=>$set['joined_on'],
                                            'pincode'=>$set['pincode'],
                                            'tenure_in_days'=>$set['tenure_in_days'],
                                            'processing_fees'=>$set['processing_fees'],
                                            'annual_interest_rate'=>$set['annual_interest_rate'],
                                            'approved_amount'=>$set['approved_amount'],
                                            'txn_data'=>json_encode($set['txn_data'])
                                        ];
                                        $this->common_model->InsertData('pay1_data',$insertData);
                                    }else{
                                        $updatedata=[
                                            'user_id'=>$set['user_id'],
                                            'joined_on'=>$set['joined_on'],
                                            'pincode'=>$set['pincode'],
                                            'tenure_in_days'=>$set['tenure_in_days'],
                                            'processing_fees'=>$set['processing_fees'],
                                            'annual_interest_rate'=>$set['annual_interest_rate'],
                                            'approved_amount'=>$set['approved_amount'],
                                            'txn_data'=>json_encode($set['txn_data'])
                                        ];
                                        $this->common_model->UpdateData('pay1_data',$updatedata,['user_id'=>$record->user_id]);
                                    }
                                }
                            }
                            $tResponse = $this->GetToken();
                            if($tResponse['api_token']){
                                $token=$tResponse['api_token'];
                                $this->data['approvarResponse']=$this->PushApprovals($token,$pay1);
                                if(!empty($this->data['approvarResponse']['pre_apprvals_res'])){
                                    foreach($this->data['approvarResponse']['pre_apprvals_res'] as $sucess_approval){
                                        $indsertdata=[];
                                        $indsertdata['user_id']=$sucess_approval['user_id'];
                                        $indsertdata['offer_id']=$sucess_approval['offer_id'];
                                        $indsertdata['tenure_in_days']=$sucess_approval['tenure_in_days'];
                                        $indsertdata['processing_fee']=$sucess_approval['processing_fee'];
                                        $indsertdata['annual_interest_rate']=$sucess_approval['annual_interest_rate'];
                                        $this->common_model->InsertData('pay1_pre_approvals',$indsertdata);
                                    }
                                }
                            }
                        }else{
                            $this->data['excel_error']='Allowed Maximum 50 Record.';
                        }
                    }else{
                        $this->data['excel_error']= 'Excel is Empty';
                    }
                }
            }else{
                $this->data['excel_error']= 'The Excel is Required';
            }
        } 
        $this->data['content']='pay1/index';
        $this->data['script']='pay1/script';
        $this->load->view('super-admin',$this->data);
    }
    public function PushApprovals($token,$data){
        $url='https://loan.pragaticapital.in/sdk/push-preaprovals';
        $headers=['x-api-token:Basic '.$token,'Content-type:application/json'];
        $response= $this->CallApi($url,$headers,['pre_approvals'=>$data]);
       return json_decode($response,true);
    }
    public function CallApi($url,$headers,$data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $response;
    }
    
}