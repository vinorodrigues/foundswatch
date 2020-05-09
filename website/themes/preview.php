<?php

if (!defined('INIT')) include_once '../inc/functions.php';

global $theme, $theme_name, $theme_desc, $the_path;

if (!isset($the_path)) $the_path = '..';

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


function add_on_menu_callback() {
	global $theme, $theme_name;
	$path = ABSPATH . 'themes/' . $theme;
?>
	<li class="has-submenu"><a href="#"><?= $theme_name ?></a>
		<ul class="submenu menu vertical" data-submenu>
			<li><a href="<?= $path ?>/foundation.min.css">foundation.min.css</a></li>
			<li><a href="<?= $path ?>/foundation.css">foundation.css</a></li>
			<li><a href="<?= $path ?>/_settings.scss">_settings.scss</a></li>
			<li><a href="<?= $path ?>/_foundswatch.scss">_foundswatch.scss</a></li>
		</ul>
	</li>
<?php
}

function injectStyles() {
	global $theme;
	?>
	<style>
		.site-logo { display: none; }
		.docs-example-text-align { outline: 2px dashed rgba(255,127,127,0.25); }
		.docs-example-orbit-slide { padding: 2rem 4rem; background: white; }
		.orbit-slide:nth-of-type(1) .docs-example-orbit-slide  { background: dodgerblue; }
		.orbit-slide:nth-of-type(2) .docs-example-orbit-slide  { background: rebeccapurple; }
		.orbit-slide:nth-of-type(3) .docs-example-orbit-slide  { background: darkgoldenrod; }
		.orbit-slide:nth-of-type(4) .docs-example-orbit-slide  { background: lightseagreen; }
	</style>
	<?php
}

headHere($theme_name, 'injectStyles');

