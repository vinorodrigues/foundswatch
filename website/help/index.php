<?php

include_once '../inc/functions.php';

$v = getVersion();
$v0 = preg_match('/(\d)/', $v, $out) ? $out[0] : '1';
$v00 = preg_match('/(\d+\.)(\d)/', $v, $out) ? $out[0] : '1.0';

function injectPrismHead() {
?>
	<style>
		h3 { margin-top: 3rem; }
		pre[class*=language-] {
			margin: 0 !important;
			padding: 0 !important;
			overflow: hidden !important;
		}
		.code-block { margin-bottom: 0; }
		.token.comment { font-style: italic; }
		.special-url-format u { text-decoration: none; font-style: italic; font-size: 85%; }
		.special-url-format i { opacity: 0.5; }
		.special-url-format b { font-size: 100%; }
	</style>
<?php
	$c = ['https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/themes/prism-coy.min.css',
		'https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/themes/prism-tomorrow.min.css'];
	if (supportsDarkMode()) :
?>
	<script>
		if ( !window.matchMedia || (window.matchMedia("(prefers-color-scheme: dark)").media === "not all") )
			document.head.insertAdjacentHTML( "beforeend",
				"<link rel=\"stylesheet\" href=\"<?= $c[0] ?>\">" );
	</script>
	<link rel="stylesheet" href="<?= $c[1] ?>" media="(prefers-color-scheme: dark)" />
	<link rel="stylesheet" href="<?= $c[0] ?>" media="(prefers-color-scheme: no-preference), (prefers-color-scheme: light)" />
<?php else : ?>
	<link rel="stylesheet" href="<?= $c[0] ?>" />
<?php endif; ?>
<?php
}

function injectPrismFooter() {
	?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/components/prism-core.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/plugins/autoloader/prism-autoloader.min.js"></script>
	<script>
		$(document).ready(function() {
			// only works if jQuery loaded

			// Copy URL buttons
			$('.copy-url-button').each(function() {
				$(this).css( {"display": "inline-block"} );
				$(this).click( function() {
					var target_element = $(this).data("copy");
					// if (!element_name) { console.log("data-copy not defined"); return };
					var $temp = $("<input>");
					$("body").append($temp);
					$temp.val($(target_element).text()).select();
					document.execCommand("copy");
					$temp.remove();
				});
			});

			function injectBrowserSupports() {
				// Show information on `prefers-color-scheme` media query
				var supports = [];
				if (!window.matchMedia) {
					supports.push( "does not support the <code>matchMedia</code> function" );
				} else {
					supports.push( "supports the <code>matchMedia</code> function" );
					if (window.matchMedia("(prefers-color-scheme: no-preference)").matches)
						supports.push( "and prefers a <b>no-preference</b> color scheme" );
					if (window.matchMedia("(prefers-color-scheme: light)").matches)
						supports.push( "and prefers a <small>&#xFE0F;</small> <b>light</b> color scheme" );
					if (window.matchMedia("(prefers-color-scheme: dark)").matches)
						supports.push( "and prefers a <small>&#x1F319;</small> <b>dark</b> color scheme" );
					if (supports.length <= 1) {
						supports.push( "but does not set the <code>prefers-color-scheme</code> media query" );
						supports.push( "so will <b><i><u>not</u></i></b> support the above code" );
					} else {
						supports.push( "so will support the above code" );
					}
				}
				if (supports.length > 0) {
					var htmltext = "Your browser, for example:<ul>";
					supports.forEach(function(entry) { htmltext += "<li>" + entry + "</li>"; });
					htmltext += "</ul>";
					// console.log( htmltext );
					$("#the-dark-side").html( htmltext );
				}
			}

			injectBrowserSupports();  // Update on first load.
			if (window.matchMedia) window.matchMedia("(prefers-color-scheme: dark)").addListener( injectBrowserSupports );  // and every time it changes
		});
	</script>
	<?php
}

function injectPrismThanks() {
	echo 'Syntax highlighting uses <a href="https://prismjs.com/" target="_blank">Prism</a>.';
}


headHere('Help', 'injectPrismHead');

