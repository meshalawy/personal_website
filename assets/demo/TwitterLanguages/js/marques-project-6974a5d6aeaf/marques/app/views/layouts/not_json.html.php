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
</head>
<body>
	<?php
		// output any flash message
		echo $this->flash->output();
		
		// output the page content
		echo $this->content();
	?>
</body>
</html>