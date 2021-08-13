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
 * Model used to manage Activity Log records
 */
class ActivityLogs extends \lithium\data\Model {

	/**
	 * add validation rules for the model
	 */
	public $validates = array(
		'type' => array(
			array('notEmpty',      'message' => 'An activity log type is required'),
			array('lengthBetween', 'message' => 'An activity log type cannot be longer than 20 characters',
								   'min' => 1,
								   'max' => 20)
		),
		'notes' => array(
			array('notEmpty',      'message' => 'Notes on the activity are required'),
			array('lengthBetween', 'message' => 'An activity log note cannot be longer than 512 characters',
								   'min' => 1,
								   'max' => 512)
		)
	);	
}