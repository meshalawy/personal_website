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

use app\models\Users;
use app\models\FilmWeeklyCinemas;

/**
 * central spot for admin tasks
 */
class AdminController extends \lithium\action\Controller {

	/**
	 * display the start admin page
	 */
    public function index() {
        
        // get a count of the number of users
        $user_count = Users::find('count');
        $fw_cinema_count = FilmWeeklyCinemas::find('count');

        return compact('user_count', 'fw_cinema_count');
    }
}
?>