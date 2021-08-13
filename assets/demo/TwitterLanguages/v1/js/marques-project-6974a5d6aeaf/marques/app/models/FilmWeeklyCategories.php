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
 * Model used to manage the Film Weekly Categories ie. "1948 - 1949" etc.
 */
class FilmWeeklyCategories extends \lithium\data\Model {

	/**
	 * define relationships
	 */
	public $hasMany = array(
		'FilmWeeklyCategoryMaps' => array(
		'class' => 'FilmWeeklyCategoryMaps',
		'key'   => array('id' => 'film_weekly_categories_id'),
		'conditions' => array(),
		'fields' => array(),
		'order' => null,
		'limit' => null
	));

	/**
	 * add validation rules for the model
	 */
	public $validates = array(
		'id' => array(
			array('notEmpty',   'message' => 'A unique id is required'),
			//array('isUniqueFwCategoryId', 'message' => 'That unique id is already in use'),
			array('numeric',    'message' => 'The unique id must be numeric')
		),
		'description' => array(
			array('notEmpty', 'message' => 'A description for this category is required'),
			array('lengthBetween', 'message' => 'A description cannot be longer than 20 characters',
								   'min' => 1,
								   'max' => 20)
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
		Validator::add('isUniqueFwCategoryId', function ($value, $format, $options) {
			
			$conditions = array('id' => $value);
			
			// if editing the record skip the validation check
			if(isset($options['values']['edit'])) {
				$conditions[] = 'id != ' . $options['values']['id'];
			}
			
			return !FilmWeeklyCategories::find('first', array('conditions' => $conditions));
			
		});
	}
	 */
}