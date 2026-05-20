<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Pages/displaylogin';
$route['404_override']       = '';
$route['translate_uri_dashes'] = FALSE;

// ─── AUTH ────────────────────────────────────────────────────────────────────
$route['login']           = 'Pages/displaylogin';
$route['validate/user']   = 'AuthProcess/VerifyUsr';

// ─── ACCOUNT ─────────────────────────────────────────────────────────────────
$route['tickets/account']                       = 'Pages/displayAccounts';
$route['tickets/updatedaccount']                = 'Pages/getUpdatedtableData';
$route['tickets/create/account']                = 'AuthProcess/createUser';
$route['tickets/update/account/(:num)']         = 'AuthProcess/updateUsr/$1';
$route['tickets/update/status/(:num)']          = 'AuthProcess/updtdStatus/$1';

// ─── DASHBOARD ───────────────────────────────────────────────────────────────
$route['tickets/dashboard'] = 'Pages/displayDashboard';
$route['tickets/all']       = 'Pages/displayAllTckts';

// ─── NAVBAR ──────────────────────────────────────────────────────────────────
$route['navbar'] = 'Pages/displayNav';

// ─── CREATE TICKET ───────────────────────────────────────────────────────────
$route['tickets/create'] = 'Pages/displayCreateTickets';
$route['tickets/send']   = 'Tickets/CrtTickets';

// ─── VIEW / EDIT TICKET ──────────────────────────────────────────────────────
$route['tickets/view/(:any)']   = 'Tickets/Viewtckts/$1';
$route['tickets/update/(:any)'] = 'Tickets/UpdateTckts/$1';

// ─── TICKET DETAILS PAGE ─────────────────────────────────────────────────────
$route['tickets/details/view/(:any)']          = 'Tickets/returnticketDetails/$1';
$route['tickets/Reassign/getemployees/(:num)'] = 'Tickets/getEmployeesForModal/$1';

// ─── ASSIGN / REASSIGN ───────────────────────────────────────────────────────
$route['tickets/assign/(:num)']             = 'Tickets/assignEmployee/$1';
$route['tickets/reassign/(:num)']           = 'Tickets/reassignDepartment/$1';       // Re-Assign Department
$route['tickets/reassignEmployee/(:num)']   = 'Tickets/reassignEmployeeOnly/$1';     // Re-Assign Employee only

// ─── COMMENTS ────────────────────────────────────────────────────────────────
$route['tickets/comment/(:any)'] = 'Tickets/postComment/$1';

// ─── STATUS — specific routes FIRST, generic LAST ────────────────────────────
$route['tickets/status/rejected/(:num)']    = 'Tickets/updateStatusReject/$1';
$route['tickets/status/approved/(:num)']    = 'Tickets/updateStatus/Approved/$1';
$route['tickets/status/ongoing/(:any)/(:num)']     = 'Tickets/updatePriorityAndStatus/on going/$1/$2';
$route['tickets/status/fortesting/(:any)/(:num)']  = 'Tickets/updatePriorityAndStatus/For Testing/$1/$2';
$route['tickets/status/closed/(:any)/(:num)']  = 'Tickets/updatePriorityAndStatus/Closed/$1/$2';
// $route['tickets/status/failtest/(:num)']    = 'Tickets/updateStatus/On Going/$1';
// $route['tickets/status/closed/(:num)']      = 'Tickets/updateStatusClosed/$1';

// ─── APPROVAL PAGE ───────────────────────────────────────────────────────────
$route['tickets/approval'] = 'Pages/displayApprvlPgs';

// ─── START WORKING (AJAX) ────────────────────────────────────────────────────
$route['tickets/working/(:num)'] = 'Tickets/strtWrking/$1';

// ─── LOGOUT ──────────────────────────────────────────────────────────────────
$route['Logout'] = 'AuthProcess/Logout';