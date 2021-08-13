<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace app\controllers;

use lithium\data\Connections;

use li3_flash\extensions\storage\Flash;

use app\models\FilmWeeklyCinemas;

/**
 * Search for Film Weekly Cinemas in the database
 */
class FilmWeeklySearchesController extends \lithium\action\Controller {

	// list actions that can be undertaken without authentication
	public $publicActions = array('index');
	
	// enable content negotiation so AJAX data can be returned
	protected function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();
    }

	/**
	 * list all of the records
	 */
    public function index() {
        
        if ($this->request->data) {
        	
        	// get the search terms from the post data
        	$search = $this->request->data['search'];
        	
        	// get a connection to the database
        	$db = Connections::get('default');
        	
        	// build a query to search for film_weekly_cinema_id using data from the film_weekly_table
        	$sql = "SELECT DISTINCT film_weekly_cinemas_id 
        		    FROM film_weekly_searches 
        		    WHERE MATCH (fwc_street, fwc_suburb, fwc_cinema_name, fwc_exhibitor_name)
					AGAINST ({:search} IN NATURAL LANGUAGE MODE)";
        	
        	// execute the query
        	$batch = $db->read($sql, 
        		array(
        			'return' => 'array',
        			'search' => $search
        		)
        	);
        	
        	//populate an array of ids
        	$cinemas = array();
        	
        	foreach($batch as $item) {
        	
        		$cinemas[] = $item['film_weekly_cinemas_id'];
        	}
        	
        	// build a query to search for film_weekl_cinema_id using data from the film_weekly_archaeology_table
        	$sql = "SELECT DISTINCT film_weekly_archaeologies.film_weekly_cinemas_id
					FROM film_weekly_searches, film_weekly_archaeologies
					WHERE MATCH (fwa_cinema_name, fwa_exhibitor_name) AGAINST ({:search} IN NATURAL LANGUAGE MODE)
					AND film_weekly_searches.film_weekly_archaeologies_id = film_weekly_archaeologies.id";
        	
        	// execute the data
        	$batch = $db->read($sql, 
        		array(
        			'return' => 'array',
        			'search' => $search
        		)
        	);
        	
        	// add ids to the array
			foreach($batch as $item) {
        	
        		$cinemas[] = $item['film_weekly_cinemas_id'];
        	}
        	
        	// remove any duplicates
        	$cinemas = array_unique($cinemas, SORT_NUMERIC);
        	
        	// loop through getting all of the cinemas one at a time
        	// TODO: yes I know this is inefficient, need to revisit this if it becomes an issue
        	
        	$records = array();
        	
        	foreach($cinemas as $cinema) {
        	
        		$record = FilmWeeklyCinemas::find(
        			'first',
        			array(
        				'with' => 'AustralianStates',
        				'conditions' => array('FilmWeeklyCinemas.id' => $cinema)
        			)
        		);
        		
        		$records[] = $record;;
        	
        	}
        	
     		return compact('records','cinemas', 'search');
        }
    }

}
?>