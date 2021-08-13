<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
 /**
  * List information about Film Weekly Cinemas 
  */
?>
<?php $this->title('List Film Weekly Cinemas'); ?>
<h2>List of Film Weekly Cinemas</h2>
<p>
<?=$this->html->link('Add New Record', array('FilmWeeklyCinemas::add')); ?>
</p>
<table>
	<thead>
		<tr>
			<th>ID</th><th>Theatre Name</th><th>Street</th><th>Suburb</th><th>State</th></th><th>Edit</th><th>Delete</th><th>Categories</th><th>Archaeology</th><th>Resources</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $datum) {?>
			<tr>
				<td><?=$datum->id; ?></td>
				<td><?=$datum->cinema_name; ?></td>
				<td><?=$datum->street; ?></td>
				<td><?=$datum->suburb; ?></td>
				<td><?=$datum->australian_state->shortname; ?></td>
				<td><?=$this->html->link('Edit', array('FilmWeeklyCinemas::edit', 'args' => $datum->id)); ?></td>
				<td><?=$this->html->link('Delete', array('FilmWeeklyCinemas::delete', 'args' => $datum->id)); ?></td>
				<td><?=$this->html->link('Categories', array('FilmWeeklyCategoryMaps::index', 'args' => $datum->id)); ?></td>
				<td><?=$this->html->link('Archaeology', array('FilmWeeklyArchaeology::index', 'args' => $datum->id)); ?></td>
				<td><?=$this->html->link('Resources', array('FilmWeeklyResourceMaps::associate', 'args' => $datum->id)); ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<?=$this->Paginator->paginate(); ?>