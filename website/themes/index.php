<?php

if (!defined('INIT')) include_once '../inc/functions.php';

global $theme, $preview;

$theme = getRequest('theme', true);
if (false !== $theme) $theme = strtolower($theme);
$preview = getRequest('preview');

if (false !== $preview) {
	if (false === $theme) $theme = 'default';
	if (true !== $preview) {
		$theme = strtolower($preview);
	}
	include 'preview.php';
} else {
	if (false === $theme) {
		// $theme = 'default';
		include 'all.php';
	} else {
		include 'thumbnail.php';
	}
}
