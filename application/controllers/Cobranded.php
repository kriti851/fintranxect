<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cobranded extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->output->delete_cache();
        $this->load->library('session');
    }
    private $data=[];
    public function index(){
        $this->load->view('cobranded');
    }
}