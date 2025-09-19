<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Myclass
{
    public function Myfunction()
    {
        // echo '<pre>';
        // print_r('worked');
        // echo '</pre>';
        $CI =& get_instance();
        $user_added = $CI->session->userdata('user_added');
        
        if ($user_added) {
            $CI->load->library('email');
            $CI->email->from('shayanrezayi14@gmail.com', 'سیستم ثبت‌نام');
            $CI->email->to('shayanrezayi14@gmail.com');
            $CI->email->subject('کاربر جدید ثبت شد');
            $CI->email->message("کاربر {$user_added['name']} با ایمیل {$user_added['email']} ثبت نام کرد.");
            
            if ($CI->email->send()) {
                log_message('info', 'ایمیل برای کاربر ' . $user_added['email'] . ' ارسال شد.');
            } else {
                log_message('error', 'خطا در ارسال ایمیل: ' . $CI->email->print_debugger());
            }
            
            $CI->session->unset_userdata('user_added');
        }
    }
}