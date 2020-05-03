<?php

if (!defined('INIT')) include_once 'inc/functions.php';

function uriFile($filename) {
	$root = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	$root = trailingslashit( pathinfo($root, PATHINFO_DIRNAME) );
	return $root . $filename;
}

function dateFile($filename) {
	$filename = stream_resolve_include_path($filename);
	if (file_exists($filename)) {
    	return date("Y-m-d", filemtime($filename));
	} else {
		return '0000-00-00';
	}
}

header('Content-type: text/xml');
// header('Content-type: text/plain');  // for debug

if (true || !defined('DEBUG') || !DEBUG) {
	$wait = 2592000;  // 30 days, or 60 * 60 * 24 * 30, seconds
	header('Cache-Control: max-age=' . $wait . ', public');
	header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + $wait));
}

echo '<'.'?xml version="1.0" encoding="UTF-8"?'.'>'.PHP_EOL;
echo '<'.'?xml-stylesheet type="text/xsl" href="sitemap.xsl"?'.'>'.PHP_EOL;
?>
<urlset
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc><?= uriFile('') ?></loc>
		<lastmod><?= dateFile('index.php') ?></lastmod>
		<changefreq>monthly</changefreq>
		<priority>0.5</priority>
	</url>
	<url>
		<loc><?= uriFile('help/') ?></loc>
		<lastmod><?= dateFile('help/index.php') ?></lastmod>
		<changefreq>monthly</changefreq>
		<priority>0.5</priority>
	</url>
<?php
foreach ($themelist as $name => $desc) {
	$thm = strtolower($name);
	if ('default' == $thm) continue;
?>
	<url>
		<loc><?= uriFile('themes/'.$thm.'/') ?></loc>
		<lastmod><?= dateFile('themes/'.$thm.'/foundation.min.css') ?></lastmod>
		<changefreq>monthly</changefreq>
		<priority>0.5</priority>
	</url>
<?php
}
?>
</urlset>
