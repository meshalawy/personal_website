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

/**
 * Manage authentication actions
 */

class SessionsController extends \lithium\action\Controller {

	// list actions that can be undertaken without authentication
	public $publicActions = array('add');

	/**
	 * authenticate the user
	 */
    public function add() {
    	// validate the authentication request
        if ($this->request->data) {
        	if( Auth::check('default', $this->request)) {
		        // authentication was successful
		        return $this->redirect('Admin::index');
		    } else {
		    	// authentication failed
		    	Flash::write('Error: Login failed. Check your username and password and try again');
		    	return $this->redirect('Sessions::add');
		    }
		}
    }

    /**
     * clear the authentication of the user
     */
    public function delete() {
        Auth::clear('default');
        
        // authentication failed
    	Flash::write('You have successfully logged out of the MARQUes system');
    	return $this->redirect('Sessions::add');
    }
}
?>