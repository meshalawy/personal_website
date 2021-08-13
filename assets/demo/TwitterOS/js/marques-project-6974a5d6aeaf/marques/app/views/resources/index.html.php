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
<h2>List of Resources</h2>
<p>
<?=$this->html->link('Add New Record', array('Resources::add')); ?>
</p>
<table>
	<thead>
		<tr>
			<th>ID</th><th>Title</th><th>Description</th><th>Link</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $datum) {?>
			<tr>
				<td><?=$datum->id; ?></td>
				<td><?=$datum->title; ?></td>
				<td><?=$datum->description; ?></td>
				<td><?=$this->html->link('View Resource', $datum->url); ?></td>
				<td><?=$this->html->link('Edit', array('Resources::edit', 'args' => $datum->id)); ?></td>
				<td><?=$this->html->link('Delete', array('Resources::delete', 'args' => $datum->id)); ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<?=$this->Paginator->paginate(); ?>