<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'Pages/displaylogin';
$route['404_override']       = '';
$route['translate_uri_dashes'] = FALSE;

// ─── AUTH ────────────────────────────────────────────────────────────────────
$route['login']           = 'Pages/displaylogin';
$route['validate/user']   = 'AuthProcess/VerifyUsr';

// ─── ACCOUNT ─────────────────────────────────────────────────────────────────
$route['create']          = 'Pages/displayCreateAcc';
$route['create/account']  = 'AuthProcess/Insrtdata';

// ─── DASHBOARD ───────────────────────────────────────────────────────────────
$route['tickets/all']     = 'Pages/displayDshbrd';

// ─── NAVBAR ──────────────────────────────────────────────────────────────────
$route['navbar']          = 'Pages/displayNav';

// ─── CREATE TICKET ───────────────────────────────────────────────────────────
$route['tickets/create']  = 'Pages/displayCreateTickets';
$route['tickets/send']    = 'Tickets/CrtTickets';

// ─── VIEW / EDIT TICKET ──────────────────────────────────────────────────────
$route['tickets/view/(:any)']   = 'Tickets/Viewtckts/$1';
$route['tickets/update/(:any)'] = 'Tickets/UpdateTckts/$1';

// ─── TICKET DETAILS PAGE ─────────────────────────────────────────────────────
$route['tickets/details/view/(:any)'] = 'Tickets/returnticketDetails/$1';

// ─── COMMENTS ────────────────────────────────────────────────────────────────
$route['tickets/comment/(:any)'] = 'Tickets/postComment/$1';

// ─── STATUS ──────────────────────────────────────────────────────────────────
$route['tickets/status/(:any)/(:any)'] = 'Tickets/updateStatus/$1/$2';

// ─── APPROVAL PAGE ───────────────────────────────────────────────────────────
$route['tickets/approval'] = 'Pages/displayApprvlPgs';

// ─── LOGOUT ──────────────────────────────────────────────────────────────────
$route['Logout'] = 'AuthProcess/Logout';