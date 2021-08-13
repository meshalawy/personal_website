<!DOCTYPE html>
<!-- 
/**
 * Mapping the Movies
 *
 * @copyright     Copyright 2011, Flinders Institute for Research in the Humanities - Flinders University (http://www.flinders.edu.au)
 * @license       All Rights Reserved
 */ 
-->
<html lang="en">
<head>
	<!-- Enable IE9 Standards mode -->
	<meta http-equiv="X-UA-Compatible" content="IE=9" >
	<meta charset="utf-8"/>
	<title>Australian Cinemas Map</title>
	<link rel="stylesheet" type="text/css" href="assets/main-style.css"/>
	<link rel="stylesheet" type="text/css" href="assets/jquery-ui.css"/>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="assets/javascript/libraries/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="assets/javascript/libraries/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript" src="assets/javascript/libraries/jquery-validate-1.8.1.min.js"></script>
	<script type="text/javascript" src="assets/javascript/libraries/jquery-form-2.85.js"></script>
	<script type="text/javascript" src="assets/javascript/libraries/jquery.scrollTo-1.4.2.min.js"></script>
	<script type="text/javascript" src="assets/javascript/libraries/oms.min.js"></script>
	<script type="text/javascript" src="assets/javascript/main.js"></script>
	<!-- enable the use of these tags in IE8 and below -->
	<!--[if lt IE 9]>
	<script>
		document.createElement('header');
		document.createElement('nav');
		document.createElement('footer');
		document.createElement('hgroup');
	</script>
	<![endif]-->
	<!-- use the MARQues script -->
	<script type="text/javascript" src="/marques/js/marques-map-helper.js"></script>
