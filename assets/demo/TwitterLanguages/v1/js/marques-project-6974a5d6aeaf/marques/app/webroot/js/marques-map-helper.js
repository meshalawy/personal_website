/**
 * MARQUes - Maps Answering Research Questions
 *
 * @copyright     Copyright 2011, Flinders University (http://www.flinders.edu.au)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

/*
 * use a namespace for all of the MARQues related JavaScript
 */
 
var marques = new marquesHelper();

function marquesHelper() {

}


/**
 * function to build an array of coordinates
 */
marquesHelper.prototype.getAustralianCoords = function() {

	var coordList = null;

	// check to see if the Google Maps API is loaded
	if(typeof google.maps.Map === 'function') {
		// yes
		coordList = {
			australia: {
				LatLng: new google.maps.LatLng(-25.947028, 133.209639),
				zoom: 4
			},
			states: {
				sa: {
					LatLng: new google.maps.LatLng(-32, 135.763333),
					zoom: 6
				},
				wa: {
					LatLng: new google.maps.LatLng(-25.328055, 122.298333),
					zoom: 5
				},
				nsw: {
					LatLng: new google.maps.LatLng(-32.163333, 147.016666),
					zoom: 6
				},
				qld: {
					LatLng: new google.maps.LatLng(-22.486944, 144.431666),
					zoom: 5
				},
				tas: {
					LatLng: new google.maps.LatLng(-42.021388, 146.593333),
					zoom: 7
				},
				vic: {
					LatLng: new google.maps.LatLng(-36.854166, 144.281111),
					zoom: 6
				},
				act: {
					LatLng: new google.maps.LatLng(-35.49, 149.001388),
					zoom: 9
				},
				nt: {
					LatLng: new google.maps.LatLng(-19.383333, 133.357777),
					zoom: 6
				}
			},
			capitals: {
				adelaide: {
					LatLng: new google.maps.LatLng(-34.93, 138.60),
					zoom: 14
				},
				perth: {
					LatLng: new google.maps.LatLng(-31.95, 115.85),
					zoom: 14
				},
				sydney: {
					LatLng: new google.maps.LatLng(-33.87, 151.20),
					zoom: 14
				},
				brisbane: {
					LatLng: new google.maps.LatLng(-27.47, 153.02),
					zoom: 14
				},
				hobart: {
					LatLng: new google.maps.LatLng(-42.88, 147.32),
					zoom: 14
				},
				melbourne: {
					LatLng: new google.maps.LatLng(-37.82, 144.97),
					zoom: 14
				},
				canberra: {
					LatLng: new google.maps.LatLng(-35.30, 149.13),
					zoom: 14
				},
				darwin: {
					LatLng: new google.maps.LatLng(-12.45, 130.83),
					zoom: 14
				}
			}
		};
	} else {
		//no
		coordList = {
			australia: {
				Lat: -25.947028,
				Lng: 133.209639,
				zoom: 2
			},
			states: {
				sa: {
					Lat: -32,
					Lng: 135.763333,
					zoom: 6
				},
				wa: {
					Lat: -25.328055,
					Lng: 122.298333,
					zoom: 5
				},
				nsw: {
					Lat: -32.163333,
					Lng: 147.016666,
					zoom: 6
				},
				qld: {
					Lat: -22.486944,
					Lng: 144.431666,
					zoom: 5
				},
				tas: {
					Lat: -42.021388,
					Lng: 146.593333,
					zoom: 7
				},
				vic: {
					Lat: -36.854166,
					Lng: 144.281111,
					zoom: 6
				},
				act: {
					Lat: -35.49,
					Lng: 149.001388,
					zoom: 9
				},
				nt: {
					Lat: -19.383333,
					Lng: 133.357777,
					zoom: 6
				}
			},
			capitals: {
				adelaide: {
					Lat: -34.93,
					Lng: 138.60,
					zoom: 14
				},
				perth: {
					Lat: -31.95,
					Lng: 115.85,
					zoom: 14
				},
				sydney: {
					Lat: -33.87,
					Lng: 151.20,
					zoom: 14
				},
				brisbane: {
					Lat: -27.47,
					Lng: 153.02,
					zoom: 14
				},
				hobart: {
					Lat: -42.88,
					Lng: 147.32,
					zoom: 14
				},
				melbourne: {
					Lat: -37.82,
					Lng: 144.97,
					zoom: 14
				},
				canberra: {
					Lat: -35.30,
					Lng: 149.13,
					zoom: 14
				},
				darwin: {
					Lat: -12.45,
					Lng: 130.83,
					zoom: 14
				}
			}
		};
	}

	return coordList;
}

/**
 * get the australian coordinates for a jump link
 */
