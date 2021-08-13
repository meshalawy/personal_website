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
class AustralianStates extends \lithium\data\Model {

	/**
	 * add relationships to the model
	 */
	public $hasMany = array('FlimWeeklyCinemas');

	/**
	 * add validation rules for the model
	 */
	public $validates = array(
		'id' => array(
			array('notEmpty',   'message' => 'A unique id is required'),
			array('isUniqueAusStateId', 'message' => 'That unique id is already in use'),
			array('numeric',    'message' => 'The unique id must be numeric')
		),
		'shortname' => array(
			array('notEmpty', 'message' => 'A short name for the state is required'),
			array('lengthBetween', 'message' => 'A short name cannot be longer than 3 characters',
								   'min' => 1,
								   'max' => 3)
		),
		'longname' => array(
			array('notEmpty', 'message' => 'A long name for the state is required'),
			array('lengthBetween', 'message' => 'A long name cannot be longer than 30 characters',
								   'min' => 1,
								   'max' => 30)
		)	
	);
	
	/**
	 * extend the __init function to include a custom validator
	 */
	public static function __init(array $options = array()) {
	
		// call the parent object init function
		parent::__init($options);
		
		// add our own validation method to enforce unique id requirement
		// *before* the data gets to the database and throws a data related exception
		Validator::add('isUniqueAusStateId', function ($value, $format, $options) {
			
			$conditions = array('id' => $value);
			
			// if editing the record skip the validation check
			if(isset($options['values']['edit'])) {
				$conditions[] = 'id != ' . $options['values']['id'];
			}
			
			return !AustralianStates::find('first', array('conditions' => $conditions));
			
		});
	}
}

?>