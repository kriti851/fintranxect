<?php
if(!function_exists('redirect_admin')){
    function redirect_merchant($str=""){
        redirect('merchant/'.$str);
	}
}
if(!function_exists('dsa_url')){
    function merchant_url($str=""){
        return site_url('merchant/'.$str);
	}
}
if(!function_exists('GetPagination')){
    function GetPagination($per_page=10){
    	$config['per_page'] = $per_page;
    	$config['num_links'] = 2;
    	$config['use_page_numbers'] = true;
    	$config['page_query_string'] = true;
    	$config['full_tag_open'] = "<ul class='pagination justify-content-end'>";
    	$config['full_tag_close'] ="</ul>";
    	$config['num_tag_open'] = '<li class="page-item">';
    	$config['num_tag_close'] = '</li>';
    	$config['cur_tag_open'] = "<li class='page-item '><a href='#' class='page-active'  >";
    	$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
    	$config['next_tag_open'] = "<li class='page-item '>";
    	$config['next_tag_close'] = "</li>";
    	$config['prev_tag_open'] = "<li class='page-item '>";
    	$config['prev_tag_close'] = "</li>";
    	$config['first_tag_open'] = "<li class='page-item '>";
    	$config['first_tag_close'] = "</li>";
    	$config['last_tag_open'] = "<li class='page-item '>";
    	$config['last_tag_close'] = "</li>";
    	return $config;
    }
}
if(!function_exists('isMerchantLogin')){
    function isMerchantLogin(){
        $ci =& get_instance();
        if(!empty($ci->session->userdata('user_id')) && !empty($ci->session->userdata('user_type'))  && $ci->session->userdata('user_type')=="MERCHANT" && !empty($ci->session->userdata('__token')) && $ci->session->userdata('__token')=="@&%$%&*^%&*%$*"){
            return true;
        }else{
            redirect('login');
        }
	}
}