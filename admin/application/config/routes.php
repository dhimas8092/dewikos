<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['login'] = 'login';
$route['login/proses'] = 'login/proses';

$route['default_controller'] = 'login';
$route['login'] = 'login';
$route['login/proses'] = 'login/proses';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;