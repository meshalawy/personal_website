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
 * Model used to manage Australian State records
 */
class FilmWeeklyArchaeology extends \lithium\data\Model {

	/**
	 * add relationships to the model
	 */
	public $hasOne = array(
		'FilmWeeklyCinemas' => array(
			'class'      => 'FilmWeeklyCinemas',
			'key'        => array('film_weekly_cinemas_id' => 'id'),
			'conditions' => array(),
			'fields'     => array(),
			'order'      => null,
			'limit'      => null,
		),
		'FilmWeeklyCategories' => array(
			'class'      => 'FilmWeeklyCategories',
			'key'        => array('film_weekly_categories_id' => 'id'),
			'conditions' => array(),
			'fields'     => array(),
			'order'      => null,
			'limit'      => null,
		)
	);

	/**
	 * add validation rules for the model
	 */
	public $validates = array(
		'film_weekly_cinemas_id' => array(
			array('notEmpty',   'message' => 'The id of the parent cinema record is required')
		),
		'film_weekly_categories_id' => array(
			array('notEmpty',   'message' => 'The id of a film weekly category is required')
		)
	);
}
?>