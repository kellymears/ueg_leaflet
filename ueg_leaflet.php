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
		
		function ueg_leaflet_install() {
			
			global $wpdb;
			global $ueg_leaflet_version;
			
			$geo_table = $wpdb->base_prefix . "ueg_leaflet_congressional_districts";
			$geo_sql = "CREATE TABLE $geo_table (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				state tinytext NOT NULL,
				district tinytext NOT NULL,
				marker text NOT NULL,
				geometry text NOT NULL,
				geometry_vertex_count text NOT NULL,
				UNIQUE KEY id (id) 
			);";
			
			 
			
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($geo_table);
			
			add_option("ueg_leaflet_version", $ueg_leaflet_version)
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
			
			// Yeah, you heard me. Geodata.
			$states = array('AL'=>"Alabama",
		                'AK'=>"Alaska",  
		                'AZ'=>"Arizona",  
		                'AR'=>"Arkansas",  
		                'CA'=>"California",  
		                'CO'=>"Colorado",  
		                'CT'=>"Connecticut",  
		                'DE'=>"Delaware",  
		                'DC'=>"District Of Columbia",  
		                'FL'=>"Florida",  
		                'GA'=>"Georgia",  
		                'HI'=>"Hawaii",  
		                'ID'=>"Idaho",  
		                'IL'=>"Illinois",  
		                'IN'=>"Indiana",  
		                'IA'=>"Iowa",  
		                'KS'=>"Kansas",  
		                'KY'=>"Kentucky",  
		                'LA'=>"Louisiana",  
		                'ME'=>"Maine",  
		                'MD'=>"Maryland",  
		                'MA'=>"Massachusetts",  
		                'MI'=>"Michigan",  
		                'MN'=>"Minnesota",  
		                'MS'=>"Mississippi",  
		                'MO'=>"Missouri",  
		                'MT'=>"Montana",
		                'NE'=>"Nebraska",
		                'NV'=>"Nevada",
		                'NH'=>"New Hampshire",
		                'NJ'=>"New Jersey",
		                'NM'=>"New Mexico",
		                'NY'=>"New York",
		                'NC'=>"North Carolina",
		                'ND'=>"North Dakota",
		                'OH'=>"Ohio",  
		                'OK'=>"Oklahoma",  
		                'OR'=>"Oregon",  
		                'PA'=>"Pennsylvania",  
		                'RI'=>"Rhode Island",  
		                'SC'=>"South Carolina",  
		                'SD'=>"South Dakota",
		                'TN'=>"Tennessee",  
		                'TX'=>"Texas",  
		                'UT'=>"Utah",  
		                'VT'=>"Vermont",  
		                'VA'=>"Virginia",  
		                'WA'=>"Washington",  
		                'WV'=>"West Virginia",  
		                'WI'=>"Wisconsin",  
		                'WY'=>"Wyoming"); // lol
			return $states;
		}
				
		function leaflet_shortcode($attr) {
		
			$leaflet = $this->get_geodata();
			
			$leaflet = '<div id="map" style="width: 680px; height: 300px;"></div>';
			
			wp_enqueue_script('script.js', WP_CONTENT_URL .'/plugins/ueg_leaflet/script.js', 0, '1.0.0', 'in_footer');

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

	// Shortcode
	add_shortcode('leaflet', array(&$ueg_leaflet, 'leaflet_shortcode'));

	// Actions
	add_action('admin_menu', 'ueg_leaflet_ap');
	// add_action('init',  array(&$ueg_leaflet, 'create_leaflet_post_types'));
	
	// Leaflet JS/CSS
	wp_register_script('ueg_leaflet_script', 'http://code.leafletjs.com/leaflet-0.3.1/leaflet.js');
	wp_register_style('ueg_leaflet_style', 'http://code.leafletjs.com/leaflet-0.3.1/leaflet.css');
	wp_enqueue_script('ueg_leaflet_script');
	wp_enqueue_style('ueg_leaflet_style');
	
	// Plugin JS/CSS
	wp_register_style('wp_convio_style', plugins_url('style.css', __FILE__));

}

?>