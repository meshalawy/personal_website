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
<?php $this->title('Create New Film Weekly Cinema - Category Map'); ?>
<h2>Create New Film Weekly Cinema - Category Map</h2>
<p>
	Create new category map for the cinema:<br/>
	<?=$data['cinema']->cinema_name;?>
</p>
<?=$this->form->create($data['form']); ?>
	<?=$this->form->hidden('film_weekly_cinemas_id', array('value' => $data['cinema']->id)); ?>
	<div>
		<?=$this->form->label('FilmWeeklyCategoriesId', 'Film Weekly Category'); ?>
		<?=$this->form->select('film_weekly_categories_id', $data['categories']); ?>
	</div>
	<?=$this->form->submit('Create New Category Map Record'); ?>
<?=$this->form->end(); ?>
<?=$this->html->link('Back to Cinema List', array('FilmWeeklyCinemas::index')); ?>