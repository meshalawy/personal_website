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

use app\models\AustralianStates;

/**
 * Manage the Australian States in the database
 */
class AustralianStatesController extends \lithium\action\Controller {

	// list actions that can be undertaken without authentication
	public $publicActions = array('items', 'itemsbyid');
	
	/**
	 * list all of the records
	 */
    public function items() {
        
        
        if($this->request->type() == 'json') {
        	
        	$data = AustralianStates::all(array('order' => array('shortname' => 'ASC')));
        	
        	$items = array();
        	
        	$items[] = array('id' => 'All', 'description' => 'All');
        	
        	foreach($data as $datum) {
        		
        		$items[] = array(
        			'id' => $datum->shortname,
        			'description' => $datum->shortname
        		);
        	}
        	
        	return compact('items');
        } else {
        	
        	// get the data
        	$data = AustralianStates::all(array('order' => array('id' => 'ASC')));
        	
        	// set a title
        	$title = 'Australian States';
        	
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
    public function itemsbyid() {
        
        
        if($this->request->type() == 'json') {
        	
        	$data = AustralianStates::all(array('order' => array('shortname' => 'ASC')));
        	
        	$items = array();
        	
        	$items[] = array('id' => 'All', 'description' => 'All');
        	
        	foreach($data as $datum) {
        		
        		$items[] = array(
        			'id' => $datum->id,
        			'description' => $datum->shortname
        		);
        	}
        	
        	return compact('items');
        } else {
        	
        	// get the data
        	$data = AustralianStates::all(array('order' => array('id' => 'ASC')));
        	
        	// set a title
        	$title = 'Australian States';
        	
        	// get the URL
        	$url = $this->request->url;
        	
        	// use a basic layout
        	$this->_render['layout'] = 'not_json';
        	return compact('data', 'title', 'url');
        	
        }	
    }


	/**
	 * list all of the states
	 */
    public function index() {
        
        // get the list of categories
        $data = AustralianStates::all(array('order' => array('id' => 'ASC')));
        return compact('data');
    }
    
    /**
     * add a new category to the database
     */
    public function add() {
    
    	// create a new category with the posted data
    	$data = AustralianStates::create($this->request->data);
    	
    	// check to see if data as send and the save was successful
    	if(($this->request->data) && $data->save()) {
    		// redirect back to the index page
    		Flash::write('Success: New record created');
    		return $this->redirect('AustralianStates::index');
    	}
    	
    	// show the default category create form
    	return compact('data');
    	
    }
    
    /**
     * edit an existing category
     */
    public function edit($id = null) {
    
    	$id = (int)$id;
    	$data = AustralianStates::find($id);
    	
    	if(empty($data)) {
    		return $this->redirect('AustralianStates::index');
    	}
    	
    	if($this->request->data){
    		if($data->save($this->request->data)) {
    			Flash::write('Success: Record updated');
    			return $this->redirect('AustralianStates::index');
    		} else {
    			Flash::write('Error: An error occurred please try again.');
    			return $this->redirect('AustralianStates::index');
    		}
    	}
    	
    	return compact('data');
    }
    
    /**
     * delete an existing category
     */
    public function delete($id = null) {
        
        $id = (int)$id;
        
        AustralianStates::remove(array('id' => $id));
        Flash::write('Success: Record deleted');
        return $this->redirect('AustralianStates::index');    
    }

}
?>