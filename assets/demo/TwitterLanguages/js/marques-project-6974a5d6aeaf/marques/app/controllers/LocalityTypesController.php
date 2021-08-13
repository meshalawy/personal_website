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

use app\models\LocalityTypes;

/**
 * Manage the Film Weekly Categories in the database
 */
class LocalityTypesController extends \lithium\action\Controller {

	// list actions that can be undertaken without authentication
	public $publicActions = array('items');
	
	/**
	 * list all of the records
	 */
    public function items() {
        
        
        if($this->request->type() == 'json') {
        	
        	$data = LocalityTypes::all(array('order' => array('id' => 'ASC')));
        	
        	$items = array();
        	
        	$items[] = array('id' => 'all', 'description' => 'All');
        	
        	foreach($data as $datum) {
        		
        		$items[] = array(
        			'id' => $datum->id,
        			'description' => $datum->description
        		);
        	}
        	
        	return compact('items');
        	
        } else {
        	
        	// get the data
        	$data = LocalityTypes::all(array('order' => array('id' => 'ASC')));
        	        	
        	// set a title
        	$title = 'Locality Types';
        	
        	// get the URL
        	$url = $this->request->url;
        	
        	// use a basic layout
        	$this->_render['layout'] = 'not_json';
        	return compact('data', 'title', 'url');
        }	
    }


	/**
	 * list all of the records
	 */
    public function index() {
        
        // get the list of records
        $data = LocalityTypes::all(array('order' => array('id' => 'ASC')));
        return compact('data');
    }
    
    /**
     * add a new record
     */
    public function add() {
    
    	// create a new record with the posted data
    	$data = LocalityTypes::create($this->request->data);
    	
    	// check to see if data as send and the save was successful
    	if(($this->request->data) && $data->save()) {
    		// redirect back to the index page
    		Flash::write('Success: Record created');
    		return $this->redirect('LocalityTypes::index');
    	}
    	
    	// show the default category create form
    	return compact('data');
    	
    }
    
    /**
     * edit an existing record
     */
    public function edit($id = null) {
    
    	$id = (int)$id;
    	$data = LocalityTypes::find($id);
    	
    	if(empty($data)) {
    		return $this->redirect('LocalityTypes::index');
    	}
    	
    	if($this->request->data){
    		if($data->save($this->request->data)) {
    			Flash::write('Success: Record updated');
    			return $this->redirect('LocalityTypes::index');
    		} else {
    			Flash::write('Error: An error occurred please try again.');
    			return $this->redirect('LocalityTypes::index');
    		}
    	}
    	
    	return compact('data');
    }
    
    /**
     * delete an existing record
     */
    public function delete($id = null) {
        
        $id = (int)$id;
        
        LocalityTypes::remove(array('id' => $id));
        Flash::write('Success: Record deleted');
        return $this->redirect('LocalityTypes::index');    
    }
}
?>