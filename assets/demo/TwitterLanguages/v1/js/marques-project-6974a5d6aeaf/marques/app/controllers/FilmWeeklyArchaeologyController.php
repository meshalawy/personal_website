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

use app\models\FilmWeeklyArchaeology;
use app\models\FilmWeeklyCinemas;
use app\models\FilmWeeklyCategories;

/**
 * Manage the Film Weekly Category Maps in the database
 */
class FilmWeeklyArchaeologyController extends \lithium\action\Controller {

	/**
	 * list categories for a cinema
	 */
	public function index($id = null) {
	
		if($id == null) {
				
			// redirect back to the index page
    		Flash::write('Error: Select a Cinema Before Adding Archaeology Records');
    		return $this->redirect(array('FilmWeeklyCinemas::index'));
		
		}
	
		$cinema = FilmWeeklyCinemas::first(
			array (
				'conditions' => array('FilmWeeklyCinemas.id' => $id),
				'with'       => array('FilmWeeklyArchaeology')
			)
		);
		
		$records = FilmWeeklyCategories::all(array('order' => array('description' => 'ASC')));
		
		$categories = array();
    	
    	foreach($records as $record) {
    	
	    	$categories[$record->id] = $record->description;
    	}
		
		$this->set(compact('cinema', 'categories'));
	}


	/**
     * add a new record to the database
     */
    public function add($id = null) {
        
        $cinema = FilmWeeklyCinemas::first(
			array (
				'conditions' => array('id' => $id),
			)
		);
		
		$records = FilmWeeklyCategories::all(array('order' => array('description' => 'ASC')));
    	
    	$categories = array();
    	
    	foreach($records as $record) {
    	
	    	$categories[$record->id] = $record->description;
    	}
    
        if(!$this->request->data) {
	    	
	    	$archaeology = FilmWeeklyArchaeology::create();
			
			$this->set(compact('cinema', 'categories', 'archaeology'));
		} else {
		
			$archaeology = FilmWeeklyArchaeology::create($this->request->data);
			
			if($archaeology->save()) {
			
				Flash::write('Success: Record Created');
        		return $this->redirect(array('FilmWeeklyArchaeology::index', 'args' => $id));
			
			} else {
				$this->set(compact('cinema', 'categories', 'archaeology'));
			}
		}
   }
	
	/**
	 * delete a record
	 */
	public function delete($id = null) {
        
        $id = (int)$id;
        
        $record = FilmWeeklyArchaeology::first(
        	array(
        		'conditions' => array('id' => $id)
        	)
        );
        
        $cinema_id = $record->film_weekly_cinemas_id;
                
      	FilmWeeklyArchaeology::remove(array('id' => $id));
        Flash::write('Success: Record deleted');
        return $this->redirect(array('FilmWeeklyArchaeology::index', 'args' => $cinema_id));
	}
}
?>