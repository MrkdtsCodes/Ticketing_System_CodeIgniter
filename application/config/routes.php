<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Pages/displaylogin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//login route
$route['login'] =  'Pages/displaylogin';
$route['validate/user'] = 'AuthProcess/VerifyUsr';


//create account
$route['create'] = 'Pages/displayCreateAcc';
$route['create/account'] = 'AuthProcess/Insrtdata';


//navbar
$route['navbar'] = 'Pages/displayNav';

//display tickets UI
$route['tickets/create'] = 'Pages/displayCreateTickets';

//create tickets
$route['tickets/send'] = 'Tickets/CrtTickets';

//Logout current session
$route['Logout'] = 'AuthProcess/Logout';

//dashboard
$route['tickets/dashboard'] = 'Pages/displayDshbrd';

//view ticket created
$route['tickets/view'] = 'Pages/diplayTickt';