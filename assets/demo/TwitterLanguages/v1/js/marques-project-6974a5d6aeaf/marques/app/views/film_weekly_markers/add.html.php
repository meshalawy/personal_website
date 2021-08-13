<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
?>
<?php $this->title('Add New Marker Record'); ?>
<h2>Add New Marker Record</h2>
<?=$this->form->create($marker); ?>
	<div>
		<?=$this->form->label('FilmWeeklyCinemaTypesId', 'Film Weekly Cinema Type'); ?>
		<?=$this->form->select('film_weekly_cinema_types_id', $cinema_types); ?>
	</div>
	<div>
		<?=$this->form->label('LocalityTypesId', 'Locality Type'); ?>
		<?=$this->form->select('locality_types_id', $locality_types); ?>
	</div>
	<?=$this->form->field('marker_url', array('label' => 'Marker URL')); ?>
	<?=$this->form->submit('Create New Record'); ?>
<?=$this->form->end(); ?>
<?=$this->html->link('Back to Marker List', array('FilmWeeklyMarkers::index')); ?>