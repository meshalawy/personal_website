<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
 /**
  * Collect information about a new user 
  */
?>
<?php $this->title('Create New Film Weekly Cinema Archaeology Record'); ?>
<h2>Create New Film Weekly Cinema - Category Map</h2>
<p>
	Create new category map for the cinema:<br/>
	<?=$cinema->cinema_name;?>
</p>
<?=$this->form->create($archaeology); ?>
	<?=$this->form->hidden('film_weekly_cinemas_id', array('value' => $cinema->id)); ?>
	<div>
		<?=$this->form->label('FilmWeeklyCategoriesId', 'Film Weekly Category'); ?>
		<?=$this->form->select('film_weekly_categories_id', $categories); ?>
	</div>
	<?=$this->form->field('cinema_name', array('label' => 'Theatre Name')); ?>
	<?=$this->form->field('exhibitor_name', array('label' => 'Exhibitor Name')); ?>
	<?=$this->form->field('capacity', array('label' => 'Capacity')); ?>
	<?=$this->form->submit('Create New Record'); ?>
<?=$this->form->end(); ?>
<?=$this->html->link('Back to Archaeology Record List', array('FilmWeeklyArchaeology::index', 'args' => array($cinema->id))); ?>