<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    private $data=[];
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('merchant');
        isMerchantLogin();
    }
    public function index(){
        $this->data['content']="dashboard/index";
        $this->load->view('merchant',$this->data);
    }
}