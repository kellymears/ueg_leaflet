<?php

/*
	Plugin Name: WP Leaflet
	Plugin URI: http://endgenocide.org/code
	Description: Leaflet Maps and Geodata for United to End Genocide.
	Version: 0.1
	Author: Kelly Mears
	Author URI: http://kellymears.me
	License: GPL2
*/

/*
	 Copyright 2012 United To End Genocide (email : info@endgenocide.org)

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

if (!class_exists("ueg_leaflet")) {
	
	class ueg_leaflet {
		
		var $admin_options_name = "ueg_leaflet_admin_options";
		var $admin_options;
                		
		function __construct() {
		
			$this->admin_options = $this->get_admin_options();

		}
		
		function install() {
			global $wpdb;
			$ver = "1.0";
			
			$geo_table = $wpdb->base_prefix . "leaflet_congressional_districts";
			$geo_sql = "CREATE TABLE $geo_table (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			state tinytext NOT NULL,
			district tinytext NOT NULL,
			marker text NOT NULL,
			geometry text NOT NULL,
			geometry_vertex_count text NOT NULL,
			UNIQUE KEY id (id) 
			);";
			
			$congress_bio_table = $wpdb->base_prefix . "leaflet_congressional_bios";
			$congress_bio_sql = "CREATE TABLE $congress_bio_table (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			geo_id INT NOT NULL,
			first_name text NOT NULL,
			last_name text NOT NULL,
			party tinytext NOT NULL,
			twitter_handle text,
			twitter_url text,
			phone INT,
			email TEXT,
			webform_url TEXT,
			UNIQUE KEY id (id)
			);"; 
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
						
			// write geodata table
			dbDelta($geo_sql);
			
			// write congressional bio table
			dbDelta($congress_bio_sql);
			
			add_option("ueg_leaflet_ver", $ver);
		}
		
		function install_data() {
			
			global $wpdb;
			
			$geo_table = $wpdb->base_prefix . "leaflet_congressional_districts";
			
			/* Alabama
			------------------------------------------- */
			
			/* District 05
			------------------------------------------- */
			// define data to be inserted
			// although i don't think this definition schema,
			// while novel, is necessarily that great at all.
			// plus it's time consuming to construct this data
			// set (even constructed programatically).
			
			$state = "AL";
			$district = '05';
			$marker['latitude'] = '34.6485266402914';
			$marker['longitude'] = '-86.8939107387298';
			$geometry[1]['latitude'] = '-88.1425769229';
			$geometry[1]['longitude'] = '34.5773307614';
			$geometry[2]['latitude'] = '-88.0987640743';
			$geometry[2]['longitude'] = '34.8894973074';
			$geometry[3]['latitude'] = '-88.2028195896';
			$geometry[3]['longitude'] = '34.9935528227';
			$geometry[4]['latitude'] = '-87.6058695279';
			$geometry[4]['longitude'] = '34.9990294288';
			$geometry[5]['latitude'] = '-85.6069083121';
			$geometry[5]['longitude'] = '34.9825996106';
			$geometry[6]['latitude'] = '-85.5850018878';
			$geometry[6]['longitude'] = '34.856637671';
			$geometry[7]['latitude'] = '-85.7876363124';
			$geometry[7]['longitude'] = '34.6211436099';
			$geometry[8]['latitude'] = '-86.0833730403';
			$geometry[8]['longitude'] = '34.4623220339';
			$geometry[9]['latitude'] = '-86.1490923131';
			$geometry[9]['longitude'] = '34.5992371857';
			$geometry[10]['latitude'] = '-86.3298203134';
			$geometry[10]['longitude'] = '34.5992371857';
			$geometry[11]['latitude'] = '-86.3298203134';
			$geometry[11]['longitude'] = '34.5116114885';
			$geometry[12]['latitude'] = '-86.4667354652';
			$geometry[12]['longitude'] = '34.473275246';
			$geometry[13]['latitude'] = '-86.5817441927';
			$geometry[13]['longitude'] = '34.5773307614';
			$geometry[14]['latitude'] = '-86.9432001934';
			$geometry[14]['longitude'] = '34.5937605796';
			$geometry[15]['latitude'] = '-86.9322469812';
			$geometry[15]['longitude'] = '34.396602761';
			$geometry[16]['latitude'] = '-87.1074983755';
			$geometry[16]['longitude'] = '34.5828073674';
			$geometry[17]['latitude'] = '-87.1074983755';
			$geometry[17]['longitude'] = '34.2980238518';
			$geometry[18]['latitude'] = '-87.5291970429';
			$geometry[18]['longitude'] = '34.3035004578';
			$geometry[19]['latitude'] = '-87.5291970429';
			$geometry[19]['longitude'] = '34.5663775492';
			$geometry[20]['latitude'] = '-88.1425769229';
			$geometry[20]['longitude'] = '34.5773307614';
			$geometry_vertex_count = 20; 
			
			// create json from marker and geometry arrays
			$marker_json = json_encode($marker);
			$geometry_json = json_encode($geometry);
			
			// insert row
			$sql = array('state' => $state,
			'district' => $district,
			'marker' => $marker_json,
			'geometry' => $geometry_json,
			'geometry_vertex_count' => $geometry_vertex_count);
			
			// confirm
			$rows_affected = $wpdb->insert($geo_table, $sql);
			
			/* District 04
			------------------------------------------- */
			
			// define data to be inserted
			$district = '04';
			$marker['latitude'] = '33.9666891844869';
			$marker['longitude'] = '-86.9021256478359';
			$geometry[1]['latitude'] = '-87.8358869829';
			$geometry[1]['longitude'] = '33.153413183';
			$geometry[2]['latitude'] = '-88.0604278318';
			$geometry[2]['longitude'] = '33.076740698';
			$geometry_vertex_count = 20; 
			
			// create json from marker and geometry arrays
			$marker_json = json_encode($marker);
			$geometry_json = json_encode($geometry);
			
			// insert row
			$sql = array('state' => $state,
			'district' => $district,
			'marker' => $marker_json,
			'geometry' => $geometry_json,
			'geometry_vertex_count' => $geometry_vertex_count);
			
			// confirm
			$rows_affected = $wpdb->insert($geo_table, $sql);			
			
				
		}
		
		function uninstall() {
			global $wpdb;
		}
				
		function get_admin_options() {
			
			$ueg_leaflet_admin_options = array('nytimes_api_key' => 'Enter NY Times API Key Here',
												'nytimes_api_ver' => 'v3',
												'sunlight_api_key' => 'Enter Sunlight Labs API Key Here');
										   
			$admin_options = get_option('ueg_leaflet_admin_options');
			
			if (!empty($admin_options)) {
				foreach ($admin_options as $key => $option)
					$ueg_leaflet_admin_options[$key] = $option;
			}
			
			update_option($this->admin_options_name, $ueg_leaflet_admin_options);
			
			return $ueg_leaflet_admin_options;
		}
				
		// Prints out the admin page
		function admin_page() {
											
			if (isset($_POST['update_ueg_leaflet_options'])) { 
			
				if (isset($_POST['ueg_leaflet_nytimes_api_key'])) {
					$this->admin_options['nytimes_api_key'] = $_POST['ueg_leaflet_nytimes_api_key'];
				}
				
				if (isset($_POST['ueg_leaflet_nytimes_api_ver'])) {
					$this->admin_options['nytimes_api_ver'] = $_POST['ueg_leaflet_nytimes_api_ver'];
				}
				
				if (isset($_POST['ueg_leaflet_sunlight_api_key'])) {
					$this->admin_options['sunlight_api_key'] = $_POST['ueg_leaflet_sunlight_api_key'];
				}
					
				update_option($this->admin_options_name, $this->admin_options);
				
				?>
				
				<div class="updated"><p><strong><?php _e("Settings Updated.", "ueg_leaflet");?></strong></p></div>
				
			<?php } ?>
			
			<div class="wrap">	
				<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
					
					<h2><?php _e('WordPress - Leaflet Options', 'ueg_leaflet'); ?></h2>
					
					<p><strong>Pretty leaflets. So pretty.<br />
					</strong>Much love,<br /> 
					K.</p>
					
					<h3><?php _e('Sunlight Labs API Key', 'ueg_leaflet'); ?></h3>
					<input type="text" name="ueg_leaflet_sunlight_api_key" 
						value="<?php echo $this->admin_options['sunlight_api_key']; ?>">
					
					<h3><?php _e('NY Times API Key', 'ueg_leaflet'); ?></h3>
					<input type="text" name="ueg_leaflet_nytimes_api_key" 
						value="<?php echo $this->admin_options['nytimes_api_key']; ?>">
						
					<h3><?php _e('NY Times API Ver.', 'ueg_leaflet'); ?></h3>
					<input type="text" name="ueg_leaflet_nytimes_api_ver" 
						value="<?php echo $this->admin_options['nytimes_api_ver']; ?>">	

					<div class="submit">
						<input type="submit" name="update_ueg_leaflet_options" 
							value="<?php _e('Update Settings', 'ueg_leaflet') ?>" />
					</div>
					
				</form>
			</div>
			
		<?php } 
		
		// End function print_admin_page()
		
		function get_geodata() {
			
			global $wpdb;
			$geo_table = $wpdb->base_prefix . "leaflet_congressional_districts";
			
			$geodata = $wpdb->get_row("SELECT * FROM $geo_table WHERE id = 1");
			
			$geodata->geometry = json_decode($geodata->geometry);
			
			return $geodata;
			
		}
				
		function leaflet_shortcode($attr) {
		
			/* This is awful; I need to find
				a better way of serving the geodata
				(geoJSON?), and a better way of displaying
				it.. Gotta step out of my comfort zone on this one. */
			
			$geodata = $this->get_geodata();
						
			$leaflet = '<div id="map" style="width: 680px; height: 300px;"></div>';
			
			$leaflet .= "\n<script type=\"text/javascript\">\n\n";
			$leaflet .= "var map = new L.Map('map');\n\nvar cloudmade = new L.TileLayer('http://{s}.tile.cloudmade.com/0dcfe4aac3ee439b86773be856512ca4/997/256/{z}/{x}/{y}.png', { attribution: 'Map data &copy; <a href=\"http://openstreetmap.org\">OpenStreetMap</a> contributors, <a href=\"http://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, Imagery &copy; <a href=\"http://cloudmade.com\">CloudMade</a>, Congressional data by <a href=\"http://data.nytimes.com\">data.nytimes.com</a>, <a href=\"http://sunlightlabs.com\">Sunlight Foundation</a>.', maxZoom: 18 });\n\n";
			
			$leaflet .= 'var ';
			$loop_counter = 1;
			foreach($geodata->geometry as $set) {
				$leaflet .= 'p'. $loop_counter .' = new L.LatLng('. $set->latitude .','. $set->longitude .')';
				$leaflet .= ",\n";
				$loop_counter++;
			}
			
			$leaflet .= 'polygonPoints = [';
				$loop_counter = 1;
				foreach($geodata->geometry as $set) {
					$leaflet .= 'p'. $loop_counter ;
					if($loop_counter < $geodata->geometry_vertex_count) {
						$leaflet .= ', ';
					}
					$loop_counter++;
				}
				
			$leaflet .= "],\n";
			
			$leaflet .= "polygon = new L.Polygon(polygonPoints);\n\nmap.addLayer(polygon);\n\n";
			
			$leaflet .= "var usa = new L.LatLng(39.571822,-93.691406);\nmap.setView(usa, 4).addLayer(cloudmade);\n\n";
			
			$leaflet .= "\n\n</script>";
			
			return $leaflet;
			
		}
	}
}

