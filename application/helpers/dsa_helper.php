<?php
if(!function_exists('redirect_admin')){
    function redirect_dsa($str=""){
        redirect('dsa/'.$str);
	}
}
if(!function_exists('dsa_url')){
    function dsa_url($str=""){
        return site_url('dsa/'.$str);
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
    	$config['cur_tag_open'] = "<li class='page-item active'><a href='#' >";
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
if(!function_exists('isDsaLogin')){
    function isDsaLogin(){
		$ci =& get_instance();
        if(!empty($ci->session->userdata('user_id')) && !empty($ci->session->userdata('user_type'))  && ($ci->session->userdata('user_type')=="DSA" || $ci->session->userdata('user_type')=="SUB-DSA") && !empty($ci->session->userdata('__token')) && $ci->session->userdata('__token')=="@&%$%&*^%&*%$*"){
			return true;
        }else{
            redirect('login');
        }
	}
}
if(!function_exists('MainPermission')){
	function MainPermission($param){
		$ci =& get_instance();
		if(!empty($ci->session->userdata('dsa')['main_permission'])){
			if(in_array($param,$ci->session->userdata('dsa')['main_permission'])){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}
}
if(!function_exists('SubPermission')){
	function SubPermission($param){
		$ci =& get_instance();
		if(!empty($ci->session->userdata('dsa')['sub_permission'])){
			if(in_array($param,$ci->session->userdata('dsa')['sub_permission'])){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}
}
