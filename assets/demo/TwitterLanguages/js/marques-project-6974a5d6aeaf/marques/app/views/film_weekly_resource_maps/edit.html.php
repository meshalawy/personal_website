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
<?php $this->title('Edit Resource Map Record'); ?>

<h2>Create New Resources Record</h2>
<?=$this->form->create($data); ?>
	<?=$this->form->field('film_weekly_cinemas_id', array('label' => 'Unique Cinema ID')); ?>
	<?=$this->form->field('resources_id', array('label' => 'Unique Resources ID')); ?>
	<?=$this->form->submit('Update Record'); ?>
<?=$this->form->end(); ?>