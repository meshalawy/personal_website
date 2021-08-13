<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
 /**
  * edit an existing record
  */
?>
<?php $this->title('Edit Cinema Record'); ?>

<h2>Edit Cinema Record</h2>
<p>
<?=$this->html->link('Edit Categories', array('FilmWeeklyCategoryMaps::index', 'args' => $data['form']->id)); ?> | 
<?=$this->html->link('Edit Archaeology Records', array('FilmWeeklyArchaeology::index', 'args' => $data['form']->id)); ?> |
<?=$this->html->link('Edit Resources', array('FilmWeeklyResourceMaps::associate', 'args' => $data['form']->id)); ?>
</p>
<?=$this->form->create($data['form']); ?>
	<?=$this->form->field('id', array('label' => 'Record ID', 'disabled' => 'disabled')); ?>
	<?=$this->form->field('cinema_name', array('label' => 'Theatre Name')); ?>
	<?=$this->form->field('exhibitor_name', array('label' => 'Exhibitor Name')); ?>
	<?=$this->form->field('capacity', array('label' => 'Capacity')); ?>
	<div>
		<?=$this->form->label('FilmWeeklyCinemaTypesId', 'Cinema Type'); ?>
		<?=$this->form->select('film_weekly_cinema_types_id', $data['types'], array('value' => $data['form']->film_weekly_cinema_types_id)); ?>
	</div>
	<div>
		<?=$this->form->label('AustralianStatesId', 'State'); ?>
		<?=$this->form->select('australian_states_id', $data['states'], array('value' => $data['form']->australian_states_id)); ?>
	</div>
	<div>
		<?=$this->form->label('LocalityTypesId', 'Locality Type'); ?>
		<?=$this->form->select('locality_types_id', $data['localities'], array('value' => $data['form']->locality_types_id)); ?>
	</div>
	<?=$this->form->field('street', array('label' => 'Street Address')); ?>
	<?=$this->form->field('suburb', array('label' => 'Suburb / Town')); ?>
	<?=$this->form->field('postcode', array('label' => 'Postcode')); ?>
	<?=$this->form->field('latitude', array('label' => 'Latitude in Decimal Degrees')); ?>
	<?=$this->form->field('longitude', array('label' => 'Longitude in Decimal Degrees')); ?>
	<?=$this->form->submit('Update Record'); ?>
<?=$this->form->end(); ?>