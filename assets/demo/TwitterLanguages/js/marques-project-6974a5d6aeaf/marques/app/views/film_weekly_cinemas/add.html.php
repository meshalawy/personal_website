<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
 /**
  * Create new record
  */
?>
<?php $this->title('Create New Cinema Record'); ?>

<h2>Create New Cinema Record</h2>
<?=$this->form->create($data['form']); ?>
	<?=$this->form->field('cinema_name', array('label' => 'Theatre Name')); ?>
	<?=$this->form->field('exhibitor_name', array('label' => 'Exhibitor Name')); ?>
	<?=$this->form->field('capacity', array('label' => 'Capacity')); ?>
	<div>
		<?=$this->form->label('FilmWeeklyCinemaTypesId', 'Cinema Type'); ?>
		<?=$this->form->select('film_weekly_cinema_types_id', $data['types']); ?>
	</div>
	<div>
		<?=$this->form->label('AustralianStatesId', 'State'); ?>
		<?=$this->form->select('australian_states_id', $data['states']); ?>
	</div>
	<div>
		<?=$this->form->label('LocalityTypesId', 'Locality Type'); ?>
		<?=$this->form->select('locality_types_id', $data['localities']); ?>
	</div>
	<?=$this->form->field('street', array('label' => 'Street Address')); ?>
	<?=$this->form->field('suburb', array('label' => 'Suburb / Town')); ?>
	<?=$this->form->field('postcode', array('label' => 'Postcode')); ?>
	<?=$this->form->field('latitude', array('label' => 'Latitude in Decimal Degrees')); ?>
	<?=$this->form->field('longitude', array('label' => 'Longitude in Decimal Degrees')); ?>
	<?=$this->form->submit('Create New Record'); ?>
<?=$this->form->end(); ?>