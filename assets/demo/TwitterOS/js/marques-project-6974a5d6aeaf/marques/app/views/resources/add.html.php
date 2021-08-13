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
<?php $this->title('Create New Resources Record'); ?>

<h2>Create New Resources Record</h2>
<?=$this->form->create($data); ?>
	<?=$this->form->field('title', array('label' => 'Resource Title')); ?>
	<?=$this->form->field('description', array('label' => 'Resource Description')); ?>
	<?=$this->form->field('url', array('label' => 'Link to Resource')); ?>
	<?=$this->form->submit('Create New Record'); ?>
<?=$this->form->end(); ?>