</head>
<body>
	<header>
		<hgroup>
			<span class="fw-flinders-logo"><a href="http://www.flinders.edu.au" title="Flinders University"><img src="/assets/images/flinders-logo.png" height="65" width="140"/></a></span>
			<h1>Australian Cinemas Map</h1>
			<h2>A map of Film Weekly Motion Picture Directory cinema data, 1948 - 1971</h2>
		</hgroup>
	</header>
	<nav>
		<p>
			<button id="btn_browse" class="fw-button ui-state-default ui-corner-all">Browse</button>
			<button id="btn_search" class="fw-button ui-state-default ui-corner-all">Search</button>
			<button id="btn_adv_search" class="fw-button ui-state-default ui-corner-all">Adv. Search</button>
			<button id="btn_controls" class="fw-button ui-state-default ui-corner-all">Controls</button>
			<button id="btn_time_slider" class="fw-button ui-state-default ui-corner-all">Time Slider</button>
			<button id="btn_film_weekly" class="fw-button ui-state-default ui-corner-all">Film Weekly</button>
			<button id="btn_about" class="fw-button ui-state-default ui-corner-all">About</button>
			<button id="btn_help" class="fw-button ui-state-default ui-corner-all">Help</button>
			<button id="btn_legend" class="fw-button ui-state-default ui-corner-all">Legend</button>
			<button id="btn_contribute" class="fw-button ui-state-default ui-corner-all">Contribute</button>
		</p>
	</nav>
	<div id="map_container">
		<div id="map">
		</div>
	</div>
	<footer id="footer">
		<p class="left"> &#169; 2011 <a href="http://www.flinders.edu.au/ehl/firth/" title="More information about the institute">Flinders Institute for Research in the Humanities</a></p>
		<p class="right">Powered by <a href="http://code.google.com/p/marques-project/" title="More information about MARQues">MARQues</a></p>
	</footer>
	<!-- dialogs go here -->
	<div id="welcome_dialog" class="fw-dialog js" title="Welcome to the Australian Cinemas Map">
		<div id="welcome_dialog_text" class="fw-welcome-message">
		</div>
	</div>
	<div id="search_dialog" class="fw-dialog js" title="Search Film Weekly Data">
		<p class="dialog-help">
			Enter address, cinema name or exhibitor name below. Filter the search results by state if required.
		</p>
		<form id="search_form" method="post" action="marques/searches.json">
			<input name="search" size="50" type="search">
			<input type="submit" value="Search" class="fw-button ui-state-default ui-corner-all">
		</form>
		<div id="search_message_box" class="ui-state-error ui-corner-all search-message-box">
			<p>
				<span class="ui-icon ui-icon-alert status-icon"></span><span id="search_message" class="search-message"></span>
			</p>
		</div>
		<h1>Search Results</h1>
		<div class="dialog-menu">
			<p>
				<label for="search_filter_state">Filter Results by State: </label>
				<select id="search_filter_state"></select>
			</p>
			<p style="padding-top: 0.5em;">Total Number of Search Results: <span id="search_result_count"></span> Filtered: <span id="search_result_hidden"></span></p>
		</div>
		<div class="clear"></div>
		<div id="search_results_box">
		</div>
	</div>
	<div id="adv_search_dialog" class="fw-dialog js" title="Advanced Search Film Weekly Data">
		<div style="float: left">
			<p class="dialog-help">
				Enter address, cinema name or exhibitor name below. 
				<br/>Filter the search results using filters to the right if required.
			</p>
			<form id="adv_search_form" method="post" action="marques/searches/advanced.json">
				<input name="search" size="50" type="search">
				<input type="submit" value="Search" class="fw-button ui-state-default ui-corner-all">
			</form>
			<div id="adv_search_message_box" class="ui-state-error ui-corner-all search-message-box">
				<p>
					<span class="ui-icon ui-icon-alert status-icon"></span><span id="adv_search_message" class="search-message"></span>
				</p>
			</div>
			<p class="dialog-help-2">
				You may wish to use the <span id="browse_swap" class="clickable">browse functionality instead</span>.
				<br/>When doing an advanced search you can use <a href="http://dev.mysql.com/doc/refman/5.1/en/fulltext-boolean.html" title="MySQL Documentation on available operators" class="external" target="_blank">boolean and other search operators</a>. 
				<br/>Use may wish to use the <span id="search_swap" class="clickable">standard search instead</span> for simpler queries. 
			</p>
		</div>
		<div style="float: right">
			<table class="adv-filter-menu">
				<tr>
					<td colspan="2">
						Filter Search Results by:
					</td>
				</tr>
				<tr>
					<td>
						<label for="adv_filter_state">State: </label>
					</td>
					<td>
						<select id="adv_filter_state" style="width: 100%">
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="adv_filter_locality">Locality Type: </label>
					</td>
					<td>
						<select id="adv_filter_locality" class="filter-locality">
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="adv_filter_cinema">Cinema Type: </label>
					</td>
					<td>
						<select id="adv_filter_cinema" class="filter-cinema">
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						Search Results: <span id="adv_result_count"></span> Filtered: <span id="adv_result_hidden"></span>
					</td>
				</tr>
			</table>
		</div>
		<div class="clear"></div>
		<h1>Search Results</h1>
		<div id="adv_search_results_box">
		</div>
	</div>
	<div id="browse_dialog" class="fw-dialog js" title="Browse Film Weekly Data">
		<div id="browse_tabs">
			<ul class="fw-ui-tab-container">
				<li class="fw-ui-tab"><a href="#browse_tabs_1">Browse by State</a></li>
				<li class="fw-ui-tab"><a href="#browse_tabs_2">Browse by Locality Type</a></li>
				<li class="fw-ui-tab"><a href="#browse_tabs_3">Browse by Cinema Type</a></li>
			</ul>
			<div id="browse_tabs_1" class="fw-browse-tabs">
				<h1>Select a State</h1>
				<select id="browse_state" class="browse_state browse-select"></select>
				<h1>Select a Place Name</h1>
				<div>
					<button id="browse_select_all_suburbs">Select all place names</button> or select a single place name below.
				</div>
				<table class="fw-dialog-table">
					<thead>
						<tr>
							<th>A - E</th>
							<th>F - J</th>
							<th>K - O</th>
							<th>P - T</th>
							<th>U - Z</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><select id="browse_suburb_a" class="browse-suburb browse-select"></select></td>
							<td><select id="browse_suburb_f" class="browse-suburb browse-select"></select></td>
							<td><select id="browse_suburb_k" class="browse-suburb browse-select"></select></td>
							<td><select id="browse_suburb_p" class="browse-suburb browse-select"></select></td>
							<td><select id="browse_suburb_u" class="browse-suburb browse-select"></select></td>
						</tr>
					</tbody>
				</table>
				<h1>Filter by Cinema Type</h1>
				<select id="browse_filter_cinema" class="browse-filter-cinema  browse-select"></select> Records: <span id="browse_result_count"></span> Filtered: <span id="browse_result_hidden"></span>
				<h1>Record List</h1>
				<div id="browse_search_results">
				</div>
			</div>
			<div id="browse_tabs_2">
				<h1>Select a State</h1>
				<select id="browse_state_2" class="browse_state  browse-select"></select>
				<h1>Select a Locality Type</h1>
				<select id="browse_filter_locality" class="filter-locality  browse-select"></select>
				<h1>Record List</h1>
				<div id="browse_search_results_2">
				</div>
			</div>
			<div id="browse_tabs_3">
				<h1>Select a State</h1>
				<select id="browse_state_3" class="browse_state  browse-select"></select>
				<h1>Select a Cinema Type</h1>
				<select id="browse_filter_cinema_2" class="browse-filter-cinema  browse-select"></select>
				<h1>Record List</h1>
				<div id="browse_search_results_3">
				</div>
			</div>
		</div>
	</div>
	<div id="controls_dialog" class="fw-dialog js" title="Map Controls">
		<h1>Jump To</h1>
		<table class="fw-dialog-table">
			<thead>
				<tr>
					<th>Country</th>
					<th>State</th>
					<th>Capital City</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><span id="jump_country" class="jump-list jump-list-link clickable"></span></td>
					<td><select id="jump_state" class="jump-list"></select></td>
					<td><select id="jump_city" class="jump-list"></select></td>
				</tr>
			</tbody>
		</table>
		<h1>Reset Map</h1>
		<p>
			Delete all markers from the map. <button id="btn_map_reset" class="fw-button ui-state-default ui-corner-all">Reset Map</button>
		</p>
		<h1>Marker List</h1>
		<div id="controls_marker_list">
		</div>
	</div>
	<div id="time_slider_dialog" class="fw-dialog js" title="Time Slider">
		<h1>Select Time Period</h1>
		<p>Use the slider below to select a time period, any cinemas with film weekly listings outside the selected time period will be hidden.</p>
		<div style="padding-top: 0.5em;">
			<table style="width: 100%">
				<tr>
					<td colspan="3">
						Selected Film Weekly year: <span id="slider_label_top_right"></span>
					</td>
				</tr>
				<tr>
					<td style="width: 5em; text-align: left">
						<span id="slider_label_left"></span>
					</td>
					<td>
						<div id="time_slider"></div>
					</td>
					<td style="width: 5em; text-align: right">
						<span id="slider_label_right"></span>
					</td>
				</tr>
				<tr>
					<td colspan="3" id="animation_message">
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div id="ajax_error_dialog" class="fw-dialog js" title="Error">
		<div class="ui-state-error ui-corner-all search-message-box">
			<p>
				<span class="ui-icon ui-icon-alert status-icon"></span><span class="search-message">An error has occurred while processing your request, please try again later.<br/>If the problem persists please contact the site administrator.</span>
			</p>
		</div>
	</div>
	<div id="film_weekly_dialog" class="fw-dialog js" title="About the Film Weekly Periodical">
		<div id="film_weekly_dialog_text" class="fw-film-weekly-text">
		</div>
	</div>
	<div id="about_dialog" class="fw-dialog js" title="About the Australian Cinema Map Website">
		<div id="about_dialog_text" class="fw-about-text">
		</div>
	</div>
	<div id="help_dialog" class="fw-dialog js" title="Help Using the Australian Cinema Map Website">
		<div id="help_dialog_text" class="fw-about-text">
		</div>
	</div>
	<div id="legend_dialog" class="fw-dialog js" title="Australian Cinema Map Legend">
		<div id="legend_dialog_text" class="fw-legend-text">
		</div>
	</div>
	<div id="contribute_dialog" class="fw-dialog js" title="Contribute to the Australian Cinema Map">
		<div id="contribute_dialog_text" class="fw-contribute-text">
		</div>
	</div>
</body>
</html>