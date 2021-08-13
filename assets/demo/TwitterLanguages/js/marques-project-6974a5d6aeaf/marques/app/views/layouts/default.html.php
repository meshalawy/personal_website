<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 *
 * Original Template Design by Jason Cole (http://jasoncole.ca/) and released into the Public Domain
 */
 
use lithium\security\Auth;

?>
<!doctype html>
<html>
<head>
	<?php echo $this->html->charset();?>
	<title>MARQues > <?php echo $this->title(); ?></title>
	<?php echo $this->html->style(array('marques')); ?>
	<?php echo $this->scripts(); ?>
</head>
<body>
	<div id="container">
		<div id="head">
			<h1>MARQues</h1>
			<?php if(Auth::check('default')) {?>
			<ul class="toplinks">
				<li><?=$this->html->link("Control Panel", array("Admin::index")); ?></li>
				<li><?=$this->html->link("Logout", array("Sessions::delete")); ?></li>
			</ul>
			<?php } ?>
		</div>
		<div id="body">
			<?php
				// output any flash message
				echo $this->flash->output();
				
				// output the page content
				echo $this->content();
			?>
		</div>
		<div id="tail">
			<br />
			<p>Powered by <?php echo $this->html->link('Lithium', 'http://lithify.me/'); ?>.</p>
		</div>
	</div>
</body>
</html>