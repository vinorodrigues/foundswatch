<?php

if (!defined('INIT')) include_once '../inc/functions.php';

global $theme, $theme_name, $theme_desc;

$theme = isset($theme) ? strtolower($theme) : false;
if (!$theme) {
	$theme = getRequest('theme', true);
	if (false !== $theme) $theme = strtolower($theme);
}
if (false !== $theme) {
	$theme_name = findTheme($theme);
	if (false !== $theme_name) {
		$theme_desc = $theme_name[1];
		$theme_name = $theme_name[0];
	} else {
		$theme = false;
	}
}
if (false === $theme) {
	$theme = 'default';
	$theme_name = 'Default';
	$theme_desc = 'Default Foundation for Sites';
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Foundswatch: <?= $theme_desc ?></title>
	<link rel="stylesheet" href="<?= ABSPATH . 'themes/' . $theme ?>/foundation.css<?= _v() ?>">
	<style>
		body {
			width: 500px;
			margin: 0;
			padding: 0;
		}
		h1, p, .bs-example {
			text-align: center;
		}
		h1#theme {
			padding-top: 1rem;
		}
		#main-menu {
			z-index: -10;
			padding-left: 20px;
		}
		.lead {
			margin: 1em 0;
		}
	</style>
</head>
<body>
	<header>
		<div class="top-bar" id="main-menu">
			<div class="top-bar-left">
				<ul class="dropdown menu" data-dropdown-menu>
					<li class="menu-text hide-for-small-only">Foundswatch</li>
					<li class="has-submenu">
						<a href="#">Themes</a>
						<ul class="submenu menu vertical" data-submenu>
						</ul>
					</li>
					<li><a href="#">Help</a></li>
					<li><a href="#">Blog</a></li>
				</ul>
			</nav>
		</div>
	</header>

	<main>
		<h1 id="theme"><?= $theme_name ?></h1>
		<p id="description" class="lead"><?= $theme_desc ?></p>
		<div class="bs-example">
			<a class="button primary" href="#">Primary</a>
			<a class="button secondary" href="#">Secondary</a>
			<a class="button success" href="#">Success</a>
			<a class="button alert" href="#">Alert</a>
			<a class="button warning" href="#">Warning</a>
		</div>
	</main>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/<?= JQUERY_VERSION ?>/jquery<?= DOTMIN ?>.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/what-input/<?= WHAT_INPUT_VERSION ?>/what-input<?= DOTMIN ?>.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/<?= FOUNDATION_VERSION ?>/js/foundation<?= DOTMIN ?>.js"></script>
	<script>
		$(document).ready(function() {
			$(document).foundation();
		});
	</script>
</body>
</html>
