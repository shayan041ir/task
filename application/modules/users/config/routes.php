<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['users/login']    = 'users/auth/login';
$route['users/register'] = 'users/auth/register';
$route['users/logout']   = 'users/auth/logout';
$route['users/profile']  = 'users/auth/profile';

$route['admin/users']          = 'users/users/index';
$route['admin/users/list']     = 'users/users/list_json';
$route['admin/users/create']   = 'users/users/create';
$route['admin/users/edit/(:num)'] = 'users/users/edit/$1';
$route['admin/users/delete/(:num)'] = 'users/users/delete/$1';
