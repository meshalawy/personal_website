<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
 /**
  * List information about Film Weekly Markers
  */
?>
<?php $this->title('List Film Weekly Markers'); ?>
<h2>List of Film Weekly Markers</h2>
<table>
	<thead>
		<tr>
			<th>Cinema Type</th><th>Locality Type</th><th>Marker</th><th>Delete</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($markers as $marker) {?>
			<tr>
				<td><?=$marker->film_weekly_cinema_type->description; ?></td>
				<td><?=$marker->locality_type->description; ?></td>
				<td><?=$this->html->image($marker->marker_url); ?></td>
				<td><?=$this->html->link('Delete', array('FilmWeeklyMarkers::delete', 'args' => $marker->id));?></td>
			</tr>
		<?php }?>
	</tbody>
</table>
<p>
	<?=$this->html->link('Add New Record', array('FilmWeeklyMarkers::add')); ?>
</p>