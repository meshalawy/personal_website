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
 * Model used to manage Resources records
 */
class Resources extends \lithium\data\Model {

	/**
	 * add validation rules for the model
	 */
	public $validates = array(
		'title' => array(
			array('notEmpty',      'message' => 'A resource title is required'),
			array('lengthBetween', 'message' => 'A resource title cannot be longer than 100 characters',
								   'min' => 1,
								   'max' => 100)
		),
		'description' => array(
			array('notEmpty',      'message' => 'A resource description is required'),
			array('lengthBetween', 'message' => 'A resource description cannot be longer than 512 characters',
								   'min' => 1,
								   'max' => 512)
		),
		'url' => array(
			array('notEmpty',      'message' => 'A resource url is required'),
			array('lengthBetween', 'message' => 'A resource url cannot be longer than 256 characters',
								   'min' => 1,
								   'max' => 256),
			array('url',           'message' => 'A resource url must be a valid and complete url')
		)
	);	
}