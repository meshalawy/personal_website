<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
 /**
  * Search for Film Weekly Cinemas and return dat in a XML encoded format
  */
?>
<?php if(!empty($records)) {
echo '<items>';
	foreach($records as $record) {
		echo '<' . 'item' . '>'; 
		$result = $record->search_result();
		echo '<id>' . $record->id . '</id>';
		echo '<cinema_name>' . $result['cinema_name'] . '</cinema_name>';
		echo '<exhibitor_name>' . $result['exhibitor_name'] . '</exhibitor_name>';
		echo '<address>' . $result['address'] . '</address>';
		echo '</item>';
	}
echo '</items>'; 
}?>