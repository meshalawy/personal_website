<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
 /**
  * edit information about an existing australian state
  */
?>

<h2>Edit Existing Australian State</h2>
<?=$this->form->create($data); ?>
	<?=$this->form->hidden('edit', array('value' => 'true'))?>
	<?=$this->form->field('shortname', array('label' => 'State Abbreviation')); ?>
	<?=$this->form->field('longname', array('label' => 'State Full Name')); ?>
	<?=$this->form->submit('Update Record'); ?>
<?=$this->form->end(); ?>