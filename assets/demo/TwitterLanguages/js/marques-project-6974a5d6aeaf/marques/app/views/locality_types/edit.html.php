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
<?php $this->title('Edit Locality Type'); ?>
<h2>Edit Existing Locality Type</h2>
<?=$this->form->create($data); ?>
	<?=$this->form->hidden('edit', array('value' => 'true'))?>
	<?=$this->form->field('description', array('label' => 'Locality Type Description')); ?>
	<?=$this->form->submit('Update Record'); ?>
<?=$this->form->end(); ?>