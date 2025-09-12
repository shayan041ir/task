<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['register'] = 'auth/register';
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['profile'] = 'auth/profile';

$route['admin/users'] = 'admin/users/index';
$route['admin/users/list'] = 'admin/users/list_json';
$route['admin/users/create'] = 'admin/users/create';
$route['admin/users/edit/(:num)'] = 'admin/users/edit/$1';
$route['admin/users/delete/(:num)'] = 'admin/users/delete/$1';
