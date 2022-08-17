<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {
    private $data=[];
    public function __construct() {
		parent::__construct();
		$this->output->delete_cache();
        $this->load->library('session','form_validation','pagination','CSVReader');
        $this->load->model(['auth_model','common_model']);

        $this->load->helper(['url','form','file']);
       

    }

    

    public function index(){
        
        $data = array();
        $mapp_products = array();
     
        if($this->input->server('REQUEST_METHOD')=='POST'){
        
                    $this->load->library('CSVReader');
                  
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);
            
                    if(!empty($csvData)){
          
                        foreach($csvData as $row){ 
                         $m =  explode("-", $row['morning']);
                         $e =  explode("-", $row['evening']);

                         if($m[0] == 'NULL'){
                             $morning_start = $m[0];
                             $morning_end = $m[0];
                         }else{
                            $morning_start = $m[0];
                            $morning_end =  $m[1];
                         }
                         if($e[0] == 'NULL'){
                            $evening_start = $e[0];
                            $evening_end = $e[0];
                         }else{
                             $evening_start = $e[0];
                             $evening_end = $e[1];
                         }
                        
                            $mapp_products = array(
                           
                                'name' => $row['name'],
                                'mobile' => $row['mobile'],
                                'type_of_location' => $row['address_type '],
                                'location' => $row['local_address'],
                                'morning_start_time' => $morning_start,
                                'morning_end_time' => $morning_end,
                                'evening_start_time' =>$evening_start,
                                'evening_end_time' => $evening_end,
                                'social_days' => $row['social_days'],
                                'contact_person' => $row['data_entered_by'],  
                            );
                      
                                $this->common_model->InsertData('data_entry',$mapp_products);
                             
                             
                              
                            }
                            redirect('import/index');
                        }
                  
                   
             
            }else{
                $this->load->view('import');
            }
       
    }

}