<?php

if (!defined('INIT')) include_once '../inc/functions.php';

// global $theme;
// if (!isset($theme) && (false === $theme)) $theme = 'default';

function injectStyles() {
	?>
	<style>
		.cell {
			align: center;
		}
		.cell iframe {
			outline: 8px solid rgba(255,127,127,0.1);
		}
	</style>
	<?php
}

headHere('Themes', 'injectStyles');

?>
<body>
	<?php headerHere(); ?>

	<main class="grid-container">
		<div class="grid-x grid-margin-x">
			<div class="cell small-12">
				<h1>Themes</h1>
			</div>
			<?php
				foreach ($themelist as $name => $desc) {
					// if ('default' == strtolower($name)) continue;  // skip default
			?>
			<div class="cell small-12 medium-6">
				<iframe src="?theme=<?= $name ?>" width="500" height="250" frameborder="0" scrolling="no" class="float-center"></iframe>
				<p class="clearfix"></p>
				<p class="text-center"><b><?= $name ?>:</b> <a href="?preview=<?= $name ?>">Preview</a> | <a href="?theme=<?= $name ?>">Thumbnail</a></p>
			</div>
			<?php
				}
			?>
		</div>
	</main>

	<?php footerHere(); ?>
</body>
</html>
