<?php
/*
 * ========================================================================
 * File:		data.php
 * Purpose: define constants, data arrays and text data
 * Author:	Mark Fletcher
 * Date:		26/11/2020
 *
 * Notes:
 *
 * Revision:
 *
 * ========================================================================
*/
// define constants
// MySQL login
define('AUTH_HOST', 'localhost');
define('AUTH_USER', 'fletch49er');
define('AUTH_PWD', 'pplynott63');
define('AUTH_DB', 'track_n_trace');

// company details
define ('COMPANY', 'designs by mark');
define ('COMPANYNO', '');
define ('NAME', '');
define ('ADDRESS', '99 Mull, St. Leonards, East Kilbride G74 2DU');
define ('TELEPHONE', '');
define ('EMAIL', '');
define ('VATNO', '');

// cookie arrays
$arr_cookie_options1 = [
  'expires' => time() + 60*60*24*21,
  'path' => '\/tracktrace\/',
  'domain' => '.designsbymark.co.uk',
  'secure' => false,
  'httponly' => true,
  'samesite' => 'None'
];

$arr_cookie_options2 = [
  'expires' => time(),
  'path' => '/tracktrace/',
  'domain' => '.designsbymark.co.uk',
  'secure' => false,
  'httponly' => true,
  'samesite' => 'None'
];

// initial form values
$form_values = [
  'first' => ['First name*', 'text', 'first name', '', 'on'],
  'last' => ['Last name*', 'text', 'last name', '', 'on'],
  'email' => ['Email', 'email', 'yourname@domain.com', '', 'on'],
  'phone' => ['Phone number', 'tel','01234 567890', '', 'on'],
  'address1' => ['Addresss line 1', 'text', 'address line 1','', 'on'],
  'address2' => ['Addresss line 2', 'text', 'address line 2', '', 'on'],
  'townCity' => ['Town / City', 'text', 'town / city', '', 'on'],
  'postcode' => ['Post code*', 'text', 'ZZ99 9ZZ', '', 'on']
];
?>
