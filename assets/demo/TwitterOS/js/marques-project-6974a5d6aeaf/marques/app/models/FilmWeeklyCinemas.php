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
 * Model used to manage the base Film Weekly Cinema record
 */
class FilmWeeklyCinemas extends \lithium\data\Model {

	/**
	 * define relationships
	 */
	public $belongsTo = array(
		'AustralianStates' => array(
			'class' => 'AustralianStates',
			'key'   => 'australian_states_id',
			'conditions' => array(),
			'fields' => array(),
			'order' => null,
			'limit' => null
		),
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
	
	public $hasMany = array(
		'FilmWeeklyArchaeology' => array(
			'class' => 'FilmWeeklyArchaeology',
			'key'   => array('id' => 'film_weekly_cinemas_id'),
			'conditions' => array(),
			'fields' => array(),
			'order' => null,
			'limit' => null
		),
		'FilmWeeklyCategoryMaps' => array(
			'class' => 'FilmWeeklyCategoryMaps',
			'key'   => array('id' => 'film_weekly_cinemas_id'),
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
		'cinema_name' => array(
			array('notEmpty',      'message' => 'A theatre name is required'),
			array('lengthBetween', 'message' => 'A theatre name cannot be longer than 512 characters',
				'min' => 0,
				'max' => 512)
		),
		'exhibitor_name' => array(
			array('notEmpty',      'message' => 'An exhibitor name is required'),
			array('lengthBetween', 'message' => 'An exhibitor name cannot be longer than 512 characters',
				'min' => 0,
				'max' => 512)
		),
		'capacity' => array(
			array('notEmpty',   'message' => 'The capacity of the theatre is required'),
			array('numeric',    'message' => 'The capacity of the theatre must be a number')
		),
		'film_weekly_cinema_types_id' => array(
			array('notEmpty',   'message' => 'The type of cinema is required')
		),
		'australian_states_id' => array(
			array('notEmpty',   'message' => 'The australian state required')
		),
		'locality_types_id' => array(
			array('notEmpty',   'message' => 'The locality type is required')
		),
		'street' => array(
			array('notEmpty',      'message' => 'A street address is required'),
			array('lengthBetween', 'message' => 'A street address cannot be longer than 512 characters',
				'min' => 0,
				'max' => 512)
		),
		'suburb' => array(
			array('notEmpty',      'message' => 'A suburb is required'),
			array('lengthBetween', 'message' => 'A suburb cannot be longer than 512 characters',
				'min' => 0,
				'max' => 512)
		),
		'postcode' => array(
			array('notEmpty',      'message' => 'A postcode is required'),
			array('lengthBetween', 'message' => 'A postcode must be four characters long',
				'min' => 4,
				'max' => 4),
			array('numeric',       'message' => 'The postcode must be a number')
		),
		'latitude' => array(
			array('notEmpty', 'message' => 'A latitude is required'),
			array('decimal',  'message' => 'A latitude must be a decimal number'),
			array('inRange',  'message' => 'A latitude must be between -180 and 180 degrees',
				'lower' => -180,
				'upper' => 180)
		),
		'longitude' => array(
			array('notEmpty', 'message' => 'A longitude is required'),
			array('decimal',  'message' => 'A longitude must be a decimal number'),
			array('inRange',  'message' => 'A latitude must be between -180 and 180 degrees',
				'lower' => -180,
				'upper' => 180)
		)
	);
	
	/**
	 * output the search result
	 */
	public function search_result($record) {
	
		// build the search result text
		$street         = $record->street;
		$suburb         = $record->suburb;
		$state          = $record->australian_state->shortname;
		
		$address = '';
		
		if(!empty($street)) {
			$address = $street . ', ';
		}
		
		$address .= $suburb . ', ' . $state;
		
		return array(
			'cinema_name'    => $record->cinema_name,
			'exhibitor_name' => $record->exhibitor_name,
			'address'        => $address
		);
		//return "{$record->cinema_name} ({$record->exhibitor_name}), {$record->street}, {$record->suburb}, {$record->australian_state->shortname}";
		//return '<pre>' . print_r($record, true) . '</pre>';
	}
	
	/**
	 * output the search result for use in ajax
	 */
	public function search_result_ajax($record) {
	
		$parts = $this->search_result($record);
		
		return $parts['cinema_name'] . ', ' . $parts['exhibitor_name'] . ', ' . $parts['address'];
	
	}

}

?>