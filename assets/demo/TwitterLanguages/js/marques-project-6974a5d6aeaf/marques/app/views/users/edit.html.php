<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
 /**
  * edit information about an existing user 
  */
?>

<h2>Edit Existing User</h2>
<?=$this->form->create($user); ?>
	<?=$this->form->hidden('id')?>
	<?=$this->form->field('username', array('label' => 'User Name')); ?>
	<?=$this->form->field('password', array('label' => 'Password', 'type' => 'password')); ?>
	<?=$this->form->field('firstname', array('label' => 'First Name')); ?>
	<?=$this->form->field('lastname', array('label' => 'Last Name')); ?>
	<?=$this->form->field('email', array('label' => 'Email Address')); ?>
	<?=$this->form->submit('Update User'); ?>
<?=$this->form->end(); ?>