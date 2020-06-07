<?php

if (is_file(stream_resolve_include_path('_debug.php'))) include_once '_debug.php';
if (!defined('INIT')) include_once 'variables.php';
include_once 'Browser.php';

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

function versionCompare($a, $b) {
	$a = explode(".", rtrim($a, ".0"));
	$b = explode(".", rtrim($b, ".0"));
	foreach ($a as $depth => $aVal) {
		if (isset($b[$depth])) {
			if ($aVal > $b[$depth]) return 1;
			else if ($aVal < $b[$depth]) return -1;
		} else {
			return 1;
		}
	}
	return (count($a) < count($b)) ? -1 : 0;
}

function supportsDarkMode() {
	/** @see https://developer.mozilla.org/en-US/docs/Web/CSS/@media/prefers-color-scheme#Browser_compatibility */
	$browser = new Browser();
	$is_desktop = !( $browser->isMobile() || $browser->isTablet() );
	$version = $browser->getVersion();
	// $platform = $browser->getPlatform();
	$browser = $browser->getBrowser();
	$ret = false;
	if ($is_desktop) {
		switch ($browser) {
			case Browser::BROWSER_OPERA: $ret = versionCompare($version, '62') >= 0; break;
			case Browser::BROWSER_EDGE: $ret = versionCompare($version, '79') >= 0; break;
			case Browser::BROWSER_FIREFOX: $ret = versionCompare($version, '67') >= 0; break;
			case Browser::BROWSER_SAFARI: $ret = versionCompare($version, '12.1') >= 0; break;
			case Browser::BROWSER_CHROME: $ret = versionCompare($version, '76') >= 0; break;
		}
	} else {
		switch ($browser) {
			// case Browser::BROWSER_OPERA:
			case Browser::BROWSER_OPERA_MINI: $ret = versionCompare($version, '54') >= 0; break;
			// case Browser::BROWSER_SAFARI:
			case Browser::BROWSER_IPHONE:
			case Browser::BROWSER_IPAD: $ret = versionCompare($version, '13') >= 0; break;
			case Browser::BROWSER_CHROME: $ret = versionCompare($version, '76') >= 0; break;
			case Browser::BROWSER_ANDROID: $ret = versionCompare($version, '76') >= 0; break;
		}
	}
	return  $ret;
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
	$html_class = 'no-js';

	if (defined('DEBUG') && DEBUG) {
		$browser = new Browser();
		$html_class .= ' browser-' . strtolower(str_replace(' ', '-', $browser->getBrowser()));
		$html_class .= ' browser-v' . strtolower(str_replace([' ', '.'], '-', $browser->getVersion()));
		$html_class .= ' platform-' . strtolower(str_replace(' ', '-', $browser->getPlatform()));
		$html_class .= ' is-' . (( $browser->isMobile() || $browser->isTablet() ) ? 'mobile' : 'desktop');
	}

	$css_file = array( ABSPATH . 'css/site.min.css' . _v() );
	$sdm = false;

	if (false !== $usetheme) {
		$css_file[] = ABSPATH . 'themes/' . $usetheme . '/foundation' . DOTMIN . '.css' . _v() . '|css';
	} else {
		$css_file[] = (empty(DOTMIN) ?
			ABSPATH . 'themes/default/foundation' . DOTMIN . '.css' . _v() :
			'https://cdnjs.cloudflare.com/ajax/libs/foundation/' . FOUNDATION_VERSION . '/css/foundation' . DOTMIN . '.css' );
		$sdm = supportsDarkMode();
		if ($sdm) {
			// $i = $css_file[1];
			$css_file[1] .= '|css-light|(prefers-color-scheme: no-preference), (prefers-color-scheme: light)';
			$css_file[] = (empty(DOTMIN) ?
				ABSPATH . 'themes/dark/foundation' . DOTMIN . '.css' . _v() :
				'https://cdn.jsdelivr.net/gh/vinorodrigues/foundswatch/dist/dark/foundation' . DOTMIN . '.css' ) .
				'|css-dark|(prefers-color-scheme: dark)';
			// $css_file[] = $i . '|css';
		} else {
			$css_file[1] .= '|css';
		}
	}
?>
<!doctype html>
<html class="<?= $html_class ?>" lang="en">
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
	<style>
		:root {
			--top-bar-bg: #e6e6e6;
		}
		.z100 {
			z-index: 100;
		}
	</style>
<?php
	if ($sdm) {
?>
	<meta name="color-scheme" content="light dark">
	<script>
		if ( !window.matchMedia || (window.matchMedia("(prefers-color-scheme: dark)").media === "not all") )
			document.head.insertAdjacentHTML( "beforeend",
				"<link id=\"css\" rel=\"stylesheet\" href=\"<?= explode('|', $css_file[1])[0] ?>\">" );
	</script>
<?php
	}
	for ($i=count($css_file)-1; $i>=0; $i--) {
		$css = explode('|', $css_file[$i]);
		echo "\t" . '<link';
		if (isset($css[1])) echo ' id="' . $css[1] . '"';
		echo ' rel="stylesheet"';
		echo ' href="' . $css[0] . '"';
		if (isset($css[2])) echo ' media="' . $css[2] . '"';
		echo '>' . PHP_EOL;
	}
	if (!empty($injection_callback)) call_user_func($injection_callback);
?>
</head>
<?php
}

function headerHere($add_on_menu_callback = '') {
?>
	<header>
	<div class="z100" data-sticky-container>
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
									$list = $themelist;  ksort($list);
									foreach ($list as $name => $desc) {
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
		function setColorMode() {
			if ( window.matchMedia('(prefers-color-scheme: dark)').matches ) {
				$("html").addClass("mode-dark").removeClass("mode-light");
			} else {
				$("html").addClass("mode-light").removeClass("mode-dark");
			}
		}

		$(document).ready(function() {
			$(document).foundation();

			if ( !window.matchMedia || (
				!window.matchMedia('(prefers-color-scheme: dark)').matches &&
				!window.matchMedia('(prefers-color-scheme: light)').matches &&
				!window.matchMedia('(prefers-color-scheme: no-preference)').matches ) ) {
				// prefers-color-scheme not supported
				$("#css-dark").remove();
				$("#css-light").attr( { "media": "", "id": "css" });
				$("html").addClass("mode-light");
			} else {
				setColorMode();
				window.matchMedia("(prefers-color-scheme: dark)").addListener(setColorMode);
			}
		});
	</script>
<?php
	if (is_file(stream_resolve_include_path('_gtag.php')))
		include('_gtag.php');
}