marquesHelper.prototype.countryJumpList = function() {

	var coordList = this.getAustralianCoords();
	
	var jumpList = Array();
	
	// check to see if the Google Maps API is loaded
	if(typeof google.maps.Map === 'function') {
		
		jumpList.push({
			id: 'Australia',
			value: coordList.australia.LatLng.toUrlValue() + ',' + coordList.australia.zoom
		});
	
	} else {
	
		jumpList.push({
			id: 'Australia',
			value: coordList.australia.Lat + ',' + coordList.australia.Lng + ',' + coordList.australia.zoom
		});
	
	}
	
	return jumpList;
	
}

/**
 * build the state based jump list
 */
marquesHelper.prototype.stateJumpList = function() {

	var coordList = this.getAustralianCoords();
	
	var jumpList = Array();
	
	// check to see if the Google Maps API is loaded
	if(typeof google.maps.Map === 'function') {
	
		jumpList.push({
			id: 'Australian Capital Territory',
			value: coordList.states.act.LatLng.toUrlValue() + ',' + coordList.states.act.zoom
		});
		
		jumpList.push({
			id: 'New South Wales',
			value: coordList.states.nsw.LatLng.toUrlValue() + ',' + coordList.states.nsw.zoom
		});
		
		jumpList.push({
			id: 'Northern Territory',
			value: coordList.states.nt.LatLng.toUrlValue() + ',' + coordList.states.nt.zoom
		});
		
		jumpList.push({
			id: 'Queensland',
			value: coordList.states.qld.LatLng.toUrlValue() + ',' + coordList.states.qld.zoom
		});
		
		jumpList.push({
			id: 'South Australia',
			value: coordList.states.sa.LatLng.toUrlValue() + ',' + coordList.states.sa.zoom
		});
		
		jumpList.push({
			id: 'Tasmania',
			value: coordList.states.tas.LatLng.toUrlValue() + ',' + coordList.states.tas.zoom
		});
		
		jumpList.push({
			id: 'Victoria',
			value: coordList.states.vic.LatLng.toUrlValue() + ',' + coordList.states.vic.zoom
		});
		
		jumpList.push({
			id: 'Western Australia',
			value: coordList.states.wa.LatLng.toUrlValue() + ',' + coordList.states.wa.zoom
		});
	
	} else {
	
		jumpList.push({
			id: 'Australian Capital Territory',
			value: coordList.states.act.Lat + ',' + coordList.states.act.Lng + ',' + coordList.states.act.zoom
		});
		
		jumpList.push({
			id: 'New South Walis',
			value: coordList.states.nsw.Lat + ',' + coordList.states.nsw.Lng + ',' + coordList.states.nsw.zoom
		});
		
		jumpList.push({
			id: 'Northern Territory',
			value: coordList.states.nt.Lat + ',' + coordList.states.nt.Lng + ',' + coordList.states.nt.zoom
		});
		
		jumpList.push({
			id: 'Queensland',
			value: coordList.states.qld.Lat + ',' + coordList.states.qld.Lng + ',' + coordList.states.qld.zoom
		});
		
		jumpList.push({
			id: 'South Australia',
			value: coordList.states.sa.Lat + ',' + coordList.states.sa.Lng + ',' + coordList.states.sa.zoom
		});
		
		jumpList.push({
			id: 'Tasmania',
			value: coordList.states.tas.Lat + ',' + coordList.states.tas.Lng + ',' + coordList.states.tas.zoom
		});
		
		jumpList.push({
			id: 'Victoria',
			value: coordList.states.vic.Lat + ',' + coordList.states.vic.Lng + ',' + coordList.states.vic.zoom
		});
		
		jumpList.push({
			id: 'Western Australia',
			value: coordList.states.wa.Lat + ',' + coordList.states.wa.Lng + ',' + coordList.states.wa.zoom
		});
	}
	
	return jumpList;
}

/**
 * build the state based jump list
 */
