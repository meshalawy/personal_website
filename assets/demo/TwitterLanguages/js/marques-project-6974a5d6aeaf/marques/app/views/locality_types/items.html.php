<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
 
 /**
  * output the list of items 
  */
?>
<?php $this->title($title); ?>

<h2><?=$title;?></h2>
<ul>
<?php foreach($data as $datum) { ?>
	<li><?=$datum->description;?></li>
<?php } ?>
</ul>
<p>
	It is intended that this URL be used for JSON requests, please use:<br/>
	<?=$this->html->link('this url instead', $url . '.json'); ?>
</p>