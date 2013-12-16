<?php

namespace Roto;

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

error_reporting(E_ALL);
date_default_timezone_set('America/Chicago');

$root = dirname(__FILE__);

$request = $_SERVER['REQUEST_URI'];


include_once($root.'/vendor/autoload.php');

require_once($root .'/lib/general.php');
require_once($root.'/lib/services.php');

Widget::$root = $root.'/layout/widgets/';

Service::Router()->route($_SERVER['REQUEST_URI']);
