<?php

if (is_file(stream_resolve_include_path('_debug.php'))) include_once '_debug.php';
if (!defined('INIT')) include_once 'variables.php';

if (!defined('DOTMIN')) {
	if (defined('DEBUG') && DEBUG) {
		define('DOTMIN', '');
	} else {
		define('DOTMIN', '.min');
	}
}

function _v() {
	if (defined('DEBUG') && DEBUG) {
		return '?v=' . uniqid();
	} else {
		return '';
	}
}

function getVersion() {
	if (!defined('FOUNDSWATCH_VERSION')) {
		$ver = @file_get_contents('../api/version.json');
		if (false !== $ver) {
			$ver = @json_decode($ver, true);
			if (is_array($ver) && array_key_exists('version', $ver)) {
				$ver = $ver['version'];
			} else {
				$ver = false;
			}
		}
		if (false !== $ver) {
			define('FOUNDSWATCH_VERSION', $ver);
		} else {
			define('FOUNDSWATCH_VERSION', '1.0.0');
		}
	}
	return FOUNDSWATCH_VERSION;
}

function getRequest(string $name, $must_have_value = false) {
	$ret = array_key_exists($name, $_REQUEST) ? trim( $_REQUEST[$name] ) : false;
	if ((false !== $ret) && empty($ret) ) return $must_have_value ? false : true;
	return $ret;
}

function findTheme($name) {
	global $themelist;
	if (!isset($themelist)) return false;
	$name = strtolower($name);
	$desc = false;
	foreach ($themelist as $key => $value) {
		if (strcasecmp($key, $name) == 0) {
			$name = $key;
			$desc = $value;
			break;
		}
	}
	return $desc !== false ? array($name, $desc) : false;
}

// borrowed from Wordpress

function untrailingslashit( $string ) {
	return rtrim( $string, '/\\' );
}

function trailingslashit( $string ) {
	return untrailingslashit( $string ) . '/';
}

// borrowed from https://stackoverflow.com/a/8891890/1575941

function url_origin( $s = null, $use_forwarded_host = false ) {
	if (empty($s)) $s = $_SERVER;
	$ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
	$sp       = strtolower( $s['SERVER_PROTOCOL'] );
	$protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
	$port     = $s['SERVER_PORT'];
	$port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
	$host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
	$host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
	return $protocol . '://' . $host;
}

