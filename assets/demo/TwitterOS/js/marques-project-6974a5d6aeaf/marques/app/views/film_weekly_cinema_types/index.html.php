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
<?php $this->title('List of Film Weekly Cinema Types'); ?>
<h2>List of Film Weekly Cinema Types</h2>
<table>
	<thead>
		<tr>
			<th>ID</th><th>Description</th><th>Edit</th><th>Delete</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $datum) {?>
			<tr>
				<td><?=$datum->id; ?></td>
				<td><?=$datum->description; ?></td>
				<td><?=$this->html->link('Edit', array('FilmWeeklyCinemaTypes::edit', 'args' => $datum->id)); ?></td>
				<td><?=$this->html->link('Delete', array('FilmWeeklyCinemaTypes::delete', 'args' => $datum->id)); ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<?=$this->html->link('Add New Record', array('FilmWeeklyCinemaTypes::add')); ?>