marquesHelper.prototype.cityJumpList = function() {

	var coordList = this.getAustralianCoords();
	
	var jumpList = Array();
	
	// check to see if the Google Maps API is loaded
	if(typeof google.maps.Map === 'function') {
	
		jumpList.push({
			id: 'Adelaide',
			value: coordList.capitals.adelaide.LatLng.toUrlValue() + ',' + coordList.capitals.adelaide.zoom
		});
		
		jumpList.push({
			id: 'Brisbane',
			value: coordList.capitals.brisbane.LatLng.toUrlValue() + ',' + coordList.capitals.brisbane.zoom
		});
		
		jumpList.push({
			id: 'Canberra',
			value: coordList.capitals.canberra.LatLng.toUrlValue() + ',' + coordList.capitals.canberra.zoom
		});
		
		jumpList.push({
			id: 'Darwin',
			value: coordList.capitals.darwin.LatLng.toUrlValue() + ',' + coordList.capitals.darwin.zoom
		});
		
		jumpList.push({
			id: 'Hobart',
			value: coordList.capitals.hobart.LatLng.toUrlValue() + ',' + coordList.capitals.hobart.zoom
		});
		
		jumpList.push({
			id: 'Melbourne',
			value: coordList.capitals.melbourne.LatLng.toUrlValue() + ',' + coordList.capitals.melbourne.zoom
		});
		
		jumpList.push({
			id: 'Perth',
			value: coordList.capitals.perth.LatLng.toUrlValue() + ',' + coordList.capitals.perth.zoom
		});
		
		jumpList.push({
			id: 'Sydney',
			value: coordList.capitals.sydney.LatLng.toUrlValue() + ',' + coordList.capitals.sydney.zoom
		});

	} else {
	
		jumpList.push({
			id: 'Adelaide',
			value: coordList.capitals.adelaide.Lat + ',' + coordList.capitals.adelaide.Lng + ',' + coordList.capitals.adelaide.zoom
		});
		
		jumpList.push({
			id: 'Brisbane',
			value: coordList.capitals.brisbane.Lat + ',' + coordList.capitals.brisbane.Lng + ',' + coordList.capitals.brisbane.zoom
		});
		
		jumpList.push({
			id: 'Canberra',
			value: coordList.capitals.canberra.Lat + ',' + coordList.capitals.canberra.Lng + ',' + coordList.capitals.canberra.zoom
		});
		
		jumpList.push({
			id: 'Darwin',
			value: coordList.capitals.darwin.Lat + ',' + coordList.capitals.darwin.Lng + ',' + coordList.capitals.darwin.zoom
		});
		
		jumpList.push({
			id: 'Hobart',
			value: coordList.capitals.hobart.Lat + ',' + coordList.capitals.hobart.Lng + ',' + coordList.capitals.hobart.zoom
		});
		
		jumpList.push({
			id: 'Melbourne',
			value: coordList.capitals.melbourne.Lat + ',' + coordList.capitals.melbourne.Lng + ',' + coordList.capitals.melbourne.zoom
		});
		
		jumpList.push({
			id: 'Perth',
			value: coordList.capitals.perth.Lat + ',' + coordList.capitals.perth.Lng + ',' + coordList.capitals.perth.zoom
		});
		
		jumpList.push({
			id: 'Sydney',
			value: coordList.capitals.sydney.Lat + ',' + coordList.capitals.sydney.Lng + ',' + coordList.capitals.sydney.zoom
		});
	
	}
	
	return jumpList;
}

/**
 * method to pan and zoom the map
 *
 * NOTE: this method is google maps specific
 */
marquesHelper.prototype.panAndZoom = function (map, value) {

	// split the value
	var values = value.split(',');
	
	var latLng = new google.maps.LatLng(parseFloat(values[0]), parseFloat(values[1]));
	
	map.panTo(latLng);
	map.setZoom(parseFloat(values[2]));
}

/**
 * method to delete marker(s) from the map
 *
 * NOTE: this method is google maps specific
 */
marquesHelper.prototype.deleteMarker = function (map, markers) {

	// check to see if markers is an array
	if($.isArray(markers) == true) {
		// process all the elements in the array
		$.each(markers, function(index, value){
				value.setMap(null);
		});
		
		//markers = new Array();
	
	} else {
		// treat this as a single instance
		markers.setMap(null);
	}
}


/**
 * compute a hash of the lat lngs for indexing collections of objects
 * 
 * TODO: delevelop a more robust hash algorithm
 */
marquesHelper.prototype.computeLatLngHash = function(latitude, longitude) {

	if(longitude == null) {
		
		var coords = latitude.split(',');
		
		latitude  = coords[0];
		longitude = coords[1];
	
	}

    var lat = parseFloat(latitude);
    var lng = parseFloat(longitude);
    
    var latlngHash = (lat.toFixed(6) + "" + lng.toFixed(6));
    
    latlngHash     = latlngHash.replace(".","").replace(",", "").replace("-", "");
    latlngHash     = latlngHash.replace(".","").replace(",", "").replace("-", "");
    
    return latlngHash;
}

/**
 * fill a select box with items retrieved via ajax
 */
marquesHelper.prototype.fillSelectBox = function(id, url, ignoreFirst, addDefault) {

	// get a jQuery object for the id
	var selectBox = $(id);
	
	// get the data and populate the select box
	$.get(url, function(data) {
	
		selectBox.empty();
		
		var items = '';
		var list = data.items;
		
		// add a default value of required
		if(addDefault != null) {
			items += '<option value="default">' + addDefault + '</option>';
		}
		
		if(ignoreFirst == true) {
			$.each(data.items, function(index, value) {
				if(index != 0) {
					items += '<option value="' + value.id + '">' + value.description + '</option>';
				}
			});		
		} else {
			$.each(data.items, function(index, value) {
				items += '<option value="' + value.id + '">' + value.description + '</option>';
			});	
		}
		
		selectBox.append(items);
		
	});
}