<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'users/auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['register'] = 'users/auth/register';
$route['login'] = 'users/auth/login';
$route['logout'] = 'users/auth/logout';
$route['profile'] = 'users/auth/profile';

$route['admin/users'] = 'users/users/index';
$route['admin/users/list'] = 'users/admin/users/list_json';
$route['admin/users/create'] = 'users/admin/users/create';
$route['admin/users/edit/(:num)'] = 'users/admin/users/edit/$1';
$route['admin/users/delete/(:num)'] = 'users/admin/users/delete/$1';
