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
<?php $this->title('Create New Film Weekly Category'); ?>

<h2>Create New Category</h2>
<?=$this->form->create($category); ?>
	<?=$this->form->field('id', array('label' => 'Unique ID Number')); ?>
	<?=$this->form->field('description', array('label' => 'Category Description')); ?>
	<?=$this->form->submit('Create New Category'); ?>
<?=$this->form->end(); ?>