?>
<body>
	<?php headerHere('add_on_menu_callback'); ?>

	<main class="grid-container content">
		<!-- Heading ======================================================= -->
		<div class="grid-x grid-margin-x preview-section">
			<div class="cell small-12">
				<h1 id="top"><?= $theme_name ?></h1>
				<p class="lead"><?= $theme_desc ?></p>
			</div>
		</div>

		<!-- Top Bar ======================================================= -->
		<?php if (true) : ?>
		<div class="grid-x grid-margin-x preview-section clearfix">
			<div class="cell small-12">
				<h2 id="top-bar" class="p-t-2 p-b-2">Top Bar</h2>

				<div class="title-bar" data-responsive-toggle="responsive-menu" data-hide-for="medium" style="display: none;">
					<button class="menu-icon" type="button" data-toggle="responsive-menu"></button>
					<div class="title-bar-title">Menu</div>
				</div>
				<div class="top-bar" id="responsive-menu">
					<div class="top-bar-left">
						<ul class="dropdown menu" data-dropdown-menu>
							<li class="menu-text">Site Title</li>
							<li class="has-submenu">
								<a href="#">One</a>
								<ul class="submenu menu vertical" data-submenu>
									<li><a href="#">One</a></li>
									<li><a href="#">Two</a></li>
									<li><a href="#">Three</a></li>
								</ul>
							</li>
							<li><a href="#">Two</a></li>
							<li><a href="#">Three</a></li>
						</ul>
					</div>
					<div class="top-bar-right">
						<ul class="menu">
							<li><input type="search" placeholder="Search"></li>
							<li><button type="button" class="button">Search</button></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<!-- Buttons ======================================================= -->
		<?php if (true) : ?>
		<div class="grid-x grid-margin-x preview-section clearfix">
			<div class="cell small-12">
				<h2 id="buttons" class="p-t-2 p-b-2">Buttons</h2>
			</div>
			<div class="cell medium-7 clearfix">
				<a class="button primary" href="#">Primary</a>
				<a class="button secondary" href="#">Secondary</a>
				<a class="button success" href="#">Success</a>
				<a class="button warning" href="#">Warning</a>
				<a class="button alert" href="#">Alert</a>
				<br>
				<a class="hollow button primary" href="#">Primary</a>
				<a class="hollow button secondary" href="#">Secondary</a>
				<a class="hollow button success" href="#">Success</a>
				<a class="hollow button warning" href="#">Warning</a>
				<a class="hollow button alert" href="#">Alert</a>
				<br>
				<a class="button primary disabled" href="#">Primary</a>
				<a class="button secondary disabled" href="#">Secondary</a>
				<a class="button success" href="#" disabled>Success</a>
				<a class="button warning" href="#" disabled>Warning</a>
				<a class="button alert" href="#" disabled>Alert</a>
				<br>
				<a class="clear button primary" href="#">Primary</a>
				<a class="clear button secondary" href="#">Secondary</a>
				<a class="clear button success" href="#">Success</a>
				<a class="clear button warning" href="#">Warning</a>
				<a class="clear button alert" href="#">Alert</a>
				<br>
				<a class="button dropdown" href="#" data-toggle="dd1">Default</a>
				<a class="button primary dropdown" href="#" data-toggle="dd1">Primary</a>
				<a class="button success dropdown" href="#" data-toggle="dd1">Success</a>
				<a class="button alert dropdown" href="#" data-toggle="dd1">Alert</a>
				<div class="dropdown-pane" id="dd1" data-dropdown data-trap-focus="true" data-position="bottom" data-alignment="left" style="width: auto;">
					<ul class="vertical menu align-left">
						<li><a href="#">Item One</a></li>
						<li><a href="#">Item Two</a></li>
					</ul>
				</div>
				<br>
				<button class="button large">Large</button>
				<button class="button info">Info</button>
				<button class="button small">Small</button>
				<button class="button tiny">Tiny</button>
			</div>
			<div class="cell medium-5">
				<button class="button expanded">Expanded</button>
				<br>
				<div class="primary button-group">
					<a class="button is-active">Button</a>
					<a class="button">Button</a>
					<a class="button disabled">Disabled</a>
				</div>
				<br>
				<div class="button-group">
					<a class="secondary button">Secondary</a>
					<a class="success button">Success</a>
					<a class="warning button">Warning</a>
					<a class="alert button">Alert</a>
					<a class="clear button">Clear</a>
				</div>
				<br>
				<div class="primary button-group no-gaps">
					<a class="button">No</a>
					<a class="button">More</a>
					<a class="button">Gaps</a>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<!-- Typography ==================================================== -->
		<?php if (true) : ?>
		<div class="grid-x grid-margin-x preview-section clearfix">
			<div class="cell small-12">
				<h2 id="typography" class="p-t-2 p-b-2">Typography</h2>
			</div>
			<div class="cell medium-4 clearfix">
				<h1>Heading 1</h1>
				<h2>Heading 2</h2>
				<h3>Heading 3</h3>
				<h4>Heading 4</h4>
				<h5>Heading 5</h5>
				<h6>Heading 6</h6>
				<h3>Heading <small>with muted text</small></h3>
				<hr>
				<p class="lead">Leading nullam ullamcorper nisl vel elit ornare, et porttitor urna sollicitudin.</p>
			</div>
			<div class="cell medium-4">
				<h3>Example body text</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed <a href="#">feugiat et sapien</a> vel condimentum.</p>
				<p><small>This line of text is meant to be treated as fine print.</small></p>
				<p>The following is <strong>rendered as</strong> <b>bold text</b>.</p>
				<p>The following is <em>rendered as</em> <i>italicized text</i>.</p>
				<p>An abbreviation of the word attribute is <abbr title="attribute">attr</abbr>.</p>
				<p><code>function ThisIsCode();</code></p>

				<ol>
					<li>List item</li>
					<li>List item
						<ul>
							<li>Nested list item</li>
						</ul>
					</li>
					<li>List item</li>
				</ol>
			</div>
			<div class="cell medium-4">
				<p>Statistics<br>
					<div class="stat">256</div>
				</p>

				<p>This is a quote:</p>
				<blockquote>
					Those people who think they know everything are a great annoyance to those of us who do.
					<cite>Isaac Asimov</cite>
				</blockquote>

				<dl>
					<dt>Definition</dt>
					<dd>Donec non tristique est, a faucibus est.</dd>
					<dt>List</dt>
					<dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</dd>
				</dl>

				<ul>
					<li>List item</li>
					<li>List item
						<ul>
							<li>Nested list item</li>
						</ul>
					</li>
					<li>List item</li>
				</ul>

			</div>
			<div class="cell medium-12">
				<p class="text-left docs-example-text-align"><b>This text is left-aligned.</b> Fusce sit amet purus non tellus hendrerit congue eget sit amet nisl.</p>
				<p class="text-right docs-example-text-align"><b>This text is right-aligned.</b> Fusce sit amet purus non tellus hendrerit congue eget sit amet nisl.</p>
				<p class="text-center docs-example-text-align"><b>This text is center-aligned.</b> Fusce sit amet purus non tellus hendrerit congue eget sit amet nisl.</p>
				<p class="text-justify docs-example-text-align"><b>This text is justified.</b> Fusce sit amet purus non tellus hendrerit congue eget sit amet nisl.</p>
			</div>
		</div>
		<?php endif; ?>

		<!-- Tables ======================================================== -->
		<?php if (true) : ?>
		<div class="grid-x grid-margin-x preview-section clearfix">
			<div class="cell small-12">
				<h2 id="tables" class="p-t-2 p-b-2">Tables</h2>
			</div>
			<div class="cell small-12 clearfix">
				<table class="hover">
					<thead>
						<tr>
							<th width="200">Table Header</th>
							<th>Table Header</th>
							<th width="150">Table Header</th>
							<th width="150">Table Header</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Content Goes Here</td>
							<td>This is longer content Donec id elit non mi porta gravida at eget metus.</td>
							<td>Content Goes Here</td>
							<td>Content Goes Here</td>
						</tr>
						<tr>
							<td>Content Goes Here</td>
							<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
							<td>Content Goes Here</td>
							<td>Content Goes Here</td>
						</tr>
						<tr>
							<td>Content Goes Here</td>
							<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
							<td>Content Goes Here</td>
							<td>Content Goes Here</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<?php endif; ?>

		<!-- Forms ========================================================= -->
		<?php if (true) : ?>
		<div class="grid-x grid-margin-x preview-section clearfix">
			<div class="cell small-12">
				<h2 id="forms" class="p-t-2 p-b-2">Forms</h2>
			</div>
			<div class="cell medium-6 clearfix">
				<form>
					<legend>Legend</legend>
					<br>
					<label>Input Label
						<input type="email" placeholder="Email">
					</label>
					<br>
					<label>Password
						<input type="password" placeholder="Password">
					</label>
					<p class="help-text">Your password must have at least 10 characters, a number, and an Emoji.</p>
					<br>
					<label>How many puppies?
						<input type="number" value="100">
					</label>
					<br>
					<label>What books did you read over summer break?
						<textarea placeholder="None"></textarea>
					</label>
					<br>
					<label>Select Menu
						<select>
							<option value="husker">Husker</option>
							<option value="starbuck">Starbuck</option>
							<option value="hotdog">Hot Dog</option>
							<option value="apollo">Apollo</option>
						</select>
					</label>
					<br>
					<label>Multiple Select Menu
						<select multiple>
							<option value="showboat">Showboat</option>
							<option value="redwing">Redwing</option>
							<option value="narcho">Narcho</option>
							<option value="hardball">Hardball</option>
						</select>
					</label>
					<br>
					<fieldset class="">
						<legend>Check these out</legend>
						<input id="checkbox1" type="checkbox" checked><label for="checkbox1">Checkbox 1</label>
						<input id="checkbox2" type="checkbox"><label for="checkbox2">Checkbox 2</label>
						<input id="checkbox3" type="checkbox" disabled><label for="checkbox3" disabled>Checkbox 3</label>
					</fieldset>
					<br>
					<fieldset class="fieldset">
						<legend>Choose Your Favorite</legend>
						<input type="radio" name="pokemon" value="Red" id="pokemonRed" checked><label for="pokemonRed">Red</label>
						<input type="radio" name="pokemon" value="Blue" id="pokemonBlue"><label for="pokemonBlue">Blue</label>
						<input type="radio" name="pokemon" value="Yellow" id="pokemonYellow" disabled><label for="pokemonYellow" disabled>Yellow</label>
					</fieldset>
					<br>
					<div class="grid-x grid-margin-x">
						<div class="small-3 cell">
							<label for="middle-label" class="text-right middle">Label</label>
						</div>
						<div class="small-9 cell">
					  		<input type="text" id="middle-label" placeholder="Right- and middle-aligned text input">
						</div>
					</div>
					<br>
					<div class="input-group">
						<span class="input-group-label">$</span>
						<input class="input-group-field" type="number">
						<div class="input-group-button">
							<input type="submit" class="button" value="Submit" placeholder="Input Group">
						</div>
					</div>
				</form>
			</div>
			<div class="cell medium-6">
				<h3>Abide Demo</h3>

				<form data-abide novalidate><!-- novalidate is required -->
				  <div data-abide-error class="alert callout" style="display: none;">
				    <p><i class="fi-alert" style="font-style: normal;">&#9888;</i> There are some errors in your form.</p>
				  </div>
				  <div class="clearfix">
				    <div class="grid-x grid-margin-x">
				      <div class="cell small-12">
				        <label class="is-invalid-label">Number Required
				          <input type="text" placeholder="1234" aria-describedby="example1Hint1" aria-errormessage="example1Error1" required pattern="number" class="is-invalid-input" data-invalid aria-invalid="true">
				          <span class="form-error is-visible" role="alert">
				            Yo, you had better fill this out, it's required.
				          </span>
				        </label>
				      <p class="help-text" id="example1Hint1">Here's how you use this input field!</p>
				      </div>
				      <div class="cell small-12">
				        <label>Password Required
				          <input type="password" id="password" placeholder="yeti4preZ" aria-describedby="example1Hint2" aria-errormessage="example1Error2" required >
				          <span class="form-error">
				            I'm required!
				          </span>
				        </label>
				        <p class="help-text" id="example1Hint2">Enter a password please.</p>
				      </div>
				      <div class="cell small-12">
				        <label>Re-enter Password
				          <input type="password" placeholder="yeti4preZ" aria-describedby="example1Hint3" aria-errormessage="example1Error3" required pattern="alpha_numeric" data-equalto="password">
				          <span class="form-error">
				            Hey, passwords are supposed to match!
				          </span>
				        </label>
				        <p class="help-text" id="example1Hint3">This field is using the `data-equalto="password"` attribute, causing it to match the password field above.</p>
				      </div>
				    </div>
				  </div>
				  <div class="clearfix">
				    <div class="grid-x grid-margin-x">
				      <div class="cell large-6">
				        <label>URL Pattern, not required, but throws error if it doesn't match the Regular Expression for a valid URL.
				          <input type="text" placeholder="https://get.foundation" pattern="url">
				        </label>
				      </div>
				      <div class="cell large-6">
				        <label>Website Pattern, not required, but throws error if it doesn't match the Regular Expression for a valid URL or a Domain.
				          <input type="text" placeholder="https://get.foundation or get.foundation" pattern="website">
				        </label>
				      </div>
				    </div>
				  </div>
				  <div class="clearfix">
				    <div class="grid-x grid-margin-x">
				      <div class="cell large-6">
				        <label>European Cars, Choose One, it can't be the blank option.
				          <select id="select" required>
				            <option value=""></option>
				            <option value="volvo">Volvo</option>
				            <option value="saab">Saab</option>
				            <option value="mercedes">Mercedes</option>
				            <option value="audi">Audi</option>
				          </select>
				        </label>
				      </div>
				      <fieldset class="cell large-6">
				        <legend>Check these out</legend>
				        <input id="checkbox1" type="checkbox"><label for="checkbox1">Checkbox 1</label>
				        <input id="checkbox2" type="checkbox" required><label for="checkbox2">Checkbox 2</label>
				        <input id="checkbox3" type="checkbox"><label for="checkbox3">Checkbox 3</label>
				      </fieldset>
				    </div>
				  </div>
				  <div class="clearfix">
				    <div class="grid-x grid-margin-x">
				      <fieldset class="cell large-6">
				        <legend>Choose Your Favorite - not required, you can leave this one blank.</legend>
				        <input type="radio" name="pockets" value="Red" id="pocketsRed"><label for="pocketsRed">Red</label>
				        <input type="radio" name="pockets" value="Blue" id="pocketsBlue"><label for="pocketsBlue">Blue</label>
				        <input type="radio" name="pockets" value="Yellow" id="pocketsYellow"><label for="pocketsYellow">Yellow</label>
				      </fieldset>
				      <fieldset class="cell large-6">
				        <legend>Choose Your Favorite, and this is required, so you have to pick one.</legend>
				        <input type="radio" name="pokemon" value="Red" id="pokemonRed"><label for="pokemonRed">Red</label>
				        <input type="radio" name="pokemon" value="Blue" id="pokemonBlue" required><label for="pokemonBlue">Blue</label>
				        <input type="radio" name="pokemon" value="Yellow" id="pokemonYellow"><label for="pokemonYellow">Yellow</label>
				      </fieldset>
				    </div>
				  </div>
				  <div class="clearfix">
				    <div class="grid-x grid-margin-x">
				      <fieldset class="cell large-6">
				        <button class="button" type="submit" value="Submit">Submit</button>
				      </fieldset>
				      <fieldset class="cell large-6">
				        <button class="button" type="reset" value="Reset">Reset</button>
				      </fieldset>
				    </div>
				  </div>
				</form>
			</div>
		</div>
		<?php endif; ?>

		<!-- Navigation ==================================================== -->
		<?php if (true) : ?>
		<div class="grid-x grid-margin-x preview-section clearfix">
			<div class="cell small-12">
				<h2 id="navigation" class="p-t-2 p-b-2">Navigation</h2>
			</div>
			<div class="cell medium-6 clearfix">

				<h4>Menu</h4>
				<ul class="menu">
					<li class="menu-text">Menu</li>
					<li class="is-active"><a href="#">One</a></li>
					<li><a href="#">Two</a></li>
					<li><a href="#">Three</a></li>
					<li><a href="#">Four</a></li>
				</ul>

				<br>

				<ul class="dropdown menu" data-dropdown-menu>
					<li class="menu-text">with dropdown</li>
					<li><a href="#">One</a></li>
					<li class="is-dropdown-submenu-parent"><a href="#">Two</a>
						<ul class="menu">
							<li><a href="#">Item 3</a></li>
							<li><a href="#">Item 4</a></li>
						</ul>
					</li>
					<li><a href="#">Three</a></li>
				</ul>

				<br>

				<h4>Drilldown Menu</h4>
				<ul class="vertical menu drilldown" style="max-width: 250px;" data-auto-height="true" data-animate-height="true" data-drilldown>
					<li><a href="#">One</a></li>
					<li><a href="#">Two</a>
						<ul class="menu vertical nested is-active">
							<li><a href="#">Two A</a></li>
							<li><a href="#">Two B</a></li>
							<li><a href="#">Two C</a></li>
							<li><a href="#">Two D</a></li>
						</ul>
					</li>
					<li><a href="#">Three</a></li>
					<li><a href="#">Four</a></li>
				</ul>

			</div>
			<div class="cell medium-6">

				<h4>Accordian Menu</h4>
				<ul class="vertical menu accordion-menu" style="max-width: 250px;" data-accordion-menu>
					<li><a href="#">Item 1</a>
						<ul class="menu vertical nested">
							<li><a href="#">Item 1A</a></li>
							<li><a href="#">Item 1B</a></li>
						</ul>
					</li>
					<li><a href="#">Item 2</a></li>
				</ul>

				<br> <!-- -->

				<h4>Pagination</h4>
				<nav aria-label="Pagination">
					<ul class="pagination">
						<li class="pagination-previous disabled">Previous <span class="show-for-sr">page</span></li>
						<li class="current"><span class="show-for-sr">You're on page </span>1</li>
						<li><a href="#" aria-label="Page 2">2</a></li>
						<li><a href="#" aria-label="Page 3">3</a></li>
						<li><a href="#" aria-label="Page 4">4</a></li>
						<li class="ellipsis" aria-hidden="true"></li>
						<li><a href="#" aria-label="Page 12">12</a></li>
						<li><a href="#" aria-label="Page 13">13</a></li>
						<li class="pagination-next"><a href="#" aria-label="Next page">Next <span class="show-for-sr">page</span></a></li>
					</ul>
				</nav>

				<br>

				<h4>Breadcrumbs</h4>
				<nav aria-label="You are here:" role="navigation">
					<ul class="breadcrumbs">
						<li><a href="#">Home</a></li>
						<li><a href="#">Features</a></li>
						<li class="disabled">Gene Splicing</li>
						<li><span class="show-for-sr">Current: </span> Cloning</li>
					</ul>
				</nav>

			</div>
		</div>
		<?php endif; ?>

		<!-- Containers ==================================================== -->
		<?php if (true) : ?>
		<div class="grid-x grid-margin-x preview-section clearfix">
			<div class="cell small-12">
				<h2 id="containers" class="p-t-2 p-b-2">Containers</h2>
			</div>
			<div class="cell medium-6 clearfix">

				<h4>Accordian</h4>
				<ul class="accordion" data-accordion>
					<li class="accordion-item is-active" data-accordion-item>
						<a href="#" class="accordion-title">Accordion 1</a>
						<div class="accordion-content" data-tab-content>
							<p>Panel 1. Lorem ipsum dolor</p>
							<a href="#">Nowhere to Go</a>
						</div>
					</li>
					<li class="accordion-item" data-accordion-item>
						<a href="#" class="accordion-title">Accordion 2</a>
						<div class="accordion-content" data-tab-content>
							<p>Panel 2. Lorem ipsum dolor</p>
							<a href="#">Nowhere to Go</a>
						</div>
					</li>
				</ul>

				<br>

				<h4>Tabs</h4>
				<ul class="tabs" data-tabs id="example-tabs">
					<li class="tabs-title is-active"><a href="#panel1" aria-selected="true">Tab 1</a></li>
					<li class="tabs-title"><a href="#panel2">Tab 2</a></li>
					<li class="tabs-title"><a href="#panel3">Tab 3</a></li>
				</ul>
				<div class="tabs-content" data-tabs-content="example-tabs">
					<div class="tabs-panel is-active" id="panel1">
						<h5>One</h5>
						<p>Check me out! I'm a super cool Tab panel with text content!</p>
					</div>
					<div class="tabs-panel" id="panel2">
						<h5>Two</h5>
						<img class="thumbnail" src="https://placekitten.com/640/360">
					</div>
					<div class="tabs-panel" id="panel3">
						<h5>Three</h5>
						<form>
							<textarea></textarea>
							<button class="button">I do nothing!</button>
						</form>
					</div>
				</div>

				<br>

				<h4>Off-Canvas</h4>
				<center>
				<button type="button" class="button secondary" data-toggle="offCanvas">Open</button>
				</center>
				<div class="off-canvas position-left" id="offCanvas" data-off-canvas>
					<button class="close-button" aria-label="Close menu" type="button" data-close>
						<span aria-hidden="true">&times;</span>
					</button>

					<br class="h3">

					<!-- Menu -->
					<ul class="vertical menu">
						<li><a href="#">Foundswatch</a></li>
						<li><a href="#">Dot</a></li>
						<li><a href="#">Com</a></li>
						<li><a href="#">Slash</a></li>
						<li><a href="#"><?= $theme_name ?></a></li>
					</ul>

				</div>

			</div>
			<div class="cell medium-6">

				<h4>Card</h4>
				<div class="card" style="width: 300px;">
					<div class="card-divider">
						This is a header
					</div>
					<img src="https://dummyimage.com/640x480/777/fff.jpg&text=%3Cimg+%20%2F%3E" width="640" height="480">
					<div class="card-section">
						<h4>This is a card.</h4>
						<p>It has an easy to override visual style, and is appropriately subdued.</p>
					</div>
				</div>

				<br>

				<h4>Media Object</h4>
				<div class="media-object">
					<div class="media-object-section">
						<div class="thumbnail">
							<img src="https://www.fillmurray.com/128/128">
						</div>
					</div>
					<div class="media-object-section main-section">
						<h4>Dreams feel real while we're in them.</h4>
						<p>I'm going to improvise. Listen, there's something you should know about me... about inception. An idea is like a virus, resilient, highly contagious. The smallest seed of an idea can grow. It can grow to define or destroy you.</p>
					</div>
				</div>

			</div>

			<div class="cell small-12 clearfix">
				<h4>Callout</h4>
			</div>
			<div class="cell medium-6 large-4 clearfix">
				<div class="primary callout">
					<h5>This is a primary callout</h5>
					<p>It has an easy to override visual style, and is appropriately subdued.</p>
					<a href="#">Take this.</a>
				</div>
				<div class="callout secondary" data-closable>
					<h5>This is a secondary callout</h5>
					<a href="#">Take this.</a>
					<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
			<div class="cell medium-6 large-4">
				<div class="success callout">
					<h5>This is a success callout</h5>
					<hr>
					<a href="#">Take this.</a>
				</div>
				<div class="warning callout" data-closable>
					<h5>This is a warning callout</h5>
					<a href="#">Take this.</a>
					<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="callout">
					This is a normal callout
				</div>
			</div>
			<div class="cell medium-6 large-4">
				<div class="alert callout">
					<h5>This is an alert callout</h5>
					<a href="#">Take this.</a>
				</div>
				<div class="callout large" data-closable>
					<h5>This is a large callout</h5>
					<p>It has an easy to override visual style, and is appropriately subdued.</p>
					<a href="#">Take this.</a>
					<button class="close-button" aria-label="Dismiss alert" type="button" data-close>
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<!-- Media ========================================================= -->
		<?php if (true) : ?>
		<div class="grid-x grid-margin-x preview-section clearfix">
			<div class="cell small-12">
				<h2 id="media" class="p-t-2 p-b-2">Media</h2>
			</div>
			<div class="cell medium-6 clearfix">

				<h4>Badge</h4>
				<span class="badge primary">1</span>
				<span class="badge secondary">2</span>
				<span class="badge success">S</span>
				<span class="badge alert">A</span>
				<span class="badge warning">W</span>
				<span class="badge">B</span>

				<br>&nbsp;<br>

				<h4>Label</h4>
				<span class="label primary">Primary</span>
				<span class="label secondary">Secondary</span>
				<span class="label success">Success</span>
				<span class="label alert">Alert</span>
				<span class="label warning">Warning</span>
				<span class="label">Label</span>

				<br>&nbsp;<br>

				<h4>Slider</h4>
				<div class="slider" data-slider data-initial-start="50" data-end="200">
					<span class="slider-handle"  data-slider-handle role="slider" tabindex="1"></span>
					<span class="slider-fill" data-slider-fill></span>
					<input type="hidden">
				</div>

			</div>
			<div class="cell medium-6">

				<h4>Progress Bar</h4>
				<div class="progress">
					<div class="progress-meter" style="width: 10%">
						<p class="progress-meter-text">10%</p>
					</div>
				</div>
				<div class="primary progress" role="progressbar" tabindex="0" aria-valuenow="25" aria-valuemin="0" aria-valuetext="25 percent" aria-valuemax="100">
					<div class="progress-meter" style="width: 25%">
						<p class="progress-meter-text">25%</p>
					</div>
				</div>
				<div class="secondary progress">
					<div class="progress-meter" style="width: 40%">
						<p class="progress-meter-text">40%</p>
					</div>
				</div>
				<div class="success progress">
					<div class="progress-meter" style="width: 55%">
						<p class="progress-meter-text">55%</p>
					</div>
				</div>
				<div class="warning progress">
					<div class="progress-meter" style="width: 70%">
						<p class="progress-meter-text">70%</p>
					</div>
				</div>
				<div class="alert progress">
					<div class="progress-meter" style="width: 95%">
						<p class="progress-meter-text">95%</p>
					</div>
				</div>

				<br>

				<h4>Tooltip</h4>
				<p>The <span data-tooltip tabindex="1" title="Fancy word for a beetle.">scarabaeus</span> hung.</p>

			</div>
			<div class="cell medium-6 clearfix">

				<h4>Responsive Embed</h4>
				<div class="responsive-embed widescreen">
					<iframe src="https://www.youtube.com/embed/_44h6fL9sgU" frameborder="0" width="560" height="315" allowfullscreen></iframe>
				</div>

			</div>
			<div class="cell medium-6">

				<h4>Thumbnail</h4>
				<div class="grid-x grid-margin-x">
					<div class="cell small-4 text-center">
						<img class="thumbnail" src="https://dummyimage.com/128x128/777/fff.jpg" alt="">
					</div>
					<div class="cell small-4 text-center">
						<img class="thumbnail" src="https://dummyimage.com/128x128/777/fff.jpg" alt="">
					</div>
					<div class="cell small-4 text-center">
						<a href="#" class="thumbnail"><img src="https://dummyimage.com/128x128/777/fff.jpg&text=Link+128+x+128" alt=""></a>
					</div>
				</div>

				<br>

				<h4>Switch</h4>
				<div class="grid-x grid-margin-x">
					<div class="cell small-6 text-center">

						<div class="switch">
						  <input class="switch-input" id="exampleRadioSwitch1" type="radio" checked name="testGroup">
						  <label class="switch-paddle" for="exampleRadioSwitch1">
						    <span class="show-for-sr">Bulbasaur</span>
						  </label>
						</div>
						<div class="switch">
						  <input class="switch-input" id="exampleRadioSwitch2" type="radio" name="testGroup">
						  <label class="switch-paddle" for="exampleRadioSwitch2">
						    <span class="show-for-sr">Bulbasaur</span>
						  </label>
						</div>
						<div class="switch">
						  <input class="switch-input" id="exampleRadioSwitch3" type="radio" name="testGroup" disabled>
						  <label class="switch-paddle" for="exampleRadioSwitch3">
						    <span class="show-for-sr">Bulbasaur</span>
						  </label>
						</div>

						<div class="switch">
						  <input class="switch-input" id="yes-no" type="checkbox" name="exampleSwitch">
						  <label class="switch-paddle" for="yes-no">
						    <span class="show-for-sr">Power</span>
						    <span class="switch-active text-center" aria-hidden="true">Yes</span>
						    <span class="switch-inactive text-center" aria-hidden="true">No</span>
						  </label>
						</div>

					</div>
					<div class="cell small-6 text-center">

						<div class="switch tiny">
						  <input class="switch-input" id="tinySwitch" type="checkbox" name="exampleSwitch">
						  <label class="switch-paddle" for="tinySwitch">
						    <span class="show-for-sr">Tiny Sandwiches Enabled</span>
						  </label>
						</div>
						<div class="switch small">
						  <input class="switch-input" id="smallSwitch" type="checkbox" name="exampleSwitch">
						  <label class="switch-paddle" for="smallSwitch">
						    <span class="show-for-sr">Small Portions Only</span>
						  </label>
						</div>
						<div class="switch">
						  <input class="switch-input" id="mediumSwitch" type="checkbox" name="exampleSwitch">
						  <label class="switch-paddle" for="mediumSwitch">
						    <span class="show-for-sr">Medium all the things</span>
						  </label>
						</div>
						<div class="switch large">
						  <input class="switch-input" id="largeSwitch" type="checkbox" name="exampleSwitch">
						  <label class="switch-paddle" for="largeSwitch">
						    <span class="show-for-sr">Show Large Elephants</span>
						  </label>
						</div>

					</div>
				</div>

			</div>
		</div>
		<?php endif; ?>


		<!-- Orbit ========================================================= -->
		<?php if (false) : ?>
		<div class="grid-x grid-margin-x preview-section clearfix">
			<div class="cell small-12">
				<h2 id="orbit" class="p-t-2 p-b-2">Orbit</h2>
			</div>
			<div class="cell small-12">


				<div class="orbit" role="region" aria-label="Favorite Text Ever" data-orbit>
				  <ul class="orbit-container">
				    <button class="orbit-previous" aria-label="previous"><span class="show-for-sr">Previous Slide</span>&#9664;</button>
				    <button class="orbit-next" aria-label="next"><span class="show-for-sr">Next Slide</span>&#9654;</button>
				    <li class="is-active orbit-slide">
				      <div class="docs-example-orbit-slide">
				        <p><strong>This is dodgerblue.</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				      </div>
				    </li>
				    <li class="orbit-slide">
				      <div class="docs-example-orbit-slide">
				        <p><strong>This is rebeccapurple.</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				      </div>
				    </li>
				    <li class="orbit-slide">
				      <div class="docs-example-orbit-slide">
				        <p><strong>This is darkgoldenrod.</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				      </div>
				    </li>
				    <li class="orbit-slide">
				      <div class="docs-example-orbit-slide">
				        <p><strong>This is lightseagreen.</strong> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				      </div>
				    </li>
				  </ul>
				  <nav class="orbit-bullets">
				    <button class="is-active" data-slide="0"><span class="show-for-sr">First slide details.</span><span class="show-for-sr">Current Slide</span></button>
				    <button data-slide="1"><span class="show-for-sr">Second slide details.</span></button>
				    <button data-slide="2"><span class="show-for-sr">Third slide details.</span></button>
				    <button data-slide="3"><span class="show-for-sr">Fourth slide details.</span></button>
				  </nav>
				</div>


			</div>
		</div>
		<?php endif; ?>


		<!-- Reveal ======================================================== -->
		<?php if (true) : ?>
		<div class="grid-x grid-margin-x preview-section clearfix">
			<div class="cell small-12">
				<h2 id="reveal" class="p-t-2 p-b-2">Reveal<small> (Modal)</small></h2>
			</div>
			<div class="cell small-6 medium-3">
				<p><a class="button" data-toggle="exampleModal5" aria-controls="exampleModal5">Click me for a tiny modal</a></p>
				<div class="tiny reveal" id="exampleModal5" data-reveal>
				  <p>Oh! I'm so tiny!</p>
				  <button class="close-button" data-close aria-label="Close reveal" type="button"><span aria-hidden="true">&times;</span></button>
				</div>
			</div>
			<div class="cell small-6 medium-3">
				<p><a class="button" data-toggle="exampleModal6">Click me for a small modal</a></p>
				<div class="small reveal" id="exampleModal6" data-reveal>
				  <p>I may be small, but I've got a big heart!</p>
				  <button class="close-button" data-close aria-label="Close reveal" type="button"><span aria-hidden="true">&times;</span></button>
				</div>
			</div>
			<div class="cell small-6 medium-3">
				<p><a class="button" data-toggle="exampleModal7">Click me for a large modal</a></p>
				<div class="large reveal" id="exampleModal7" data-reveal>
				  <p>I'm big, like bear!</p>
				  <button class="close-button" data-close aria-label="Close reveal" type="button"><span aria-hidden="true">&times;</span></button>
				</div>
			</div>
			<div class="cell small-6 medium-3">
				<p><button class="button" data-toggle="exampleModal8">Click me for a full-screen modal</button></p>
				<div class="full reveal" id="exampleModal8" data-reveal>
				  <h1>This is a full page reveal</h1>
				  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse tempor, lectus a vulputate sollicitudin, purus sapien mollis enim, et posuere ligula orci eget eros. Pellentesque in viverra tortor. Sed sagittis fringilla tortor ut efficitur. Sed pharetra porttitor enim, vel pulvinar turpis suscipit ac. Sed condimentum, lectus et elementum tincidunt, nisi justo vulputate justo, id suscipit tellus orci sit amet metus. Mauris suscipit neque eget lorem fringilla luctus. Ut rhoncus ac lorem nec ultricies. Nam rhoncus auctor diam a consectetur. Aenean faucibus auctor arcu quis dignissim. Quisque a nunc nisl. Nunc ultrices vestibulum odio. Interdum et malesuada fames ac ante ipsum primis in faucibus. In hac habitasse platea dictumst. Quisque elit massa, fringilla at nisi vel, ullamcorper dictum lectus. Nam molestie, orci sit amet volutpat ultrices, turpis erat consequat justo, sit amet lacinia risus libero nec ante.</p>
				  <p><button onclick="$('#exampleModal8').foundation('close');" class="button">Close</button></p>
				  <button class="close-button" data-close aria-label="Close reveal" type="button">
				    <span aria-hidden="true">&times;</span>
				  </button>
				</div>
			</div>
		</div>
		<?php endif; ?>


		<!-- =============================================================== -->
		<hr>
	</main>


	<?php footerHere(); ?>
	<script>
		$(document)
			// field element is invalid
			.on("invalid.zf.abide", function(ev,elem) {
				console.log("Field id "+ev.target.id+" is invalid");
			})
			// field element is valid
			.on("valid.zf.abide", function(ev,elem) {
				console.log("Field name "+elem.attr('name')+" is valid");
			})
			// form validation failed
			.on("forminvalid.zf.abide", function(ev,frm) {
				console.log("Form id "+ev.target.id+" is invalid");
			})
			// form validation passed, form will submit if submit event not returned false
			.on("formvalid.zf.abide", function(ev,frm) {
				console.log("Form id "+frm.attr('id')+" is valid");
			// ajax post form
			})
			// to prevent form from submitting upon successful validation
			.on("submit", function(ev) {
				ev.preventDefault();
				console.log("Submit for form id "+ev.target.id+" intercepted");
			});
	</script>
</body>
</html>
