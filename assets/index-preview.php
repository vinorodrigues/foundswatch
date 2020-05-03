<?php
include_once '../../inc/functions.php';
global $theme, $the_path;
$theme = strtolower(basename(__DIR__));
$the_path = '../..';
include '../preview.php';