?>
<body>
	<?php headerHere(); ?>

	<main class="content grid-container">
		<div class="grid-x grid-margin-x">
			<div class="cell small-12"><h1>Quick Start</h1></div>
			<div class="cell large-6 clearfix">
				<a name="css"></a><h3>Pre-Compiled CSS</h3>
				<p>Using the themes is as easy as downloading a CSS file and replacing the one that comes with Foundation.</p>
				<p>There are 2 versions of each theme:
					<ul>
						<li><code>foundation.css</code> The uncompressed variant - useful in debugging.</li>
						<li><code>foundation.min.css</code> The compressed variant - used for production websites.</li>
					</ul>
				</p>
				<p><small><b>NB:</b> Please do not hotlink to the files on this site as it will slow yours. See <a href="#cdn">CDN</a> below.</small></p>
			</div>
			<div class="cell large-6">
				<a name="sass"></a><h3>Sass</h3>
				<p>Follow the instructions listed at <a href="https://get.foundation/sites/docs/sass.html" target="_blank">get.foundation/sites/docs/sass.html</a></p>
				<p>Then drop in the theme SASS files:

<pre><code class="code-block language-scss">@import 'settings';             // *Foundswatch variant
@import '../scss/foundation';   // Zurb Foundation <?= FOUNDATION_VERSION . PHP_EOL ?>
@include foundation-everything;
@import 'foundswatch';          // *Foundswatch variant
</code></pre>

				</p>
			</div>
			<div class="cell small-12">
				<a name="cdn"></a><h3>CDN</h3>
				<p>You can also hotlink the themes via CDN with <a href="https://www.jsdelivr.com" target="_blank">jsdelivr.com</a></p>
				<p>You can access the theme CSS file from the GitHub release:

<pre><code class="code-block language-clike">// load Foundswatch v<?= $v ?> Theme
https://cdn.jsdelivr.net/gh/vinorodrigues/foundswatch@<?= $v ?>/dist/{themename}/foundation.min.css

// use a version range instead of a specific version
https://cdn.jsdelivr.net/gh/vinorodrigues/foundswatch@<?= $v00 ?>/dist/{themename}/foundation.min.css
https://cdn.jsdelivr.net/gh/vinorodrigues/foundswatch@<?= $v0 ?>/dist/{themename}/foundation.min.css

// omit the version completely to get the latest one
// you should NOT use this in production
https://cdn.jsdelivr.net/gh/vinorodrigues/foundswatch/dist/{themename}/foundation.min.css

// remove ".min" to get the uncompressed version
https://cdn.jsdelivr.net/gh/vinorodrigues/foundswatch/dist/{themename}/foundation.css

// add / at the end to get a directory listing
https://cdn.jsdelivr.net/gh/vinorodrigues/foundswatch/
</code></pre>
				</p>

				<p>Current release is v<?= $v ?> and contains:<br>
				<table><tbody>

				<?php
				$kthemelist = array_keys( $themelist );
				sort( $kthemelist, SORT_STRING | SORT_FLAG_CASE );

				foreach ($kthemelist as $name) {
					$name = strtolower($name);
					if ('default' == $name) continue;
				?>
				<tr>
					<td width="90%"><tt class="special-url-format" id="copy-<?= $name ?>-url"><u>https://cdn.jsdelivr.net</u><i>/gh/vinorodrigues/foundswatch@<?= $v ?>/dist/</i><b><?= $name ?></b><i>/foundation.min.css</i></tt></td>
					<td width="10%" style="text-align: center;"><button class="tiny button copy-url-button" style="margin: 0; display: none;" data-copy="#copy-<?= $name ?>-url">Copy URL</button></td>
				</tr>
				<?php
				}
				?>
				<tbody></table></p>
			</div>
			<div class="cell small-12">
				<a name="customisation"></a><h3>Customisation</h3>
				<p>To modify a theme or create your own, follow the steps below in your terminal. You'll need to have
					<a target="_blank" href="https://help.github.com/articles/set-up-git">Git</a>,
					<a target="_blank" href="https://nodejs.org/">Node</a> and
					<a target="_blank" href="https://gulpjs.com/">Gulp</a> installed.
					<ol>
						<li>Download the repository: <code class="language-bash">git clone <a href="https://github.com/vinorodrigues/foundswatch.git">https://github.com/vinorodrigues/foundswatch.git</a></code></li>
						<li>Install Node dependencies: <code class="language-bash">npm install</code></li>
						<li>In the <code>/themesrc</code> folder, modify <code>_settings.scss</code> and <code>_foundswatch.scss</code> in one of the theme sub-folders, or duplicate a theme folder to create a new one.</li>
						<li>Run <code class="language-bash">gulp sass:themes</code> to build your themes.</li>
						<li>The compiled code will be in the <code>/website/themes</code> folder.</li>
					</ol>
			</div>
			<div class="cell small-12">
				<a name="api"></a><h3>API</h3>
				<p>You can use the API to integrate the themes with your platform. Get:<br>
					<code><a href="https://foundswatch.com/api/<?= $v0 ?>.json">
						https://foundswatch.com/api/<?= $v0 ?>.json
					</a></code></p>
				<p>This returns an object with a <code>version</code> and a <code>themes</code> array property:
