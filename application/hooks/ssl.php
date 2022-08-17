<?php
function redirect_ssl() {
    $CI =& get_instance();
    $class = $CI->router->fetch_class();
    $CI->load->helper('url');
    if($_SERVER['HTTP_X_FORWARDED_PROTO']=='http'){
        $CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
        if ($_SERVER['SERVER_PORT'] != 443) redirect($CI->uri->uri_string());
    }
    
}