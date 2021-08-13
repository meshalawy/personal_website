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
 * Model used to manage Locality Type records
 */
class LocalityTypes extends \lithium\data\Model {

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
			array('isUniqueLocalityTypeId', 'message' => 'That unique id is already in use'),
			array('numeric',    'message' => 'The unique id must be numeric')
		),
		'description' => array(
			array('notEmpty', 'message' => 'A description for this locality type is required'),
			array('lengthBetween', 'message' => 'A description cannot be longer than 50 characters',
								   'min' => 1,
								   'max' => 50)
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
		Validator::add('isUniqueLocalityTypeId', function ($value, $format, $options) {
			
			$conditions = array('id' => $value);
			
			// if editing the record skip the validation check
			if(isset($options['values']['edit'])) {
				$conditions[] = 'id != ' . $options['values']['id'];
			}
			
			return !LocalityTypes::find('first', array('conditions' => $conditions));
			
		});
	}
}

?>