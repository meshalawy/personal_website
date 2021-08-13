<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace app\extensions\helper;

/**
 * provide reusable helper methods for HTML specific to the MARQues system
 */
class MarquesHTML extends \lithium\template\Helper {

	// output a mailto link
	public function mailto($email) {
		$email = $this->escape($email);
		return "<a href=\"mailto://$email\">$email</a>";
	}

}