<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
 /**
  * List information about users 
  */
?>
<?php $this->title('List of Film Weekly Categories'); ?>
<h2>List of Film Weekly Categories</h2>
<p>
	List of categories for:<br/>
	<?=$cinema->cinema_name; ?>
</p>
<ul>
	<?php foreach($categories as $category) { ?>
		<li>
			<?=$category->film_weekly_category->description; ?>
			(<?=$this->html->link('Delete', array('FilmWeeklyCategoryMaps::delete', 'args' => $category->id)); ?>)
		</li>
	<?php } ?>
</ul>
<p>
<?=$this->html->link('Link cinema to a category', array('FilmWeeklyCategoryMaps::add', 'args' => $cinema->id)); ?>
</p>
<p>
<?=$this->html->link('Back to Cinema List', array('FilmWeeklyCinemas::index')); ?>
</p>