<pre><code class="code-block language-json">{
	"version":"<?= $v ?>",
	"themes":[ {
			"name":"{string}",
			"description":"{string}",
			"screenshot":"{url}",
			"preview":"{url}",
			"css":"{url}",
			"cssMin":"{url}",
			"scssSettings":"{url}",
			"scss":"{url}"
		}  // , { &hellip; more themes &hellip; }
	]
}
</code></pre></p>
				<p>Here's a <a href="https://jsfiddle.net/vinorodrigues/xqfcmz2b/" target="_blank">demo</a> of the API in action on jsFiddle.</p>
			</div>
			<div class="cell small-12">
				<a name="dark-mode"></a><h3>Dark Mode</h3>
				<p>Unfortunately, Foundation 6 is not designed to support “dark
					mode switching”, i.e. does not support the new
					“<code>prefers-color-scheme</code>” media query.</p>
				<p>You can however load 2 separate instances of the Foundation
					CSS that are very similar, but with one light and the other dark. For example:
					<ul>
						<li><a href="../themes/default/">Default</a> and <a href="../themes/dark/">Dark</a> <i>(As used on this site.)</i></li>
						<li><a href="../themes/flatly/">Flatly</a> and <a href="../themes/darkly/">Darkly</a></li>
					</ul></p>
<p><pre><code class="code-block language-html">&lt;!-- Alternative color mode (loaded first) --&gt;
&lt;link id="css-dark" rel="stylesheet" href="<i>dark/</i>foundation.min.css" media="<b>(prefers-color-scheme: dark)</b>"&gt;
&lt;!-- Default and/or 'no preference' color mode (loaded last) --&gt;
&lt;link id="css-light" rel="stylesheet" href="<i>default/</i>foundation.min.css" media="<b>(prefers-color-scheme: no-preference), (prefers-color-scheme: light)</b>"&gt;
</code></pre></p>
			<p>The above 2-option code will not work with a narrow set of browsers that support the <code>media</code> CSS filter but do not support the <code>prefers-color-scheme</code> subset.<br>
				<i>e.g. older iPads on iOS 12.4.</i></p>
			<span id="the-dark-side"></span>
			<p>In these cases you will need to either add an un-filtered CSS file before the lines above, using the following JavaScript:</p>
<p><pre><code class="code-block language-js">// If `prefers-color-scheme` is not supported, inject the light mode without filter.
if ( !window.matchMedia || (window.matchMedia("(prefers-color-scheme: dark)").media === "not all") )
	document.head.insertAdjacentHTML( "beforeend",
		"&lt;link id=\"css\" rel=\"stylesheet\" href=\"default/foundation.min.css\"&gt;" );
</code></pre></p>
			<p>, or add the following JavaScript to the bottom of your html to disable the filtered CSS.</p>
<p><pre><code class="code-block language-js">$(document).ready(function() {
	// assumes jQuery running
	if ( !window.matchMedia || (window.matchMedia("(prefers-color-scheme: dark)").media === "not all") ) {
		// matchMedia function, or, prefers-color-scheme media query not supported
		$("#css-dark").remove();  // remove the dark mode CSS file link
		$("#css-light").attr( "media", "" );  // remove the media filter
	}
}</code></pre></p>
			<p>Take a look at <a href="https://jsfiddle.net/vinorodrigues/qyx5o6tv/" target="_blank">this</a> jsFiddle for an example (with toggle button).</p>
			<p>Alternatively, you could use server-side code to only generate the 2-option CSS code when the browser supports it.
				However, there is no server-side dark-mode support specification, and browsers will not send any requests identifying the color mode or even of its preference.
				One can however identify the browser version from the <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/User-Agent" target="_blank">User-Agent</a> request header, and then only generate the 2-option CSS code if the browser version is equal to or larger/later than the first support version of each browser.
				The following table is a guide:<br>
				<center><img src="../img/browser-dark-mode.jpg" />
				<br><small>Sourced from: <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/@media/prefers-color-scheme#Browser_compatibility" target="_blank">developer.mozilla.org</a></small></center></p>
			</div>
		</div>
	</main>

	<?php footerHere( 'injectPrismFooter', 'injectPrismThanks' ); ?>
</body>
</html>
