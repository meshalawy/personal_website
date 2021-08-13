<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
 /**
  * Build the Film Weekly Info Window 
  */
?>
<?php

	$details = $cinema->search_result();
	
	$link_options = array(
		'class'  => 'external',
		'target' => 'blank'
	);
	
	//edit the content of this variable to the url of the contribute form
	// use the full URL including HTTP or if you use a relative URL
	// start it with a ../ if the page is outside the marques system
	$contribute_url = '../contribute/index.php?cinema=';

?>
<div class="fw-info-window-content">
<h1><?=$details['cinema_name']; ?> <img style="float: left" src="<?=$markers[$cinema->film_weekly_cinema_types_id][$cinema->locality_types_id]; ?>"/></h1>
<h2><?=$details['address'];?></h2>
<p>Film Weekly Listings: <?=$listings; ?></p>
<p>First Recorded Exhibitor: <?=$details['exhibitor_name']; ?></p>
<p>First Recorded Capacity: <?=$cinema->capacity; ?></p>
<h3>Venue Archaeology</h3>
<ul>
<?php foreach($cinema->film_weekly_archaeologies as $record) { ?>
	<?php if($record->cinema_name != null) { ?>
		<li><?=$categories[$record->film_weekly_categories_id]; ?> Cinema Name: <?=$record->cinema_name; ?></li>
	<?php }?>
	<?php if($record->exhibitor_name != null) { ?>
		<li><?=$categories[$record->film_weekly_categories_id]; ?> Exhibitor Name: <?=$record->exhibitor_name; ?></li>
	<?php }?>
	<?php if($record->capacity != null) { ?>
		<li><?=$categories[$record->film_weekly_categories_id]; ?> Capacity: <?=$record->capacity; ?></li>
	<?php }?>
<?php } ?>
</ul>
<h3>Resources</h3>
<p style="padding-bottom: 1.0em">
	You are invited to <?=$this->html->link('Contribute', $contribute_url . $cinema->id); ?> resources and information.
</p>
<ul>
<?php foreach($resources as $resource) { ?>
	<li><?=$this->html->link($resource['title'], $resource['url'], $link_options); ?></li>
<?php } ?>
</ul>
</div>