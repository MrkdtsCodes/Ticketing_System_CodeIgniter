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

//dashboard
$route['tickets/dashboard'] = 'Pages/displayDshbrd';

//navbar
$route['navbar'] = 'Pages/displayNav';

//display tickets UI
$route['tickets/create'] = 'Pages/displayCreateTickets';

//view ticket created
$route['tickets/view'] = 'Pages/diplayTickt';

//create tickets
$route['tickets/send'] = 'Tickets/CrtTickets';

//Logout current session
$route['Logout'] = 'AuthProcess/Logout';

//Getting the id of the ticket we want to view
$route['tickets/view/(:any)'] = 'Tickets/Viewtckts/$1';

//update ticket assign
$route['tickets/update/(:any)'] = 'Tickets/UpdateTckts/$1';