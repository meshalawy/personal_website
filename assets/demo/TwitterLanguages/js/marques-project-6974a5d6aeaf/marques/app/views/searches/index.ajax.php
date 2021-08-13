<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
 /**
  * return the search results data in a XML encoded format
  */
?>
<?php if(!empty($results)) {
echo '<items>';
	foreach($results as $result) {
		echo '<item id="' . $result['id'] . '" type="' . $result['type'] . '" coords="' . $result['coords'] . '">';
			echo '<result>' . $result['result'] . '</result>';
		echo '</item>';
	}
echo '</items>'; 
} else {
echo '<items>';
echo '</items>';
}?>