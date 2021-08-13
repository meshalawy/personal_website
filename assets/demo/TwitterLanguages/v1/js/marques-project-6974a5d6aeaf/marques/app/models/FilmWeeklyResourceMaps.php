<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace app\models;

use \lithium\util\Validator;

/**
 * Model used to manage Film Weekly Resource Map records
 */
class FilmWeeklyResourceMaps extends \lithium\data\Model {

	/**
	 * add relationships to the model
	 */
	public $belongsTo = array(
		'FilmWeeklyCinemas' => array(
			'class' => 'FilmWeeklyCinemas',
			'key'   => 'film_weekly_cinemas_id',
			'conditions' => array(),
			'fields' => array(),
			'order' => null,
			'limit' => null
		),
		'Resources' => array(
			'class' => 'Resources',
			'key'   => 'resources_id',
			'conditions' => array(),
			'fields' => array(),
			'order' => null,
			'limit' => null
		)
	);

	/**
	 * add validation rules for the model
	 */
	public $validates = array(
		'film_weekly_cinemas_id' => array(
			array('notEmpty',    'message' => 'A film weekly cinema record id is required'),
			array('numeric',     'message' => 'A film weekly cinema id must be a numeric value')
		),
		'resources_id' => array(
			array('notEmpty', 'message' => 'A resources record id is required'),
			array('numeric',  'message' => 'A resources record id must be a numeric value')
		)
	);
}

?>