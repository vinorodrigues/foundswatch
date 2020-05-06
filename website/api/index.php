<?php

if (!defined('INIT')) include_once '../inc/functions.php';

$t = time();
$data = getVersion();
$fn = (isset($_REQUEST['f']) && !empty($_REQUEST['f'])) ? $_REQUEST['f'] : false;
$url_part = 'https://foundswatch.com/themes/';
$cdn_part = 'https://cdn.jsdelivr.net/gh/vinorodrigues/foundswatch@' . $data . '/dist/';

$data = array("version" => $data);
$data['api'] = array(
	'url'        => full_url(),
	'ip'         => $_SERVER['SERVER_ADDR'],
	'localStamp' => date('D, j M Y H:i:s T', $t),
	'timeStamp'  => gmdate('D, d M Y H:i:s \G\M\T', $t),
	);
$data['themes'] = array();

$list = $themelist;  ksort($list);
foreach ($list as $name => $desc) {
	$part = strtolower($name);
	if ('default' == $part) continue;
	$data["themes"][] = array(
		'name'         => $name,
		'description'  => $desc,
		'screenshot'   => $url_part . $part . '/screenshot.jpg',
		'preview'      => $url_part . $part . '/',
		'css'          => $cdn_part . $part . '/foundation.css',
		'cssMin'       => $cdn_part . $part . '/foundation.min.css',
		'scssSettings' => $url_part . $part . '/_settings.scss',
		'scss'         => $url_part . $part . '/_foundswatch.scss',
		);
}

$x = error_get_last();
if (empty($x)) {
	header('Access-Control-Allow-Origin: *');
	header('Content-type: application/json');
	if (false !== $fn) {
		$data['filename'] = $fn;
		if (!defined('DEBUG') || !DEBUG)
			header('Content-Disposition: inline; filename="'.$fn.'"');
	}
	if (!defined('DEBUG') || !DEBUG) {
		$x = 86400;  // 1 day, or 60 * 60 * 24, seconds
		header('Cache-Control: max-age=' . $x . ', public');
		$x = gmdate('D, d M Y H:i:s \G\M\T', $t + $x);
		$data['api']['expires'] = $x;
		header('Expires: ' . $x);
	}
}
$data = json_encode($data);
echo $data;