// Instantiate
if (class_exists("ueg_leaflet")) {
	$ueg_leaflet = new ueg_leaflet();
}

// Instantiate the Admin Panel
if (!function_exists("ueg_leaflet_ap")) {
	function ueg_leaflet_ap() {
		global $ueg_leaflet;
		if (function_exists('add_options_page')) {
			add_options_page('Leaflet', 'Leaflet', 9, basename(__FILE__), 
								array(&$ueg_leaflet, 'admin_page'));
		}
	}
}

// Actions and Filters	
if (isset($ueg_leaflet)) {

	// Shortcodes
	add_shortcode('leaflet', array(&$ueg_leaflet, 'leaflet_shortcode'));

	// Actions
	add_action('admin_menu', 'ueg_leaflet_ap');
	
	// Leaflet JS
	wp_register_script('ueg_leaflet_script', 'http://code.leafletjs.com/leaflet-0.3.1/leaflet.js');
	wp_enqueue_script('ueg_leaflet_script');
	
	// Leaflet CSS
	wp_register_style('ueg_leaflet_style', 'http://code.leafletjs.com/leaflet-0.3.1/leaflet.css');
	wp_enqueue_style('ueg_leaflet_style');
	
	// Client JS
	// wp_register_script('ueg_leaflet_script_client', plugins_url('script.js', __FILE__));
	
	// Client CSS
	wp_register_style('wp_convio_style', plugins_url('style.css', __FILE__));
	
	// Install Database
	register_activation_hook(__FILE__,array(&$ueg_leaflet, 'install'));
	
	// Insert Database Data
	register_activation_hook(__FILE__,array(&$ueg_leaflet, 'install_data'));

}

?>