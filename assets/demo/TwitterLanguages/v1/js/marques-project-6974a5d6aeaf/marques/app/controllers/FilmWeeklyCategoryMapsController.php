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
use app\models\FilmWeeklyCategories;
use app\models\FilmWeeklyCategoryMaps;

/**
 * Manage the Film Weekly Category Maps in the database
 */
class FilmWeeklyCategoryMapsController extends \lithium\action\Controller {

	/**
	 * list categories for a cinema
	 */
	public function index($id = null) {
	
		if($id == null) {
				
			// redirect back to the index page
    		Flash::write('Error: Select a Cinema Before Viewing Categories');
    		return $this->redirect(array('FilmWeeklyCinemas::index'));
		
		}
	
		$cinema = FilmWeeklyCinemas::first(
			array (
				'conditions' => array('id' => $id)
			)
		);
		
		$categories = FilmWeeklyCategoryMaps::all(
			array (
				'conditions' => array('film_weekly_cinemas_id' => $id),
				'with' => 'FilmWeeklyCategories'
			)
		);
		
		$this->set(compact('cinema', 'categories'));
	}


	/**
     * add a new record to the database
     */
    public function add($id = null) {
        
        if(!$this->request->data) {
        	
        	$data = $this->get_cinema_data($id);
        	
			$this->set(compact('data'));
			
		} else {
		
			$map = FilmWeeklyCategoryMaps::create($this->request->data);
		
			if($map->save()) {				
				// redirect back to the index page
	    		Flash::write('Success: Record created');
	    		return $this->redirect(array('FilmWeeklyCategoryMaps::index', 'args' => $id));
			} else {
				// get the rest of the form data and show errors
        		$data = $this->get_cinema_data($id);
	        	$data['form'] = $map;
				return(compact('data'));
			}	
    	}
    }

	/**
	 * get the data to fill in the form
	 */
	private function get_cinema_data($id) {
	
		$cinema  = FilmWeeklyCinemas::find($id);
		
		$records = FilmWeeklyCategoryMaps::all(
			array (
				'conditions' => array('film_weekly_cinemas_id' => $id)
			)
		);
		
		$excludes = array();
		
		foreach($records as $record) {
			$excludes[] = $record->film_weekly_categories_id;
		}
		
		
    	$records = FilmWeeklyCategories::all(array('order' => array('description' => 'ASC')));
    	
    	$categories = array();
    	
    	foreach($records as $record) {
    	
    		if(!in_array($record->id, $excludes)) {
	    		$categories[$record->id] = $record->description;
	    	}
    	}
    	
    	$data = array(
    		'cinema' => $cinema,
    		'categories' => $categories,
    		'form' => FilmWeeklyCategoryMaps::create(),
    	);

		return $data;
	}
	
	/**
	 * delete a category map
	 */
	public function delete($id = null) {
        
        $id = (int)$id;
        
        $record = FilmWeeklyCategoryMaps::first(
        	array(
        		'conditions' => array('id' => $id)
        	)
        );
        
        $cinema = $record->film_weekly_cinemas_id;
        
      	FilmWeeklyCategoryMaps::remove(array('id' => $id));
        Flash::write('Success: Record deleted');
        return $this->redirect(array('FilmWeeklyCategoryMaps::index', 'args' => $cinema));
	}
}
?>