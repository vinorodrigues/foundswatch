<?php

if (!defined('INIT')) include_once 'inc/functions.php';

global $theme;
$theme = getRequest('q', true);
if (false !== $theme) {
	$theme = strtolower($theme);

	$f = false;
	foreach ($themelist as $name => $desc) {
		if ($theme == strtolower($name)) {
			$f = true;
			break;
		}
	}
	if (!$f) $theme = false;
}

if (false !== $theme) {
	$the_path = $theme.'/';
	include 'themes/preview.php';
} else {
	global $error;
	$error = 404;
	include '404.php';
}
