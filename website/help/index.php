<?php

include_once '../inc/functions.php';

function injectPrismHead() {
	?>
	<style>
		pre[class*=language-] {
			margin: 0 !important;
			padding: 0 !important;
			overflow: hidden !important;
		}
		.code-block {
			margin-bottom: 0;
		}
	</style>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/themes/prism-tomorrow.min.css" rel="stylesheet" media="(prefers-color-scheme: dark)" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/themes/prism.min.css" rel="stylesheet" media="(prefers-color-scheme: no-preference), (prefers-color-scheme: light)" />
	<?php
}

function injectPrismFooter() {
	?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/components/prism-core.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.20.0/plugins/autoloader/prism-autoloader.min.js"></script>
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
				<h3>Pre-Compiled CSS</h3>
				<p>Using the themes is as easy as downloading a CSS file and replacing the one that comes with Foundation.</p>
				<p>There are 2 versions of each theme:
					<ul>
						<li><code>foundation.css</code> The uncompressed variant - useful in debugging.</li>
						<li><code>foundation.min.css</code> The compressed variant - used for production websites.</li>
					</ul>
				</p>
				<p><small><b>NB:</b> Please do not hotlink to the files on this site as it will slow yours.</small></p>
			</div>
			<div class="cell large-6">
				<h3>Sass</h3>
				<p>Follow the instructions listed at <a href="https://get.foundation/sites/docs/sass.html" target="_blank">get.foundation/sites/docs/sass.html</a></p>
				<p>Then drop in the theme SASS files:

<pre><code class="code-block language-scss">@import 'settings';             // *Foundswatch variant
@import '../scss/foundation';   // Zurb Foundation <?= FOUNDATION_VERSION . PHP_EOL ?>
@include foundation-everything;
@import 'foundswatch';          // *Foundswatch variant
</code></pre>

				</p>
			</div>
			<div class="cell large-6">
				<h3>CDN</h3>
				<p class="text-alert">[UNDER DEVELOPMENT]</p>
				<dl>
					<dt class="h4">cdnjs</dt>
					<dd>The intent is to host this on <a href="https://cdnjs.cloudflare.com" target="_blank">cdnjs.cloudflare.com</a>, but we'll need <b>200</b> stars on GitHub.
						So go ahead and support this project. :) </dd>
					<dt class="h4">jsDelivr</dt>
					<dd>Another option is to link to our <code>dist</code> folder on GitHub via <a href="https://www.jsdelivr.com" target="_blank">www.jsdelivr.com</a>,
						but this will only become available once all the themes are ported and we tag a releas on GitHub.</dd>
				</dl>
				<p><small><b>NB:</b> Please do not hotlink to the files on this site as it will slow yours.</small></p>
			</div>
			<div class="cell large-6">
				<h3>Customisation</h3>
				<p>To modify a theme or create your own, follow the steps below in your terminal. You'll need to have
					<a target="_blank" href="https://help.github.com/articles/set-up-git">Git</a>,
					<a target="_blank" href="https://nodejs.org/">Node</a> and
					<a target="_blank" href="https://gulpjs.com/">Gulp</a> installed.
					<ol>
						<li>Download the repository: <code class="language-bash">git clone <a href="https://github.com/vinorodrigues/foundswatch.git">https://github.com/vinorodrigues/foundswatch.git</a></code></li>
						<li>Install Node dependencies: <code class="language-bash">npm install</code></li>
						<li>In the <code>/themesrc</code> folder, modify <code>_settings.scss</code> and <code>_foundswatch.scss</code> in one of the theme sub-folders, or duplicate a theme folder to create a new one.</li>
						<li>Run <code class="language-bash">gulp sass:themes</code> to build your themes.</li>
						<li>The compliled code will be in the <code>/website/themes</code> folder.</li>
					</ol>
			</div>
			<div class="cell small-12 clearfix">
				<h3>Dark Mode</h3>
				<p>Unfortunately, Foundation 6 is not designed to support “dark
					mode switching”, i.e. does not support the new
					“<code>prefers-color-scheme</code>” media query.</p>
				<p>You can however load 2 separate instances of the Foundation
					CSS that are very similar, but with one light and the other dark. For example:
					<ul>
						<li><a href="../themes/default/">Default</a> and <a href="../themes/dark/">Dark</a> <i>(As used on this site.)</i></li>
						<li><a href="../themes/flatly/">Flatly</a> and <a href="../themes/darkly/">Darkly</a></li>
					</ul></p>
				<p>
<pre><code class="code-block language-css">/* Alternative color mode (loaded first) */
&lt;link rel="stylesheet" href="foundatiuon<i>-dark</i>.css" media="(prefers-color-scheme: dark)"&gt;
/* Default and/or 'no preference' color mode (loaded last) */
&lt;link rel="stylesheet" href="foundation<i>-light</i>.css" media="(prefers-color-scheme: no-preference), (prefers-color-scheme: light)"&gt;
</code></pre>
				</p>
			</div>
		</div>
	</main>

	<?php footerHere( 'injectPrismFooter', 'injectPrismThanks' ); ?>
</body>
</html>
