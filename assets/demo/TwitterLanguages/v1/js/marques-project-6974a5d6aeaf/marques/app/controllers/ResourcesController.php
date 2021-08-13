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

use app\models\Resources;

/**
 * Manage the Film Weekly Categories in the database
 */
class ResourcesController extends \lithium\action\Controller {


	/**
	 * list all of the records
	 */
    public function index() {
        
        // add the pagination control variables
        $limit = 10;
		$page  = $this->request->page ?: 1;
		$order = array('id' => 'ASC');
		$total = Resources::count();
        
        // get the list of cinemas
        $data = Resources::all(compact('order', 'limit', 'page'));
        
        return compact('data', 'total', 'page', 'limit');
    }
    
    /**
     * add a new record
     */
    public function add() {
    
    	// create a new record with the posted data
    	$data = Resources::create($this->request->data);
    	
    	// check to see if data as send and the save was successful
    	if(($this->request->data) && $data->save()) {
    		// redirect back to the index page
    		Flash::write('Success: Record created');
    		return $this->redirect('Resources::index');
    	}
    	
    	// show the default category create form
    	return compact('data');
    	
    }
    
    /**
     * edit an existing record
     */
    public function edit($id = null) {
    
    	$id = (int)$id;
    	$data = Resources::find($id);
    	
    	if(empty($data)) {
    		return $this->redirect('Resources::index');
    	}
    	
    	if($this->request->data){
    		if($data->save($this->request->data)) {
    			Flash::write('Success: Record updated');
    			return $this->redirect('Resources::index');
    		} else {
    			Flash::write('Error: An error occurred please try again.');
    			return $this->redirect('Resources::index');
    		}
    	}
    	
    	return compact('data');
    }
    
    /**
     * delete an existing record
     */
    public function delete($id = null) {
        
        $id = (int)$id;
        
        Resources::remove(array('id' => $id));
        Flash::write('Success: Record deleted');
        return $this->redirect('Resources::index');    
    }
}
?>