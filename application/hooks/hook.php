<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['post_user_add'] = array(
    'class'    => 'Email',
    'function' => 'send_admin_notification',
    'filename' => 'Email.php',
    'filepath' => 'modules/sendemail/controllers',
    'params'   => array()
);