function full_url( $s = null, $use_forwarded_host = true ) {
	if (empty($s)) $s = $_SERVER;
    return url_origin( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
}

// website pages common

function headHere(string $title, $injection_callback = '') {
	global $theme;
	$usetheme = isset($theme) ? $theme : false;
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
<?php
	if (function_exists('headInjection')) headInjection();
?>
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Foundswatch: <?= $title ?></title>
	<link rel="icon" type="image/svg+xml" href="<?= ABSPATH ?>favicon.svg" />
	<link rel="alternate icon" href="<?= ABSPATH ?>favicon.ico" />
	<link rel="icon" type="image/gif" href="<?= ABSPATH ?>favicon.gif" />
<?php if (false === $usetheme): ?>
	<?php if (empty(DOTMIN)) : ?>
	<link rel="stylesheet" href="<?= ABSPATH ?>themes/dark/foundation<?= DOTMIN ?>.css<?= _v() ?>" media="(prefers-color-scheme: dark)" id="css-dark" />
	<link rel="stylesheet" href="<?= ABSPATH ?>themes/default/foundation<?= DOTMIN ?>.css<?= _v() ?>" media="(prefers-color-scheme: no-preference), (prefers-color-scheme: light)" id="css-light" />
	<?php else: ?>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/vinorodrigues/foundswatch/dist/dark/foundation.min.css" media="(prefers-color-scheme: dark)" id="css-dark" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/<?= FOUNDATION_VERSION ?>/css/foundation.min.css" media="(prefers-color-scheme: no-preference), (prefers-color-scheme: light)" id="css-light" />
	<?php endif; ?>
<?php else: ?>
	<link rel="stylesheet" href="<?= ABSPATH ?>themes/<?= $usetheme ?>/foundation<?= DOTMIN ?>.css<?= _v() ?>" />
<?php endif; ?>
	<link rel="stylesheet" href="<?= ABSPATH ?>css/site.min.css<?= _v() ?>" />
<?php
	if (!empty($injection_callback)) call_user_func($injection_callback);
?>
</head>
<?php
}

function headerHere($add_on_menu_callback = '') {
?>
	<header>
	<div class="" data-sticky-container>
		<div class="sticky top-bar-wrapper" data-sticky data-options="anchor: page; marginTop: 0; stickyOn: small;">
			<div class="grid-container">
				<div class="title-bar" data-responsive-toggle="main-menu" data-hide-for="medium" style="display: none;">
					<button class="menu-icon" type="button" data-toggle="main-menu"></button>
					<div class="title-bar-title">Foundswatch</div>
				</div>
				<div class="top-bar" id="main-menu">
					<div class="top-bar-left">
						<ul class="dropdown menu" data-dropdown-menu>
							<li class="menu-text hide-for-small-only site-logo"><a href="<?= ABSPATH ?>."><picture><source srcset="<?= ABSPATH ?>img/logo.dark.svg" media="(prefers-color-scheme: dark)" /><img src="<?= ABSPATH ?>img/logo.svg" style="height: 1.2rem"></picture></a></li>
							<li class="menu-text hide-for-small-only site-name"><a href="<?= ABSPATH ?>.">Foundswatch</a></li>
							<li class="hide-for-medium"><a href="<?= ABSPATH ?>.">Home</a></li>
							<li class="has-submenu">
								<!-- <a href="<?= ABSPATH ?>themes/">Themes</a> -->
								<a>Themes</a>
								<ul class="submenu menu vertical" data-submenu>
									<?php
									global $themelist;
									foreach ($themelist as $name => $desc) {
										$thm = strtolower($name);
										if ('default' == $thm) continue;
										echo '<li><a href="' . ABSPATH . 'themes/' . $thm . '/">' . $name . '</a></li>';
									}
									?>
								</ul>
							</li>
							<?php if (!empty($add_on_menu_callback)) call_user_func($add_on_menu_callback); ?>
							<li><a href="<?= ABSPATH ?>help/">Help</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	</header>
<?php
}

function footerHere($injection_callback = '', $anythingelse_callback = '') {
?>
	<div class="footer-container">
	<footer id="footer" class="grid-container">
		<div class="grid-x grid-margin-y expanded" style="align-items: flex-end;">
			<div class="cell medium-8">
				<ul class="simple menu">
					<li><a href="https://github.com/vinorodrigues/foundswatch">GitHub</a></li>
				</ul>
			</div>
			<div class="cell medium-4">
				<ul class="simple menu align-right">
					<li><a href="#top">Back to top</a></li>
				</ul>
			</div>
			<div class="cell small-10 clearfix">
				Made with <small>&#10084;&#65039;</small> by <a href="https://github.com/vinorodrigues">Vino Rodrigues</a>.<br>
				Code released under the <a target="_blank" href="https://github.com/vinorodrigues/foundswatch/blob/master/LICENSE.md">MIT License</a>.
					Inspired by <a target="_blank" href="https://bootswatch.com">Bootswatch</a>, made by <a target="_blank" href="https://thomaspark.co/">Thomas Park</a>.<br>
				Based on <a target="_blank" href="https://get.foundation" rel="nofollow">ZURB Foundation</a>.
					Icons from <a target="_blank" href="https://zurb.com/playground/foundation-icon-fonts-3" rel="nofollow">ZURB Foundation Icon Fonts</a>.
					Web fonts from <a target="_blank" href="https://fonts.google.com/" rel="nofollow">Google</a>.
					<?php if (!empty($anythingelse_callback)) call_user_func($anythingelse_callback); ?>
			</div>
			<div class="cell small-2">
				<ul class="simple menu align-right">
					<li>&copy; <?php $y = date("Y"); echo ($y != 2020) ? '2020&ndash;'.$y : $y; ?></li>
				</ul>
			</div>
        </div>
	</footer>
	</div>
<?php /*
	<script src="<?= ABSPATH ?>js/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/<?= JQUERY_VERSION ?>/jquery<?= DOTMIN ?>.js"></script>
	<script src="<?= ABSPATH ?>js/what-input.min.js"></script>
	<script src="<?= ABSPATH ?>js/foundation.min.js"></script>
*/ ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/<?= JQUERY_VERSION ?>/jquery<?= DOTMIN ?>.js"></script>
	<script src="https://code.jquery.com/jquery-<?= JQUERY_VERSION ?><?= DOTMIN ?>.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/what-input/<?= WHAT_INPUT_VERSION ?>/what-input<?= DOTMIN ?>.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/<?= FOUNDATION_VERSION ?>/js/foundation<?= DOTMIN ?>.js"></script>
<?php if (!empty($injection_callback)) call_user_func($injection_callback); ?>
	<script>
		$(document).ready(function() {
			$(document).foundation();
		});
	</script>
<?php
	if (is_file(stream_resolve_include_path('_gtag.php')))
		include('_gtag.php');
}
