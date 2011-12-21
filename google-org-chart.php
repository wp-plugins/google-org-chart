<?php
/*
Plugin Name: Google Org Chart
Description: Shortcode plugin for simpler generation of org charts using Google's org chart API.
Version: 1.0.1
Author: Aleksandar Arsovski
License: GPL2
*/

/*  Copyright 2011  Aleksandar Arsovski  (email : alek_ars@hotmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// Set up the initial variables
$goc_nodes = array();


// Register a new shortcode [goc]
add_shortcode( 'org_chart', 'google_org_chart_shortcode' );


// Register a new shortcode [goc_item]
add_shortcode( 'org_chart_item', 'google_org_chart_item_shortcode' );


// Google Org Chart callback
function google_org_chart_shortcode( $attr, $content ) {
	
	// Globalize the org chart nodes array
	global $goc_nodes;
	
	
	// Attributes: default width and height are 300px
	extract( shortcode_atts( array(
		'width' => '300',
		'height' => '300',
	), $attr ) );
	
	
	// Entering collapsible as a no-value attribute will set the each parent node in the org chart as collapsible
	if( in_array( "collapsible", $attr ) )
		$collapsible = 'true';
	else
		$collapsible = 'false';
	
	
	// Starting off the return string with the set up needed before nodes are introduces
	$return_string = "
	<script type='text/javascript' src='http://www.google.com/jsapi'></script>
	<script type='text/javascript'>
    		google.load('visualization', '1', {packages: ['orgchart']});
    	</script>
    	<script type='text/javascript'>
    		function drawVisualization() {
        		// Create and populate the data table.
        		var data = new google.visualization.DataTable();
        		data.addColumn('string', 'Title');
				data.addColumn('string', 'Parent');
        		data.addColumn('string', 'HoverOver');
        		";
    
    
    // Execute all the individual node shortcodes contained within the org chart shortcode block
	do_shortcode( $content );
	
	
	// Get the total number of nodes
	$chart_node_count = count( $goc_nodes );
	
	
	// Add the number of nodes to the return screen for further set up purposes
	$return_string .= "data.addRows(" . $chart_node_count . ");";
	
	
	// Set up the all the nodes and their attributes
	foreach( $goc_nodes as $node_id => $attributes ) {
		
		$title = $attributes[ 'title' ];
		$content = $attributes[ 'content' ];
		$parent = $attributes[ 'parent' ];
		$hover = $attributes[ 'hover' ];
		
		// Set up the title and the content attributes of each node
		// If title and content are both provided, title acts more as an ID
		// Otherwise the title acts as the ID and content
		if ( isset( $title ) ) {
			if ( isset( $content ) )
				$return_string .= "data.setCell(".$node_id.", 0, '".$title."', '".$content."');
				";
			else
    			$return_string .= "data.setCell(".$node_id.", 0, '".$title."');
    			";
    	}
    	
    	// Set up the nodes parent if it has one otherwise leave the node at top level
    	if ( isset( $parent ) )
    		$return_string .= "data.setCell(".$node_id.", 1, '".$parent."');
    		";
    	
    	// Set up the information displayed upon hovering over the node
    	if ( isset( $hover ) )
    		$return_string .= "data.setCell(".$node_id.", 2, '".$hover."');
    		";
    }
    
    
    // Finish off the return string with the collpsible, width, and height settings
	$return_string .= '
		// Create and draw the visualization.
        	new google.visualization.OrgChart(document.getElementById("visualization")).
            	draw(data, {allowHtml: true, allowCollapse: '.$collapsible.'});
      		}

		google.setOnLoadCallback(drawVisualization);
    	</script>
    	
    	<div id="visualization" style="width: '.$width.'px; height: '.$height.'px;"></div>';
 
 	return $return_string;
}


// Google Org Chart Node callback
function google_org_chart_item_shortcode( $attr ) {
	
	global $goc_nodes;
	
	// Add the node's attributes to the node array
	$goc_nodes[] = array(
						'title' => isset( $attr['title'] ) ? $attr['title'] : NULL,
						'content' => isset( $attr['content'] ) ? $attr['content'] : NULL,
						'parent' => isset( $attr['parent'] ) ? $attr['parent'] : NULL,
						'hover' => isset( $attr['hover'] ) ? $attr['hover'] : NULL
					);
					
}