<?php
/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace app\controllers;

use app\models\FilmWeeklyCinemas;
use app\models\AustralianStates;
use app\models\FilmWeeklyCinemaTypes;
use app\models\LocalityTypes;
use app\models\FilmWeeklyCategoryMaps;
use app\models\FilmWeeklyArchaeology;
use app\models\FilmWeeklyCategories;
use app\models\FilmWeeklyResourceMaps;
use app\models\FilmWeeklyMarkers;

/**
 * Manage the Film Weekly Cinemas in the database
 */
class FilmWeeklyInfoWindowsController extends \lithium\action\Controller {

	// list actions that can be undertaken without authentication
	public $publicActions = array('content');
	
/*
	// enable content negotiation so AJAX data can be returned
	protected function _init() {
        $this->_render['negotiate'] = true;
        parent::_init();
    }
*/

	/**
	 * build the content of an infoWindow for a Film Weekly Marker
	 */
    public function content($id = null) {
    
    	// make sure the id is an integer
    	$id = (int)$id;
    
    	// find the cinema
    	$cinema = FilmWeeklyCinemas::find(
			'first',
			array(
				'with' => array('AustralianStates', 'FilmWeeklyArchaeology'),
				'conditions' => array('FilmWeeklyCinemas.id' => $id)
			)
		);
		
		$categories = $this->get_film_weekly_categories();
		
		$listings = $this->get_film_weekly_listings($id, $categories);
		
		$resources = $this->get_film_weekly_resources($id);
		
		$markers = $this->getFilmWeeklyMarkers();
		
		$this->_render['layout'] = 'plain_text';
		return compact('cinema', 'categories', 'maps', 'listings', 'resources', 'markers');
    
    }
    
    // private function to get a list of film weekly categories
    private function get_film_weekly_categories() {
    
    	$categories = FilmWeeklyCategories::all();
    	
    	$records = array();
    	
    	foreach($categories as $category) {
    		
    		$records[$category->id] = $category->description;
    	}
    	
    	return $records;
    }
    
    // private function to get the film weekly listings range
    private function get_film_weekly_listings($id, $categories) {
    
    	$maps = FilmWeeklyCategoryMaps::all(
			array(
				'conditions' => array('film_weekly_cinemas_id' => $id)
			)
		);
		
		$min = null;
		$max = null;
		
		foreach($maps as $map) {
		
			if($min == null) {
				$min = $map->film_weekly_categories_id;
			}
			
			$max = $map->film_weekly_categories_id;
		}
		
		$min = $categories[$min];
		$max = $categories[$max];
		
		$min = explode('/', $min);
		$min = $min[0];
		
		$max = explode('/', $max);
		
		if(count($max) == 2) {
			$max = '19' . $max[1];
		} else {
			$max = $max[0];
		}
		
		return $min . ' - ' . $max;
    
    }
    
    // private function to get any resources that may be available
    private function get_film_weekly_resources($id) {
    
    	$records = FilmWeeklyResourceMaps::all(
    		array(
				'conditions' => array('film_weekly_cinemas_id' => $id),
				'with'       => array('Resources')
			)
    	);

    	$resources = array();
    	$resource  = array();
    	
    	foreach($records as $record) {
    	
    		$resource['title'] = $record->resource->title;
    		$resource['description'] = $record->resource->description;
    		$resource['url'] = $record->resource->url;
    		
    		$resources[] = $resource;
    	
    	}
    	
    	return $resources;
    }
    
    /*
     * private function to get the list of markers
     */
    private function getFilmWeeklyMarkers() {
    
    	$markers = array();
    	
    	$records = FilmWeeklyMarkers::all();
    	
    	foreach($records as $record) {
    	
    		if(empty($markers[$record->film_weekly_cinema_types_id])) {
    		
    			$markers[$record->film_weekly_cinema_types_id] = array(
    				$record->locality_types_id => $record->marker_url
    			);
    		} else {
    			$markers[$record->film_weekly_cinema_types_id][$record->locality_types_id] = $record->marker_url;
    		}
    	}
    	
    	return $markers;
    
    }
}
?>