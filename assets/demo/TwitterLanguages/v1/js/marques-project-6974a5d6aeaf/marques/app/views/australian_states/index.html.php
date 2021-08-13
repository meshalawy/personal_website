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
<?php $this->title('List of Australian States'); ?>
<h2>List of Australian States</h2>
<table>
	<thead>
		<tr>
			<th>ID</th><th>Short Name</th><th>Long Name</th><th>Edit</th><th>Delete</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $datum) {?>
			<tr>
				<td><?=$datum->id; ?></td>
				<td><?=$datum->shortname; ?></td>
				<td><?=$datum->longname; ?></td>
				<td><?=$this->html->link('Edit', array('AustralianStates::edit', 'args' => $datum->id)); ?></td>
				<td><?=$this->html->link('Delete', array('AustralianStates::delete', 'args' => $datum->id)); ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<?=$this->html->link("Add New State", array("AustralianStates::add")); ?>