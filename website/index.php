<?php

include_once 'inc/functions.php';

function injectFoundationIcons() {
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.min.css">
	<?php
}

headHere('Free themes for Foundation', 'injectFoundationIcons');

?>
<body>
	<?php headerHere(); ?>

	<?php if (true) : ?>
	<section class="hero hero-1">
		<div class="grid-container">
		<h1 class="text-center">&nbsp;<br>Free themes for Foundation<br>&nbsp;</h1>
		<div class="wrap row text-center">
			<iframe src="https://ghbtns.com/github-btn.html?user=vinorodrigues&repo=foundswatch&type=fork&count=false" frameborder="0" scrolling="0" width="53px" height="20px"></iframe>
			<iframe src="https://ghbtns.com/github-btn.html?user=vinorodrigues&repo=foundswatch&type=star&count=true" frameborder="0" scrolling="0" width="110px" height="20px"></iframe>
		</div>
		</div>
	</section>
	<?php endif; ?>

	<?php if (true) : ?>
	<article class="tout">
		<div class="grid-container">
			<div class="grid-x grid-margin-x">
				<div class="cell small-12 medium-6 large-4">
					<div class="icon"><i class="">B</i></div>
					<h4>Based on Bootswatch</h4>
					<p>A "clone" of Thomas Park's Bootswatch project...</p>
				</div>
				<div class="cell small-12 medium-6 large-4">
					<div class="icon"><i class="fi-social-zurb"></i></div>
					<h4>Themes for Foundation</h4>
					<p>... but for ZURB's Foundation for Sites</p>
				</div>
				<div class="cell small-12 medium-6 large-4">
					<div class="icon"><i class="fi-page"></i></div>
					<h4>Easy to Install</h4>
					<p>Simply download a CSS file and replace the one in Foundation. No messing around with hex values.</p>
				</div>
				<div class="cell small-12 medium-6 large-4">
					<div class="icon"><i class="fi-widget"></i></div>
					<h4>Customizable</h4>
					<p>Changes are contained in just two SASS files, enabling further customization and ensuring forward compatibility.</p>
				</div>
				<div class="cell small-12 medium-6 large-4">
					<div class="icon"><i class="fi-wrench"></i></div>
					<h4>Tuned for <?= FOUNDATION_VERSION ?></h4>
					<p>Themes are built for the latest version of Foundation.</p>
				</div>
				<div class="cell auto">
					<div class="icon"><i class="fi-social-github"></i></div>
					<h4>Open Source</h4>
					<p>Foundation themes are released under the MIT License and maintained by the community on GitHub.</p>
				</div>
			</div>
		</div>
	</article>
	<?php endif; ?>

	<main class="content grid-container">
		<div class="grid-x grid-margin-x" data-equalize-on="medium" data-equalizer="eq">
			<?php
			$cnt = 0;
			foreach ($themelist as $name => $desc) :
				$link = strtolower($name);
				if ('default' == $link) continue;
				$cnt++;
			?>
			<div class="cell medium-6 large-4">
				<div class="card theme-card" data-equalizer-watch="eq">
					<img src="themes/<?= $link ?>/screenshot.jpg" class="screenshot">
					<div class="card-section text-center">
						<h4><?= $name ?></h4>
						<p><?= $desc ?></p>
						<p>
							<a class="button" href="themes/<?= $link ?>/"><i class="fi-monitor"></i> Preview</a>
							<button class="button dropdown" type="button" data-toggle="dropdown-<?= $link ?>"><i class="fi-download"></i> Download</button>
							<div class="dropdown-pane" id="dropdown-<?= $link ?>" data-dropdown data-trap-focus="true" data-position="bottom" data-alignment="left" style="width: auto;">
								<ul class="vertical menu align-left">
									<li><a href="themes/<?= $link ?>/foundation.min.css">foundation.min.css</a></li>
									<li><a href="themes/<?= $link ?>/foundation.css">foundation.css</a></li>
									<li><a href="themes/<?= $link ?>/_settings.scss">_settings.scss</a></li>
									<li><a href="themes/<?= $link ?>/_foundswatch.scss">_foundswatch.scss</a></li>
								</ul>
							</div>
						</p>
					</div>
				</div>
			</div>
			<?php
			endforeach;

			switch ($cnt % 6) {
				case 1: $l = ['medium','large']; break;
				case 2: $l = ['large']; break;
				case 3: $l = ['medium-only']; break;
				case 4: $l = ['large','large']; break;
				case 5: $l = ['medium']; break;
				default: $l = [];  break;
			}
			$cnt = count($l);
			if ($cnt > 0)
				for ($i = 0; $i < $cnt; $i++) :
			?>
			<div class="cell medium-6 large-4 show-for-<?= $l[$i] ?> fluffer">
				<div class="card theme-card" data-equalizer-watch="eq">
					<picture><source srcset="img/screenshot.dark.jpg" media="(prefers-color-scheme: dark)" /><img src="img/screenshot.jpg" class="screenshot"></picture>
					<div class="card-section text-center">
						<h4>More Soon</h4>
						<p>We're still building this</p>
						<p>
							<span class="button disabled">Preview</span>
							<span class="dropdown button disabled">Download</span>
						</p>
					</div>
				</div>
			</div>
			<?php
				endfor;
			?>

		</div>
	</main>

	<?php footerHere(); ?>
</body>
</html>
