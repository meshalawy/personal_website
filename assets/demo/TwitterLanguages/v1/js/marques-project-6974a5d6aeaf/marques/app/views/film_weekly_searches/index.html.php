<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
 /**
  * Search for Film Weekly Cinemas 
  */
?>
<?php $this->title('Search Film Weekly Cinemas'); ?>
<h2>Search for Film Weekly Cinemas</h2>
<?=$this->form->create(null); ?>

	<?php if(!empty($search)) { ?>
		<?=$this->form->field('search', array('value' => $search)); ?>
	<?php } else { ?>
		<?=$this->form->field('search'); ?>
	<?php } ?>
    
    <?=$this->form->submit('Search'); ?>
<?=$this->form->end(); ?>
<?php if(!empty($records)) { ?>
	<h2>Search Results</h2>
	<?php foreach($records as $record) { 
		$result = $record->search_result();
	?>
	<p>
		<?=$this->html->link($result['cinema_name'], array('FilmWeeklyCinemas::edit', 'args' => $record->id)); ?>
		<?=$result['exhibitor_name']?>,
		<?=$result['address']?>
	</p>	

	<?php } ?>
<?php } ?>
	
<!--
<?php
	if(!empty($records)) {
	echo('<pre>');
	print_r($records);
	echo('</pre>');
	}
?>

<?php
	if(!empty($cinemas)) {
	echo('<pre>');
	print_r($cinemas);
	echo('</pre>');
	}
?>
-->