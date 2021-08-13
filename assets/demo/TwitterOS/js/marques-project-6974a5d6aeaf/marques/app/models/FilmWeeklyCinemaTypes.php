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
 * Model used to manage Film Weekly Cinema Type records
 */
class FilmWeeklyCinemaTypes extends \lithium\data\Model {

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
			//array('isUniqueFwCinemaTypeId', 'message' => 'That unique id is already in use'),
			array('numeric',    'message' => 'The unique id must be numeric')
		),
		'description' => array(
			array('notEmpty', 'message' => 'A description for this cinema type is required'),
			array('lengthBetween', 'message' => 'A description cannot be longer than 256 characters',
								   'min' => 1,
								   'max' => 256)
		)
	);
	
	/**
	 * extend the __init function to include a custom validator

	public static function __init(array $options = array()) {
	
		// call the parent object init function
		parent::__init($options);
		
		
		//TODO work out why this validation function fails
		
		// add our own validation method to enforce unique id requirement
		// *before* the data gets to the database and throws a data related exception
		Validator::add('isUniqueFwCinemaTypeId', function ($value, $format, $options) {
			
			$conditions = array('id' => $value);
			
			// if editing the record skip the validation check
			if(isset($options['values']['edit'])) {
				$conditions[] = 'id != ' . $options['values']['id'];
			}
			
			return !FilmWeeklyCinemaTypes::find('first', array('conditions' => $conditions));
			
		});
	}
	 */
}

?>