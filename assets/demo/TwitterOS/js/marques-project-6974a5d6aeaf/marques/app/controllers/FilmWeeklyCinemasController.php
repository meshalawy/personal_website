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
use app\models\AustralianStates;
use app\models\FilmWeeklyCinemaTypes;
use app\models\LocalityTypes;
use app\models\FilmWeeklyCategoryMaps;
use app\models\FilmWeeklyArchaeology;

/**
 * Manage the Film Weekly Cinemas in the database
 */
class FilmWeeklyCinemasController extends \lithium\action\Controller {

	/**
	 * list all of the cinema records
	 */
    public function index() {
        
        // add the pagination control variables
        $limit = 10;
		$page  = $this->request->page ?: 1;
		$order = array('id' => 'ASC');
		$total = FilmWeeklyCinemas::count();
		$with  = array('AustralianStates');
         
        
        // get the list of cinemas
        $data = FilmWeeklyCinemas::all(compact('order', 'limit', 'page', 'with'));
        
        return compact('data', 'total', 'page', 'limit');

    }
    
    /**
     * add a new record to the database
     */
    public function add() {
        
        if(!$this->request->data) {
        	
        	$data = $this->get_extra_form_data();
        	$form_data = FilmWeeklyCinemas::create();
        	$data['form'] = $form_data;
			$this->set(compact('data'));
			
		} else {
		
			$form_data = FilmWeeklyCinemas::create($this->request->data);
		
			if($form_data->save()) {				
				// redirect back to the index page
	    		Flash::write('Success: Record created');
	    		return $this->redirect('FilmWeeklyCinemas::index');
			} else {
				// get the rest of the form data and show errors
        		$data = $this->get_extra_form_data();
	        	$data['form'] = $form_data;
				return(compact('data'));
			}
    	}
    }
    
    // get the data to build the form
    private function get_extra_form_data() {
    
    	// build a list of states
		$records = AustralianStates::all(array('order' => array('longname' => 'ASC')));
		$state_list = array();
		foreach($records as $record) {
			$state_list[$record->id] = $record->longname;
		}
		
		// build a list of cinema types
		$records = FilmWeeklyCinemaTypes::all(array('order' => array('description' => 'ASC')));
		$cinema_types = array();
		foreach($records as $record) {
			$cinema_types[$record->id] = $record->description;
		}
		
		// build a list of locality types
		$records = LocalityTypes::all(array('order' => array('description' => 'ASC')));
		$locality_types = array();
		foreach($records as $record) {
			$locality_types[$record->id] = $record->description;
		}
		
		// output the data to the view
		$data = array(
			'states'     => $state_list,
			'types'      => $cinema_types,
			'localities' => $locality_types
		);
		
		return $data;
    }

    
    /**
     * edit an existing record
     */
    public function edit($id = null) {
    
    	$id = (int)$id;
    	
    	// get the cinema data
    	$cinema = FilmWeeklyCinemas::find($id);
    	
    	if(empty($cinema)) {
    		return $this->redirect('FilmWeeklyCinemas::index');
    	}
    	
    	if($this->request->data) {
    	
    		if($cinema->save($this->request->data)) {
    			Flash::write('Success: Record updated');
    			return $this->redirect('FilmWeeklyCinemas::index');
    		} else {
    			Flash::write('Error: An error occurred please try again.');
    			return $this->redirect('FilmWeeklyCinemas::index');
    		}

    	} else {
    	
    		// get the other data
	    	$data = $this->get_extra_form_data();
	    	$data['form'] = $cinema;
			return(compact('data'));
    	}
    }
        
    /**
     * delete an existing category
     */
    public function delete($id = null) {
        
        $id = (int)$id;
        
        // delete any other existing data
        FilmWeeklyArchaeology::remove(
        	array(
        		'film_weekly_cinemas_id' => $id
        	)
        );
        
        FilmWeeklyCategoryMaps::remove(
        	array(
        		'film_weekly_cinemas_id' => $id
        	)
        );
        
        FilmWeeklyCinemas::remove(
        	array(
        		'id' => $id
        	)
        );
        
        Flash::write('Success: Record deleted');
        return $this->redirect('FilmWeeklyCinemas::index');    
    }
}
?>