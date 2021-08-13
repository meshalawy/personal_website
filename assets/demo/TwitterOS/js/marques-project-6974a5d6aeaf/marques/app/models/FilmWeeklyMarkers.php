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
 * model used to manage the details of film weekly markers
 */
class FilmWeeklyMarkers extends \lithium\data\Model {

	/**
	 * define relationships
	 */
	public $belongsTo = array(
		'FilmWeeklyCinemaTypes' => array(
			'class' => 'FilmWeeklyCinemaTypes',
			'key'   => 'film_weekly_cinema_types_id',
			'conditions' => array(),
			'fields' => array(),
			'order' => null,
			'limit' => null
		), 
		'LocalityTypes' => array(
			'class' => 'LocalityTypes',
			'key'   => 'locality_types_id',
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
		'film_weekly_cinema_types_id' => array(
			array('notEmpty',   'message' => 'A film weekly cinema type id is required'),
			array('numeric',    'message' => 'The unique id must be numeric')
		),
		'locality_types_id' => array(
			array('notEmpty',   'message' => 'A locality type id is required'),
			array('numeric',    'message' => 'The unique id must be numeric')
		),
		'marker_url' => array(
			array('notEmpty',   'message' => 'A marker url is required'),
			array('lengthBetween', 'message' => 'A marker url cannot be longer than 255 characters',
				'min' => 0,
				'max' => 255),
			array('url', 'message' => 'A marker url must be a valid and complete url')
		)
	);
}
?>