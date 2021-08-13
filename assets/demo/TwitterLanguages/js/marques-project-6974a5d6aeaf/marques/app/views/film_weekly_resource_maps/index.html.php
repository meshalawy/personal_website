<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
 /**
  * List information about Resources 
  */
?>
<?php $this->title('List Resources'); ?>
<h2>List of Film Weekly Resource Maps</h2>
<p>
<?=$this->html->link('Add New Record', array('FilmWeeklyResourceMaps::add')); ?>
</p>
<table>
	<thead>
		<tr>
			<th>Cinema ID</th><th>Resource ID</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $datum) {?>
			<tr>
				<td><?=$datum->film_weekly_cinemas_id; ?></td>
				<td><?=$datum->resources_id; ?></td>
				<td><?=$this->html->link('Edit', array('FilmWeeklyResourceMaps::edit', 'args' => $datum->id)); ?></td>
				<td><?=$this->html->link('Delete', array('FilmWeeklyResourceMaps::delete', 'args' => $datum->id)); ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<?=$this->Paginator->paginate(); ?>