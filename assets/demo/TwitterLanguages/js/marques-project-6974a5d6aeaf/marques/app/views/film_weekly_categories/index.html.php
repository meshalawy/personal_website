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
<table>
	<thead>
		<tr>
			<th>ID</th><th>Description</th><th>Cinemas</th><th>Edit</th><th>Delete</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($categories as $category) {?>
			<tr>
				<td><?=$category->id; ?></td>
				<td><?=$category->description; ?></td>
				<td><?=count($category->film_weekly_category_maps) - 1;?></td>
				<td><?=$this->html->link("Edit", array("FilmWeeklyCategories::edit", "args" => $category->id)); ?></td>
				<td><?=$this->html->link("Delete", array("FilmWeeklyCategories::delete", "args" => $category->id)); ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<?=$this->html->link("Add New Category", array("FilmWeeklyCategories::add")); ?>