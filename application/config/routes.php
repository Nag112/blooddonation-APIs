<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['log/:any/cancel/:num'] = 'oauth/rejected/$1/$2';
$route['log/:any/true/:num'] = 'oauth/accepted/$1/$2';
