<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace app\controllers;

use lithium\data\Connections;

/**
 * Manage the browse activities
 */
class BrowseController extends \lithium\action\Controller {
	

	// list actions that can be undertaken without authentication
	public $publicActions = array('suburbs', 'cinemas');
	
	/**
	 * retrieve a list of suburbs that match a state
	 */
	public function suburbs($id = null) {
	
		if($id == null && $this->request->type() == 'json') {
			$id = $this->request->params['id'];
		}
	
		// ensure that id is in the right format
		$id = (int)$id;
		
		// get a connection to the database
        $db = Connections::get('default');
        
        // build a query to find all of the suburbs
        $sql = "SELECT suburb, count(suburb) as suburb_count
        		FROM film_weekly_cinemas
        		WHERE australian_states_id = {:id}
        		GROUP BY suburb
        		ORDER BY suburb
        	   ";
        
        // execute the query
    	$records = $db->read($sql, 
    		array(
    			'return' => 'array',
    			'id' => $id
    		)
    	);

		if($this->request->type() == 'json') {
		
			$items = array();
			
			foreach($records as $record) {
				
				$items[] = array(
        			'id' => $record['suburb'],
        			'description' => $record['suburb'] . ' (' . $record['suburb_count'] . ')'
        		);
			} 
		
			return compact('items');
		
		} else {
		
			// set a title
        	$title = 'Film Weekly Cinema Types';
        	
        	// get the URL
        	$url = $this->request->url;
        	
        	// use a basic layout
        	$this->_render['layout'] = 'not_json';
        	return compact('data', 'title', 'url');
		}
	}
}


?>