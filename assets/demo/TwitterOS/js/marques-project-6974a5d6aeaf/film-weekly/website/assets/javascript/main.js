/**
 * Mapping the Movies
 *
 * @copyright     Copyright 2011, Flinders Institute for Research in the Humanities - Flinders University (http://www.flinders.edu.au)
 * @license       All Rights Reserved
 */
 
// global variables
var map = null;
var infoWindow = null;
var filmWeeklyCategories = null;
var mapUpdated = true;

var currentTimeInterval = 0;
var nextTimeout = null;

var mapData = {
	hashes:  [], 
	data:    [],
	markers: []
};

// flag to indicate that the OverlappingMarkerSpiderfier plugin should be used
// disable the plugin if it doesn't work due to change in the Google Maps API
// more information on the plugin here: https://github.com/jawj/OverlappingMarkerSpiderfier
var useOverlappingMarkerSpiderfier = true;
var oms = null;


//populate the page
$(document).ready(function() {
		
	// initialise the UI elements
	initUI();
	
	// bind the resize map function to the resize event for the window
	$(window).resize(function() {
		resizeMap();
	});
	
	// initalise the map
	var coords = marques.getAustralianCoords().australia;
	
	var myOptions = {
		zoom: coords.zoom,
		center: coords.LatLng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	map = new google.maps.Map(document.getElementById('map'), myOptions);
	
	if(useOverlappingMarkerSpiderfier == true) {
		oms = new OverlappingMarkerSpiderfier(map);
	}
	
	// finalise the page by removing the js class
	$('.js').removeClass('js');
	
	//resize the map
	resizeMap();
	
	// show the welcome message if required
	showWelcome();
	
	// initialise the time slider
	initTimeSlider();

});

// function to initialise the time slider
function initTimeSlider() {

	// get the list of film weekly dates
	$.get('/marques/film_weekly_categories/items.json', function(data){
		
		var items = data.items;
		
		filmWeeklyCategories = items;
		
	});
}

// function to show the welcome message
function showWelcome() {

	// populate the welcome message
	$.get('/marques/pages/welcome', function(data){
	
		// add the data to the div and load the welcome box
		$('#welcome_dialog_text').empty().append(data);
		$('#welcome_dialog').dialog('open');
	});
}

// initialisation functions
function initUI() {

	// initalise the ui elements
	$('.fw-button').button();

	// initialise the buttons
	$('#btn_search').click(function() {
		$('#search_dialog').dialog('open');
	});
	
	$('#btn_adv_search').click(function() {
		$('#adv_search_dialog').dialog('open');
	});
	
	$('#btn_browse').click(function() {
		$('#browse_dialog').dialog('open');
	});
	
	$('#btn_controls').click(function(){
		$('#controls_dialog').dialog('open');
	});
	
	$('#btn_time_slider').click(function(){
		$('#time_slider_dialog').dialog('open');
	});
	
	$('#btn_contribute').click(function() {
		$('#contribute_dialog').dialog('open');
	});
	
	$('#btn_film_weekly').click(function() {
	
		// populate the film weekly dialog message
		$.get('/marques/pages/filmweekly', function(data){
			$('#film_weekly_dialog_text').empty().append(data);
			$('#film_weekly_dialog').dialog('open');
		});
	
	});
	
	$('#btn_about').click(function() {
	
		// populate the about message
		$.get('/marques/pages/about', function(data){
			$('#about_dialog_text').empty().append(data);
			$('#about_dialog').dialog('open');
		});
	
	});
	
	// populate the help dialog message
	$.get('/marques/pages/help', function(data){
		$('#help_dialog_text').empty().append(data);
		$('.help-top-link').click(function() {
			$('#help_dialog_text').parent().scrollTo($('#help_top'), {duration:1000});
		});
	});
	
	$('#btn_help').click(function() {
		$('#help_dialog').dialog('open');
	});
	
	// populate the legend dialog box
	$.get('/marques/pages/legend', function(data){
		$('#legend_dialog_text').empty().append(data);
		
		// build the table
		$.get('/marques/film_weekly_markers/items.json', function(data){
			
			var items = '';
			
			$.each(data.items, function(index, value) {
				items += '<tr><td>' + value.cinema_type + '</td>';
				items += '<td>' + value.locality_type + '</td>';
				items += '<td class="fw-center-cell"><img src="' + value.icon_url + '"/></td></tr>';
			});
			
			$('#legend_marker_icons').append(items);
		});
	});
	
	$('#btn_legend').click(function() {
		$('#legend_dialog').dialog('open');
	});
	
	// populate the contribute dialog message
	$.get('/marques/pages/contribute', function(data){
		$('#contribute_dialog_text').empty().append(data);
	});
	
	// initialise the add to map links
	$('.add-to-map').live('click', function() {
		addToMap(this);
	});
	
	// fill in the advanced search select boxes
	marques.fillSelectBox('#adv_filter_state', '/marques/australian_states/items.json');
	marques.fillSelectBox('#search_filter_state', '/marques/australian_states/items.json');
	marques.fillSelectBox('.filter-locality', '/marques/locality_types/items.json');
	marques.fillSelectBox('.filter-cinema', '/marques/film_weekly_cinema_types/items.json');
	
	marques.fillSelectBox('.browse_state', '/marques/australian_states/itemsbyid.json', true, 'Select a state');
	
	$('#search_filter_state').change(function(event){
		filterSearchResults($(this).val());
	});
		
	// allow user to swap from advanced to basic search
	$('#search_swap').click(function(event) {
		$('#adv_search_dialog').dialog('close');
		$('#search_dialog').dialog('open');
	});
	
	// allow user to swap from advanced to search to browse
	$('#browse_swap').click(function(event) {
		$('#adv_search_dialog').dialog('close');
		$('#browse_dialog').dialog('open');
	});
	
	// filter the advanced search results
	$('#adv_filter_state').change(function (event) {
		filterAdvSearchResults();
	});
	
	$('#adv_filter_locality').change(function (event) {
		filterAdvSearchResults();
	});
	
	$('#adv_filter_cinema').change(function (event) {
		filterAdvSearchResults();
	});
	
	// initialise the browse select boxes
	marques.fillSelectBox('#browse_filter_locality', '/marques/locality_types/items.json', true, 'Select a locality type');
	marques.fillSelectBox('#browse_filter_cinema', '/marques/film_weekly_cinema_types/items.json');
	marques.fillSelectBox('#browse_filter_cinema_2', '/marques/film_weekly_cinema_types/items.json', true, 'Select a cinema type');

		
	$('#browse_state').change(function (event) {
	
		$('#browse_filter_cinema option:selected').attr('selected', false);
		$('#browse_filter_cinema option:first').attr('selected', 'selected');
		
		$('#browse_search_results').empty();
		$('#browse_result_count').empty();
		$('#browse_result_hidden').empty();
		
		$('.browse-suburb').each(function(index, element) {
			$(element).empty();
		});
			
		var state = $('#browse_state option:selected').val();
		
		if(state != 'default') {
			var url = '/marques/browse/suburbs/' + state + '.json';
			var optionA = '<option value="default">Select a Place Name</option>';
			var optionF = '<option value="default">Select a Place Name</option>';
			var optionK = '<option value="default">Select a Place Name</option>';
			var optionP = '<option value="default">Select a Place Name</option>';
			var optionU = '<option value="default">Select a Place Name</option>';
			
			var tmp
			
			$.get(url, function(data) {
				$.each(data.items, function(index, value) {
				
					tmp = value.description.toLowerCase();
					tmp = tmp.substr(0,1);
					
					if(tmp == 'a' || tmp == 'b' || tmp == 'c' || tmp == 'd' || tmp == 'e') {
						optionA += '<option value="' + value.id + '">' + value.description + '</option>';
					} else if (tmp == 'f' || tmp == 'g' || tmp == 'h' || tmp == 'i' || tmp == 'j') {
						optionF += '<option value="' + value.id + '">' + value.description + '</option>';
					} else if (tmp == 'k' || tmp == 'l' || tmp == 'm' || tmp == 'n' || tmp == 'o') {
						optionK += '<option value="' + value.id + '">' + value.description + '</option>';
					} else if (tmp == 'p' || tmp == 'q' || tmp == 'r' || tmp == 's' || tmp == 't') {
						optionP += '<option value="' + value.id + '">' + value.description + '</option>';
					} else {
						optionU += '<option value="' + value.id + '">' + value.description + '</option>';
					}
				
				});
				
				$('#browse_suburb_a').append(optionA);
				$('#browse_suburb_f').append(optionF);
				$('#browse_suburb_k').append(optionK);
				$('#browse_suburb_p').append(optionP);
				$('#browse_suburb_u').append(optionU);
			});
			
			// load all of the entire state
			$('#browse_select_all_suburbs').click();
		}
	});
	
	// populate the browse search results
	$('.browse-suburb').change(function (event) {
	
		$('#browse_filter_cinema option:selected').attr('selected', false);
		$('#browse_filter_cinema option:first').attr('selected', 'selected');
		
		var target = $(this);
		var targetid = target.attr('id');
		
		$('.browse-suburb').each(function(index, value){
		
			var otherid = $(value).attr('id');
		
			if(otherid != targetid) {
				$('#' + otherid + ' option:selected').attr('selected', false);
				$('#' + otherid + ' option:first').attr('selected', 'selected');
			}
		
		});
	
		var suburb = target.val();
		var state  = $('#browse_state').val();
		
		$.post(
			'/marques/searches/bysuburb.json',
			{
				suburb: suburb,
				state:  state
			},
			function(data, textStatus, jqXHR) {
				doSearchResults(data, '#browse_search_results');
				
				$('#browse_result_count').empty().append(data.results.length);
				$('#browse_result_hidden').empty().append('0');
			},
			'json'
		);
	});
	
	// filter the browse search results
	$('#browse_filter_cinema').change(function (event) {
	
		$('.fw-search-result').show();
	
		var criteria = $('#browse_filter_cinema').val();
		var count = 0;
		
		if(criteria != 'all') {
			$('.fw-search-result').filter(':visible').each(function(index, element) {
						
				var data = $(this).data('result');
				
				if(data.cinema_type != criteria) {
					$(this).hide();
					count++;
				}
			});
		}
		
		$('#browse_result_hidden').empty().append(count);	
	});
	
	// reset the browse filter locality select
	$('#browse_state_2').change(function (event) {
	
		// reset the browse filter
		$('#browse_filter_locality option:selected').attr('selected', false);
		$('#browse_filter_locality option:first').attr('selected', 'selected');
		
		// get rid of any results
		$('#browse_search_results_2').empty();
	});
	
	// populate the browse by locality search results
	$('#browse_filter_locality').change(function (event) {
	
		// determine which state is selected
		var state = $('#browse_state_2').val();
		
		if(state == 'default') {
			
			alert('Please select a state before continuing');
			
			// reset the browse filter
			$('#browse_filter_locality option:selected').attr('selected', false);
			$('#browse_filter_locality option:first').attr('selected', 'selected');
			
			// get rid of any results
			$('#browse_search_results_2').empty();
			
		} else {
		
			var locality = $('#browse_filter_locality').val();
			
			if(locality != 'default') {
		
				// get the data
				$.post(
					'/marques/searches/bylocality.json',
					{
						state: state,
						locality:  locality
					},
					function(data, textStatus, jqXHR) {
						doSearchResults(data, '#browse_search_results_2');
					},
					'json'
				);
			}
		}
	
	});
	
	// reset the browse filter locality select
	$('#browse_state_3').change(function (event) {
	
		// reset the browse filter
		$('#browse_filter_cinema_2 option:selected').attr('selected', false);
		$('#browse_filter_cinema_2 option:first').attr('selected', 'selected');
		
		// get rid of any results
		$('#browse_search_results_3').empty();
	});
	
	// populate the browse by locality search results
	$('#browse_filter_cinema_2').change(function (event) {
	
		// determine which state is selected
		var state = $('#browse_state_3').val();
		
		if(state == 'default') {
			
			alert('Please select a state before continuing');
			
			// reset the browse filter
			$('#browse_filter_cinema_2 option:selected').attr('selected', false);
			$('#browse_filter_cinema_2 option:first').attr('selected', 'selected');
			
			// get rid of any results
			$('#browse_search_results_3').empty();
						
		} else {
		
			var type = $('#browse_filter_cinema_2').val();
			
			if(type != 'default') {
		
				// get the data
				$.post(
					'/marques/searches/bycinematype.json',
					{
						state: state,
						type:  type
					},
					function(data, textStatus, jqXHR) {
						doSearchResults(data, '#browse_search_results_3');
					},
					'json'
				);
			}
		}
	
	});
	
	// initialise the browse select all suburbs button
	$('#browse_select_all_suburbs').button();
	
	$('#browse_select_all_suburbs').click(function(event) {
	
		// reset the suburb select boxes
		$('.browse-suburb').each(function(index, value){
		
			$('#' + $(value).attr('id') + ' option:selected').attr('selected', false);
			$('#' + $(value).attr('id') + ' option:first').attr('selected', 'selected');
		});
		
		// get the selected state
		var state = $('#browse_state option:selected').val();
		
		if(state != 'default') {
		
			// give user some feedback
			$('#browse_search_results').empty().append('<p class="search-progress"><img src="/assets/images/search-progress.gif" height="19" width="220" alt="Loading Data"/></p>');
		
			// get the data
			$.post(
				'/marques/searches/bystate.json',
				{
					state:  state
				},
				function(data, textStatus, jqXHR) {
					doSearchResults(data, '#browse_search_results');
					
					$('#browse_result_count').empty().append(data.results.length);
					$('#browse_result_hidden').empty().append('0');
				},
				'json'
			);
		}
	});
	
	// populate the jump lists
	$('.jump-list').change(function (event){
	
		if($(this).val() != 'default') {
			marques.panAndZoom(map, $(this).val());
			map.panBy(-400, 0);
		}
		
		var tmp = $('#jump_state')
		
		if($('#jump_state').get(0) === $(this).get(0)) {
			// reset the city list
			$('#jump_city option:selected').attr('selected', false);
			$('#jump_city option:first').attr('selected', 'selected');
		} else {
			// reset the state list
			$('#jump_state option:selected').attr('selected', false);
			$('#jump_state option:first').attr('selected', 'selected');
		}
	});
	
	$('.jump-list-link').click(function (event) {
	
		var coords = $(this).data('coords');
		marques.panAndZoom(map, coords);
		map.panBy(-425, 0);
		
		// reset the city list
		$('#jump_city option:selected').attr('selected', false);
		$('#jump_city option:first').attr('selected', 'selected');
		
		// reset the state list
		$('#jump_state option:selected').attr('selected', false);
		$('#jump_state option:first').attr('selected', 'selected');
		
	});
	
	// reset the map
	$('#btn_map_reset').click(function (event) {
	
		// check to see if the spiderfy plugin is being used
		if(useOverlappingMarkerSpiderfier == true) {
			oms.clearMarkers(); // remove all of the markers
		}
	
		marques.deleteMarker(map, mapData.markers);
		
		// empty the other arrays
		mapData.hashes  = new Array();
		mapData.data    = new Array();
		mapData.markers = new Array();
		
		

		//reset any other UI elements
		prepareMapControls(true);
	
	});
	
	// initialise the delete to map links
	$('.delete-from-map').live('click', function() {
		var marker = $(this).data('result');
		
		
		// check to see if the spiderfy plugin is being used
		if(useOverlappingMarkerSpiderfier == true) {
			oms.removeMarker(marker); // remove all of the markers
		}
		
		marques.deleteMarker(map, marker);
		
		var index = $(this).data('index');
		
		mapData.hashes.splice(index, 1);
		mapData.data.splice(index, 1);
		mapData.markers.splice(index, 1);
		
		prepareMapControls(true);
		
		mapUpdated = true;
	});
	
	// initialise the jump to marker links
	$('.jump-to-marker').live('click', function() {
		
		var index = $(this).data('index');
		
		var data = mapData.data[index];
		
		var coords = data.coords + ',18';
		
		marques.panAndZoom(map, coords);
		map.panBy(-425, 0);
	
	});
	
	// initialise the tabs
	$('#browse_tabs').tabs();
	
	// initialise the dialogs
	initDialogs();
	
	// setup a standard error dialog to show when an ajax error occures
	$('#ajax_error_dialog').ajaxError(function(event, jqXHR, ajaxSettings, thrownError){
		$('#ajax_error_msg').empty().append()
		$('#ajax_error_dialog').dialog('open');
		$('#ajax_error_dialog').dialog('moveToTop');
	});		
}

/**
 * initialise all of the dialogs
 */
function initDialogs() {

	// initalise all of the dialogs
	$('#search_dialog').dialog({
		autoOpen: false,
		height: 450,
		width: 700,
		modal: true,
		position: 'left',
		buttons: [
			{
				text: 'Reset Map',
				click: function() {
					$('#btn_map_reset').click();
					$('#search_message_box').hide();
					$('#search_result_count').empty();
					$('#search_result_hidden').empty();
					$('#search_results_box').empty();
					initSearchForms();
				}
			},
			{
				text: 'Add All',
				click: function() {
					$('.fw-add-to-map').filter(':visible').each(function(index, element) {
						$(this).click();
					});
				}
			},
			{	text: 'Help',
				click: function() {
					showHelp('search');
				}
			},			
			{
				text: 'Close',
				click: function() {
					$(this).dialog('close');
				}
			}
		],
		open: function() {
			$('#search_message_box').hide();
			$('#search_result_count').empty();
			$('#search_result_hidden').empty();
			initSearchForms();
			map.panBy(-350, 0);
		},
		close: function() {
			//tidy up the dialog when we close
			var form = $('#search_form').validate();
			form.resetForm();
			map.panBy(350, 0);
		}
	});
	
	$('#adv_search_dialog').dialog({
		autoOpen: false,
		height: 500,
		width: 800,
		modal: true,
		position: 'left',
		buttons: [
			{
				text: 'Reset Map',
				click: function() {
					$('#btn_map_reset').click();
					$('#adv_search_message_box').hide();
					$('#adv_result_count').empty();
					$('#adv_result_hidden').empty();
					resetAdvFilters();
					initSearchForms();
				}
			},
			{
				text: 'Add All',
				click: function() {
					$('.fw-add-to-map').filter(':visible').each(function(index, element) {
						$(this).click();
					});
				}
			},
			{	text: 'Help',
				click: function() {
					showHelp('adv_search');
				}
			},			
			{
				text: 'Close',
				click: function() {
					$(this).dialog('close');
				}
			}
		],
		open: function() {
			$("#adv_search_message_box").hide();
			$('#adv_result_count').empty();
			$('#adv_result_hidden').empty();
			resetAdvFilters();
			initSearchForms();
			map.panBy(-400, 0);
		},
		close: function() {
			//tidy up the dialog when we close
			var form = $('#adv_search_form').validate();
			form.resetForm();
			map.panBy(400, 0);
		}
	});
	
	$('#browse_dialog').dialog({
		autoOpen: false,
		height: 500,
		width: 800,
		modal: true,
		position: 'left',
		buttons: [
			{
				text: 'Reset Map',
				click: function() {
					$('#btn_map_reset').click();
					$('#browse_dialog').dialog('close');
					$('#browse_dialog').dialog('open');
				}
			},
			{
				text: 'Add All',
				click: function() {
					$('.fw-add-to-map').filter(':visible').each(function(index, element) {
						$(this).click();
					});
				}
			},
			{	text: 'Help',
				click: function() {
					showHelp('browse');
				}
			},			
			{
				text: 'Close',
				click: function() {
					$(this).dialog('close');
				}
			}
		],
		open: function() {
			// do this when the dialog opens
			$('#browse_result_count').empty();
			$('#browse_result_hidden').empty();
			
			$('.browse-select').each(function(){
			
				var select = $(this);
				
				$('#' + select.context.id + ' option:selected').attr('selected', false);
				$('#' + select.context.id + ' option:first').attr('selected', 'selected');

			});
			
			$('#browse_search_results').empty();
			$('#browse_search_results_2').empty();
			$('#browse_search_results_3').empty();
			
			$('#browse_tabs').tabs('select', 0);
			
			
			map.panBy(-400, 0);
		},
		close: function() {
			// do this when the dialog closes
			map.panBy(400, 0);
		}
	});
	
	$('#controls_dialog').dialog({
		autoOpen: false,
		height: 500,
		width: 850,
		modal: true,
		position: 'left',
		buttons: [
			{	text: 'Help',
				click: function() {
					showHelp('controls');
				}
			},			
			{
				text: 'Close',
				click: function() {
					$(this).dialog('close');
				}
			}
		],
		open: function() {
			// do this when the dialog opens
			map.panBy(-425, 0);
			prepareMapControls();
		},
		close: function() {
			// do this when the dialog closes
			map.panBy(425, 0);
		}
	});
	
	$('#ajax_error_dialog').dialog({
		autoOpen: false,
		height: 150,
		width: 600,
		modal: true,
		position: 'middle',
		buttons: [			
			{
				text: 'Close',
				click: function() {
					$(this).dialog('close');
				}
			}
		],
		open: function() {
			
		},
		close: function() {
			
		}
	});
	
	$('#welcome_dialog').dialog({
		autoOpen: false,
		height: 400,
		width: 600,
		modal: true,
		position: 'left',
		buttons: [			
			{
				text: 'Close',
				click: function() {
					$(this).dialog('close');
				}
			}
		],
		open: function() {
			// do this when the dialog opens
			map.panBy(-300, 0);
		},
		close: function() {
			// do this when the dialog closes
			map.panBy(300, 0);
		}
	});
	
	$('#time_slider_dialog').dialog({
		autoOpen: false,
		height: 250,
		width: 700,
		modal: false,
		position: 'bottom',
		buttons: [
			{
				text: 'Animate',
				click: function() {
					startTimeAnimation();
				}
			},
			{	text: 'Help',
				click: function() {
					showHelp('time_slider');
				}
			},			
			{
				text: 'Close',
				click: function() {
					$(this).dialog('close');
				}
			}
		],
		open: function() {
			$('#time_slider').slider({
				min: 0,
				max: filmWeeklyCategories.length -1,
				change: function(event, ui) {
					$('#slider_label_top_right').empty().append(filmWeeklyCategories[ui.value].description);
					updateMapTimePeriod(ui.value);
				},
				slide: function(event, ui) {
					$('#slider_label_top_right').empty().append(filmWeeklyCategories[ui.value].description);
				}
			});
			
			// reset the time slider and map if it has been updated
			// by having markers added or removed
			
			if(mapUpdated == true) {
			
				// reset the time slider
				$('#time_slider').slider('value', 0);
				
				// reset the labels
				$('#slider_label_top_right').empty().append(filmWeeklyCategories[0].description);
				$('#slider_label_left').empty().append(filmWeeklyCategories[0].description);
				$('#slider_label_right').empty().append(filmWeeklyCategories[filmWeeklyCategories.length -1 ].description);
				
				// update the map
				updateMapTimePeriod(0);
			}
		},
		close: function() {
		
			stopTimeAnimation();
			
		}
	});
	
	$('#film_weekly_dialog').dialog({
		autoOpen: false,
		height: 400,
		width: 600,
		modal: true,
		position: 'left',
		buttons: [			
			{
				text: 'Close',
				click: function() {
					$(this).dialog('close');
				}
			}
		],
		open: function() {
			// do this when the dialog opens
			map.panBy(-300, 0);
		},
		close: function() {
			// do this when the dialog closes
			map.panBy(300, 0);
		}
	});
	
	$('#about_dialog').dialog({
		autoOpen: false,
		height: 400,
		width: 600,
		modal: true,
		position: 'left',
		buttons: [			
			{
				text: 'Close',
				click: function() {
					$(this).dialog('close');
				}
			}
		],
		open: function() {
			// do this when the dialog opens
			map.panBy(-300, 0);
		},
		close: function() {
			// do this when the dialog closes
			map.panBy(300, 0);
		}
	});
	
	$('#help_dialog').dialog({
		autoOpen: false,
		height: 400,
		width: 600,
		modal: false,
		position: 'right',
		buttons: [			
			{
				text: 'Close',
				click: function() {
					$(this).dialog('close');
				}
			}
		],
		open: function() {
			// do this when the dialog opens
			//map.panBy(-300, 0);
		},
		close: function() {
			// do this when the dialog closes
			//map.panBy(300, 0);
		}
	});
	
	$('#legend_dialog').dialog({
		autoOpen: false,
		height: 400,
		width: 600,
		modal: false,
		position: 'right',
		buttons: [			
			{
				text: 'Close',
				click: function() {
					$(this).dialog('close');
				}
			}
		],
		open: function() {
			// do this when the dialog opens
			//map.panBy(-300, 0);
		},
		close: function() {
			// do this when the dialog closes
			//map.panBy(300, 0);
		}
	});
	
	$('#contribute_dialog').dialog({
		autoOpen: false,
		height: 400,
		width: 600,
		modal: true,
		position: 'left',
		buttons: [			
			{
				text: 'Close',
				click: function() {
					$(this).dialog('close');
				}
			}
		],
		open: function() {
			// do this when the dialog opens
			map.panBy(-300, 0);
		},
		close: function() {
			// do this when the dialog closes
			map.panBy(300, 0);
		}
	});

}

// functions for animating the time slider
function startTimeAnimation() {

	// reset the time slider
	$('#time_slider').slider('value', 0);
	
	// update the map
	updateMapTimePeriod(0);
	
	// update the time marker
	currentTimeInterval = 1;
	
	// set a timeout for the continue time animation
	nextTimeout = setTimeout('continueTimeAnimation()', 3000);
	
	// update the message
	$('#animation_message').empty().append('Animation running…');

}

function continueTimeAnimation() {

	if(currentTimeInterval < filmWeeklyCategories.length) {

		// reset the time slider
		$('#time_slider').slider('value', currentTimeInterval);
		
		// update the map
		updateMapTimePeriod(currentTimeInterval);
		
		// update the time marker
		currentTimeInterval++;
		
		// set a timeout for the continue time animation
		nextTimeout = setTimeout('continueTimeAnimation()', 3000);	
	} else {
		// update the message
		$('#animation_message').empty();
	}

}

function stopTimeAnimation() {

	if(nextTimeout != null) {

		clearTimeout(nextTimeout);
		
		nextTimeout = null;
		
		// update the message
		$('#animation_message').empty();
	}
}

// function to show the help dialog and scroll to the appropriate heading
function showHelp(heading) {
	// open the dialog
	$('#help_dialog').dialog('open');
	$('#help_dialog_text').parent().scrollTo($('#help_' + heading), {duration:1000});
}

// update the contents of the map based on the selected time period
function updateMapTimePeriod(category){

	// adjust the index from the array index
	// to the id value in the table
	category++;

	// take everything off the map
    marques.deleteMarker(map, mapData.markers);
    
    // add back only those that fall within the defined period
    $.each(mapData.data, function(index, value){
    
        if(category >= value.min_film_weekly_cat && category <= value.max_film_weekly_cat) {
               mapData.markers[index].setMap(map);
        }
        
    });
}

// prepare the UI elements in the controls dialog
function prepareMapControls(refresh) {

	if(typeof(refresh) == 'undefined') {
		$('.jump-list').each(function(index, element){
			$(element).empty();
		});
		
		var list = '<option value="default">Select a State</option>';
		
		$(marques.stateJumpList()).each(function(index, value) {
			list += '<option value="' + value.value + '">' + value.id + '</option>';
		});
		
		$('#jump_state').append(list);
		
		list = '<option value="default">Select a City</option>';
		
		$(marques.cityJumpList()).each(function(index, value) {
			list += '<option value="' + value.value + '">' + value.id + '</option>';
		});
		
		$('#jump_city').append(list);
		
		var jumpList = marques.countryJumpList();
		
		// assumes australia will always be first element in the list
		$('#jump_country').append(jumpList[0].id);
		$('#jump_country').data('coords', jumpList[0].value);
	}
	
	// build the marker list
	var para;
	var entry;
	var span;
	var results = $('#controls_marker_list');
	results.empty();
	
	if(mapData.markers.length > 0) {
	
		// loop through all of the items
		$.each(mapData.data, function(index, value) {
		
			entry = '<p class="fw-search-result fw-search-result-' + value.state + '">' + value.result + ' </p>';
		
			para = $(entry);
			
			span = '<span class="fw-add-to-map"></span>';
			
			span = $(span);
			
			entry = '<span id="' + value.type + "-" + value.id + '" class="jump-to-marker fw-clickable">Jump to Marker</span> &nbsp;';
			
			entry = $(entry);
			
			entry.data('index', index);
			
			span.append(entry);

			entry = '<span id="' + value.type + "-" + value.id + '" class="delete-from-map fw-clickable">Delete from Map</span>';
			
			entry = $(entry);
			
			entry.data('result', mapData.markers[index]);
			entry.data('index', index);
			//para.data('result', value);
			
			span.append(entry);
			
			para.append(span);
			
			results.append(para);
		
		});
			
	} else {
		results.append('<p class="no-search-results">No Markers are on the Map</p>');
	}
}

function initSearchForms() {

	$('#search_form').validate({
		rules: {
			search: 'required'
		},
		messages: {
			search: 'Search terms are required'
		},
		errorContainer: '#search_message_box',
		errorLabelContainer: '#search_message',
		submitHandler: function(form) {
			$(form).ajaxSubmit({
				dataType:  'json',
				beforeSubmit: function() {
					$('#search_results_box').empty().append('<p class="search-progress"><img src="/assets/images/search-progress.gif" height="19" width="220" alt="Search Underway"/></p>');
				},
				success: doBasicSearch,
				error: function (jqXHR, textStatus, errorThrown) {
					$('#search_results_box').empty().append('<div class="ui-state-error ui-corner-all search-message-box"><p><span class="ui-icon ui-icon-alert status-icon"></span>An error occurred during the search, please try again later</p></div>');

				}
			});
		}
	});
	
	$('#adv_search_form').validate({
		rules: {
			search: 'required'
		},
		messages: {
			search: 'Search terms are required. <br/>Have you considered trying to Browse instead?'
		},
		errorContainer: '#adv_search_message_box',
		errorLabelContainer: '#adv_search_message',
		submitHandler: function(form) {
			$(form).ajaxSubmit({
				dataType:  'json',
				beforeSubmit: function() {
					$('#adv_search_results_box').empty().append('<p class="search-progress"><img src="/assets/images/search-progress.gif" height="19" width="220" alt="Search Underway"/></p>');
					resetAdvFilters();
				},
				success: doAdvancedSearch,
				error: function (jqXHR, textStatus, errorThrown) {
					$('#adv_search_results_box').empty().append('<div class="ui-state-error ui-corner-all search-message-box"><p><span class="ui-icon ui-icon-alert status-icon"></span>An error occurred during the search, please try again later</p></div>');

				}
			});
		}
	});
	
	$('#search_results_box').empty();
	$('#adv_search_results_box').empty();
}

function doBasicSearch(data) {
	doSearchResults(data, '#search_results_box');
	
	$('#search_result_count').empty().append(data.results.length);
	$('#search_result_hidden').empty();
}

function doAdvancedSearch(data) {
	doSearchResults(data, '#adv_search_results_box'); 
	
	$('#adv_result_count').empty().append(data.results.length);
	$('#adv_result_hidden').empty();
}

// function to undertake a search
function doSearchResults(data, elem) {
	
	// store a reference to the search results node so we
	// don't keep looking it up
	var results = $(elem);
	
	// variables to store the data
	var id;
	var cinema;
	var exhibitor;
	var address;
	var entry = '';
	var para;

	// empty any existing search results
	results.empty();
	
	if(data.results.length > 0) {
	
		// loop through all of the items
		$.each(data.results, function(index, value) {
		
			entry = '<p class="fw-search-result fw-search-result-' + value.state + '">' + value.result + ' </p>';
		
			para = $(entry);
			
			if($.inArray(marques.computeLatLngHash(value.coords), mapData.hashes) > -1) {
				entry = '<span class="fw-add-to-map">Added</span>';
			} else {
				entry = '<span id="' + value.type + "-" + value.id + '" class="fw-add-to-map add-to-map fw-clickable">Add to Map</span>';
			}
			
			entry = $(entry);
			
			entry.data('result', value);
			para.data('result', value);
			
			para.append(entry);
			
			results.append(para);
		
		});
			
	} else {
		results.append('<p class="no-search-results">No Search Results Found</p>');
	}

}

// function to filter the search results
function filterSearchResults(state) {
		
	var count = 0;
	
	if(state != 'All') {
		// fade out the selected search results
		$('.fw-search-result-' + state).show();
		$('.fw-search-result').not('.fw-search-result-' + state).each(function(index, element) {
			$(element).hide();
			count++;
		});
		
	} else {
		// show all of the search results
		$('.fw-search-result').show();
	}
	
	$('#search_result_hidden').empty().append(count);
}

// function to reset the advance filter select boxes
function resetAdvFilters() {

	$('#adv_filter_state option:selected').attr('selected', false);
	$('#adv_filter_state option:first').attr('selected', 'selected');
	
	$('#adv_filter_locality option:selected').attr('selected', false);
	$('#adv_filter_locality option:first').attr('selected', 'selected');
	
	$('#adv_filter_cinema option:selected').attr('selected', false);
	$('#adv_filter_cinema option:first').attr('selected', 'selected');
	
	$('#adv_result_count').empty();
	$('#adv_result_hidden').empty();

}

// function to filter the advanced search results
function filterAdvSearchResults() {

	var count = 0;

	// show all of the search results
	$('.fw-search-result').show();
	
	// filter by state
	var criteria = $('#adv_filter_state').val();
	
	// filter the search results by state
	if(criteria != 'All') {
		// fade out the selected search results
		$('.fw-search-result-' + criteria).show();
		$('.fw-search-result').not('.fw-search-result-' + criteria).each(function(index, element) {
			count++;
			$(this).hide();
		});
		
	}

	// filter by locality type
	// work on those that aren't already hidden
	criteria = $('#adv_filter_locality').val();
	
	if(criteria != 'all') {
	
		$('.fw-search-result').filter(':visible').each(function(index, element) {
			
			var data = $(this).data('result');
			
			if(data.locality_type != criteria) {
				count++;
				$(this).hide();
			}
		});
	}
		
	// filter by cinema type
	// get all of those that aren't already hidden
	criteria = $('#adv_filter_cinema').val();
	if(criteria != 'all') {
		$('.fw-search-result').filter(':visible').each(function(index, element) {
					
			var data = $(this).data('result');
			
			if(data.cinema_type != criteria) {
				count++;
				$(this).hide();
			}
		});
	}
	
	$('#adv_result_hidden').empty().append(count);
}

// function to add an item to the map
function addToMap(item) {

	var data = $(item).data('result');
	
	var coords = data.coords.split(',');
	
	var latlng = new google.maps.LatLng(coords[0], coords[1]);
	var marker = new google.maps.Marker({
		position: latlng,
		map: map,
		title: data.title,
		icon: data.icon
	});
	
	marker.data = data;
	
	if(useOverlappingMarkerSpiderfier != true) {
	
		// add a click event to the marker
		google.maps.event.addListener(marker, 'click', function() {
			
			// close any existing open infoWindow
			if(infoWindow != null) {
				infoWindow.close();
			}
			
			// create a new infoWindow
			infoWindow = new google.maps.InfoWindow({
	        	content: '<div class="info-window info-window-' + marques.computeLatLngHash(data.coords) + '"><p class="search-progress">Loading Cinema Data.</p><p class="search-progress"><img src="/assets/images/search-progress.gif" height="19" width="220" alt="Search Underway"/></p></div>'
	    	});
	    	
	    	// open the new infoWindow
	    	infoWindow.open(map, marker);
	    	
	    	// add a dom ready event to dynamically load the infoWindow content
			google.maps.event.addListener(infoWindow, 'domready', function() {
			
				// get reference to the infoWindow
				var infoWindow = this;
				
				// get reference to the container div
				var infoWindowContent = $('.info-window');
				
				// get a list of classes
				var classes = infoWindowContent.attr('class').split(' ');
				
				// find the right class for the hash
				var hash = classes[1].split('-');
				
				if(hash.length == 3) {
					hash = hash[2];
				} else {
					hash = classes[0].split('-');
					hash = hash[2];
				}
				
				// get the data object
				var data = mapData.data[$.inArray(hash, mapData.hashes)];
				
				var url = '/marques/film_weekly_info_windows/content/' + data.id;
				
				$.get(url, function(data){
				
					infoWindow.close();
					infoWindow = new google.maps.InfoWindow({
						content: data
					});
					infoWindow.open(map, marker);
				});
			});
			
		});
		
	} else {
	
		oms.addListener('click', function(marker) {
		
			// close any existing open infoWindow
			if(infoWindow != null) {
				infoWindow.close();
			}
			
			// create a new infoWindow
			infoWindow = new google.maps.InfoWindow({
	        	content: '<div class="info-window info-window-' + marques.computeLatLngHash(marker.data.coords) + '"><p class="search-progress">Loading Cinema Data.</p><p class="search-progress"><img src="/assets/images/search-progress.gif" height="19" width="220" alt="Search Underway"/></p></div>'
	    	});
	    	
	    	// open the new infoWindow
	    	infoWindow.open(map, marker);
	    	
	    	// add a dom ready event to dynamically load the infoWindow content
			google.maps.event.addListener(infoWindow, 'domready', function() {
			
				// get reference to the infoWindow
				var infoWindow = this;
				
				// get reference to the container div
				var infoWindowContent = $('.info-window');
				
				// get a list of classes
				var classes = infoWindowContent.attr('class').split(' ');
				
				// find the right class for the hash
				var hash = classes[1].split('-');
				
				if(hash.length == 3) {
					hash = hash[2];
				} else {
					hash = classes[0].split('-');
					hash = hash[2];
				}
				
				// get the data object
				var data = mapData.data[$.inArray(hash, mapData.hashes)];
				
				var url = '/marques/film_weekly_info_windows/content/' + data.id;
				
				$.get(url, function(data){
				
					infoWindow.close();
					infoWindow = new google.maps.InfoWindow({
						content: data
					});
					infoWindow.open(map, marker);
				});
			});
		});
		
		// add the marker so it is tracked by the OMS plugin
		oms.addMarker(marker);
	}

	// add to the list of what is on the map
	mapData.hashes.push(marques.computeLatLngHash(data.coords));
	mapData.data.push(data);
	mapData.markers.push(marker);
	
	$(item).empty().append('Added');
	$(item).removeClass('fw-clickable add-to-map');
	
	mapUpdated = true;

}

//dynamically resize the map
function resizeMap() {

	var mid  = $('#map_container');
	var foot = $('#footer');
	
	var midPosition  = mid.position();
	var footPosition = foot.position();
	
	
	var newHeight = footPosition.top - midPosition.top;
	
	mid.height(newHeight);

	/*

	// calculate new size and apply it
	var mid = document.getElementById('map_container');
	var foot = document.getElementById('footer');
	
	//mid.style.height = ((foot.offsetTop + foot.clientHeight - footerHeightAdjust) - (mid.offsetTop))+'px';
	mid.style.height = ((foot.offsetTop) - (mid.offsetTop))+'px';
	
	*/
	
	// trigger a resize event on the map so it reflects the new size
	if(map != null) {
		google.maps.event.trigger(map, 'resize');
	}
}