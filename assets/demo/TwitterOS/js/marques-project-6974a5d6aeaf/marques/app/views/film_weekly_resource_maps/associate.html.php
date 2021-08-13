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
<?php $this->title('Associate a Cinema with a Resource'); ?>
<h2>Create New Film Weekly Cinema Resource Association</h2>
<p>
	Create new cinema resource association for:<br/>
	<?=$cinema->cinema_name;?>
</p>
<h2>List of Existing Resources</h2>
<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Link</th>
			<th>Associate</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($resources as $resource) { ?>
			<tr>
				<td><?=$resource->id; ?></td>
				<td><?=$resource->title; ?></td>
				<td><?=$this->html->link('Link', $resource->url); ?></td>
				<?php if(in_array($resource->id, $associations) == false) { ?>
					<td><?=$this->html->link('Associate', array('FilmWeeklyResourceMaps::make', 'args' => $cinema->id . '-' . $resource->id)); ?></td>
				<?php } else { ?>
					<td>Associated</td>				
				<?php } ?> 
			</tr>
		<?php } ?>
	</tbody>
</table>
<?=$this->Paginator->paginate(); ?>