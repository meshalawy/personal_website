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
<?php $this->title('List of Cinema Archaeology Records'); ?>
<h2>List of Cinema Archaeology Records</h2>
<p>
	List of archaeology records for:<br/>
	<?=$cinema->cinema_name; ?>
</p>
<table>
	<thead>
		<tr>
			<th>Category</th><th>Theatre Name</th><th>Exhibitor Name</th><th>Capacity</th><th>Delete</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($cinema->film_weekly_archaeologies as $archaeology) { ?>
		<?php if(!empty($archaeology->film_weekly_categories_id)) { ?>
			<tr>
				<td><?=$categories[$archaeology->film_weekly_categories_id]; ?></td>
				<td><?=$archaeology->cinema_name; ?></td>
				<td><?=$archaeology->exhibitor_name; ?></td>
				<?php if($archaeology->capacity > 0) { ?>
					<td><?=$archaeology->capacity; ?></td>
				<?php } else { ?>
					<td>&nbsp;</td>
				<?php } ?>
				<td><?=$this->html->link('Delete', array('FilmWeeklyArchaeology::delete', 'args' => $archaeology->id)); ?></td>
			</tr>
		<?php } ?>
	<?php } ?>
	</tbody>
</table>
<p>
<?=$this->html->link('Add new Archaeology Record', array('FilmWeeklyArchaeology::add', 'args' => $cinema->id)); ?>
</p>
<p>
<?=$this->html->link('Back to Cinema List', array('FilmWeeklyCinemas::index')); ?>
</p>