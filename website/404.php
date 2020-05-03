<?php

include_once 'inc/functions.php';

if (!isset($err)) $err = getRequest('e', true);
if (false !== $err) $err = intval($err);
if ((false === $err) || (0 == $err)) $err = 404;

$errors = array(
	400 => 'Bad Request',                   401 => 'Unauthorized',
	402 => 'Payment Required',              403 => 'Forbidden',
	404 => 'Not Found',                     405 => 'Method Not Allowed',
	406 => 'Not Acceptable',                407 => 'Proxy Authentication Required',
	408 => 'Request Timeout',               409 => 'Conflict',
	410 => 'Gone',                          411 => 'Length Required',
	412 => 'Precondition Failed',           413 => 'Payload Too Large',
	414 => 'URI Too Long',                  415 => 'Unsupported Media Type',
	416 => 'Range Not Satisfiable',         417 => 'Expectation Failed',
	418 => 'I\'m a teapot',                 421 => 'Misdirected Request',
	422 => 'Unprocessable Entity',          423 => 'Locked',
	424 => 'Failed Dependency',             425 => 'Too Early',
	426 => 'Upgrade Required',              428 => 'Precondition Required',
	429 => 'Too Many Requests',             431 => 'Request Header Fields Too Large',
	451 => 'Unavailable For Legal Reasons', 500 => 'Internal Server Error',
	501 => 'Not Implemented',               502 => 'Bad Gateway',
	503 => 'Service Unavailable',           504 => 'Gateway Timeout',
	505 => 'HTTP Version Not Supported',    506 => 'Variant Also Negotiates',
	507 => 'Insufficient Storage',          508 => 'Loop Detected',
	510 => 'Not Extended',                  511 => 'Network Authentication Required',
);

$err_desc = array_key_exists($err, $errors) ? $errors[$err] : '?';

header('HTTP/1.1 ' . $err . ' ' . $err_desc, true, $err);
http_response_code($err);

?><!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Foundswatch: <?= $err ?></title>
	<link rel="stylesheet" media="(prefers-color-scheme: dark)" href="//foundswatch.com/themes/dark/foundation.min.css<?= _v() ?>" />
	<link rel="stylesheet" media="(prefers-color-scheme: light)" href="//foundswatch.com/themes/default/foundation.min.css<?= _v() ?>" />
	<link rel="stylesheet" media="(prefers-color-scheme: no-preference)" href="//cdnjs.cloudflare.com/ajax/libs/foundation/<?= FOUNDATION_VERSION ?>/css/foundation.min.css" />
	<style>
		html, body {
			width: 100%;
			height: 100%;
		}
		div.c-container {
			height: 100%;
			display: flex;
			align-items: center
		}
		div.c-container div {
			margin: 0 auto;
		}
	</style>
</head>
<body>
	<div class="c-container">
		<div>
			<h1>Error <?= $err ?></h1>
			<p><b><?= $err_desc ?></b></p>
			<hr>
			<p class="text-center"><a href="/" class="large hollow button primary">Return Home</a></p>
			<p class="text-right"><abbr title="Vino Rodrigues">&copy; <?php $y = date("Y"); echo ($y != 2020) ? '2020&ndash;'.$y : $y; ?></abbr></p>
		</div>
	</div>
</body>
</html>
