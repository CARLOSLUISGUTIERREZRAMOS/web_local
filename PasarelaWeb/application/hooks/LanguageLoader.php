<?php

/**
 * Description of LanguageLoader
 *
 * @author cgutierrez
 */
class LanguageLoader {

    function initialize() {
        $ci = & get_instance();
        $ci->load->helper('language');  
        $siteLang = $ci->session->userdata('site_lang');
        $ci->session->set_userdata('site_lang', 'spanish');
//        echo $siteLang;
//        if ($siteLang) {
        $ci->lang->load('message', $siteLang);
//        } else {
//            $ci->lang->load('message',$siteLang);
//        }
    }

}
