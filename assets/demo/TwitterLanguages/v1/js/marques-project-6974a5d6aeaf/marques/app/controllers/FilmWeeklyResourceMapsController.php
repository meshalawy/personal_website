<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace app\controllers;

use lithium\security\Auth;
use lithium\storage\Session;
use li3_flash\extensions\storage\Flash;

use app\models\FilmWeeklyCinemas;
use app\models\Resources;
use app\models\FilmWeeklyResourceMaps;

/**
 * Manage the Film Weekly Resource Maps in the database
 */
class FilmWeeklyResourceMapsController extends \lithium\action\Controller {

	/**
	 * list categories for a cinema
	 */
	public function index($id = null) {
	
		// add the pagination control variables
        $limit = 10;
		$page  = $this->request->page ?: 1;
		$order = array('id' => 'ASC');
		$total = FilmWeeklyResourceMaps::count();
        
        // get the list of cinemas
        $data = FilmWeeklyResourceMaps::all(compact('order', 'limit', 'page'));
        
        return compact('data', 'total', 'page', 'limit');
	}


	/**
     * add a new record to the database
     */
    public function add($id = null) {
        
        // create a new record with the posted data
    	$data = FilmWeeklyResourceMaps::create($this->request->data);
    	
    	// check to see if data as send and the save was successful
    	if(($this->request->data) && $data->save()) {
    		// redirect back to the index page
    		Flash::write('Success: Record created');
    		return $this->redirect('FilmWeeklyResourceMaps::index');
    	}
    	
    	// show the default category create form
    	return compact('data');
    }
    
    /**
     * edit an existing record
     */
    public function edit($id = null) {
    
    	$id = (int)$id;
    	$data = FilmWeeklyResourceMaps::find($id);
    	
    	if(empty($data)) {
    		return $this->redirect('FilmWeeklyResourceMaps::index');
    	}
    	
    	if($this->request->data){
    		if($data->save($this->request->data)) {
    			Flash::write('Success: Record updated');
    			return $this->redirect('FilmWeeklyResourceMaps::index');
    		} else {
    			Flash::write('Error: An error occurred please try again.');
    			return $this->redirect('FilmWeeklyResourceMaps::index');
    		}
    	}
    	
    	return compact('data');
    }

		
	/**
	 * delete a category map
	 */
	public function delete($id = null) {
        
        $id = (int)$id;
        
        FilmWeeklyResourceMaps::remove(array('id' => $id));
        Flash::write('Success: Record deleted');
        return $this->redirect('FilmWeeklyResourceMaps::index');  
	}
	
	/**
	 * associate a cinema with a resource
	 */
	public function associate($id = null) {
	
		// get the cinema
		if($id == null) {
				
			// redirect back to the index page
    		Flash::write('Error: Select a Cinema Before Associating a Resource');
    		return $this->redirect(array('FilmWeeklyCinemas::index'));
		
		}
	
		$cinema = FilmWeeklyCinemas::first(
			array (
				'conditions' => array('FilmWeeklyCinemas.id' => $id)
			)
		);
		
		// get any previous associations
		$records = FilmWeeklyResourceMaps::find(
			'all',
			array(
				'conditions' => array(
					'film_weekly_cinemas_id' => $id
				)
			)
		);
		
		$associations = array();
		
		foreach($records as $record) {
		
			array_push($associations, $record->resources_id);
		
		}
		
		// add the pagination control variables
        $limit = 10;
		$page  = $this->request->page ?: 1;
		$order = array('id' => 'DESC');
		$total = Resources::count();
		
		$resources = Resources::all(compact('order', 'limit', 'page'));
		
		// return the data
		return compact('cinema', 'resources', 'total', 'page', 'limit', 'associations');
	
	}
	
	/**
	 * make the new resource map
	 */
	public function make($id) {
	
		// get the identifiers
		if($id == null) {
			// redirect back to the index page
    		Flash::write('Error: Select a Cinema Before Associating a Resource');
    		return $this->redirect(array('FilmWeeklyCinemas::index'));
		}
		
		$id = explode('-', $id);
		
		if(count($id) != 2) {
			// redirect back to the index page
    		Flash::write('Error: Select a Cinema Before Associating a Resource');
    		return $this->redirect(array('FilmWeeklyCinemas::index'));
		}
		
		// check for duplicates before saving
		$record = FilmWeeklyResourceMaps::find(
			'first',
			array(
				'conditions' => array(
					'film_weekly_cinemas_id' => $id[0],
					'resources_id'           => $id[1]
				)
			)
		);
		
		if(count($record) > 0) {
			// redirect back to the index page
    		Flash::write('Error: This cinema is already associated with the resource');
    		return $this->redirect(array('FilmWeeklyResourceMaps::associate', 'args' => $id[0]));
		}
		
		$data = array(
			'film_weekly_cinemas_id' => $id[0],
			'resources_id'           => $id[1]
		);
		
		$record = FilmWeeklyResourceMaps::create($data);
		
		if($record->save()) {
			Flash::write('Success: Record updated');
			return $this->redirect(array('FilmWeeklyResourceMaps::associate', 'args' => $id[0]));
		} else {
			Flash::write('Error: An error occurred please try again.');
			return $this->redirect(array('FilmWeeklyResourceMaps::associate', 'args' => $id[0]));
		}	
	}
}
?>