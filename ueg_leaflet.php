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
		
		public $states = array('AL'=>"Alabama",
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
		                'WY'=>"Wyoming");
                		
		function __construct() {
		
			// $this->admin_options = $this->get_admin_options();

		}
		
		function get_admin_options() {
			
			/* $ueg_leaflet_admin_options = array('host' => 'Enter Host Here',
						                     'short_name' => 'Enter Short Name Here',
						                     'api_key' => 'Enter API Key Here',
						                     'login_name' => 'Enter Login Name Here',
						                     'login_password' => 'Enter Login Password Here'); */

										   
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
			
				if (isset($_POST['ueg_leaflet_host'])) {
					$this->admin_options['host'] = $_POST['ueg_leaflet_host'];
				}
					
				if (isset($_POST['ueg_leaflet_short_name'])) {
					$this->admin_options['short_name'] = $_POST['ueg_leaflet_short_name'];
				}
					
				if (isset($_POST['ueg_leaflet_api_key'])) {
					$this->admin_options['api_key'] = $_POST['ueg_leaflet_api_key'];
				}
				
				if (isset($_POST['ueg_leaflet_login_name'])) {
					$this->admin_options['login_name'] = $_POST['ueg_leaflet_login_name'];
				}
				
				if (isset($_POST['ueg_leaflet_login_name'])) {
					$this->admin_options['login_password'] = $_POST['ueg_leaflet_login_password'];
				}
					
				update_option($this->admin_options_name, $this->admin_options);
				
				?>
				
				<div class="updated"><p><strong><?php _e("Settings Updated.", "ueg_leaflet");?></strong></p></div>
				
			<?php } ?>
			
			<div class="wrap">	
				<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
					
					<h2><?php _e('WordPress - Convio Options', 'ueg_leaflet'); ?></h2>
					
					<p><strong>This plugin is a work in progress.<br />
					</strong>Much love,<br /> 
					K.</p>
					
					<h3><?php _e('Convio Host', 'ueg_leaflet'); ?></h3>
					<input type="text" name="ueg_leaflet_host" 
						value="<?php echo $this->admin_options['host']; ?>">
					
					<h3><?php _e('Convio Short Name', 'ueg_leaflet'); ?></h3>
					<input type="text" name="ueg_leaflet_short_name" 
						value="<?php echo $this->admin_options['short_name']; ?>">
					
					<h3><?php _e('Convio API Key', 'ueg_leaflet'); ?></h3>
					<input type="text" name="ueg_leaflet_api_key" 
						value="<?php echo $this->admin_options['api_key']; ?>">
					
					<h3><?php _e('Convio Login Name', 'ueg_leaflet'); ?></h3>
					<input type="text" name="ueg_leaflet_login_name" 
						value="<?php echo $this->admin_options['login_name']; ?>">
					
					<h3><?php _e('Convio Login Password', 'ueg_leaflet'); ?></h3>
					<input type="text" name="ueg_leaflet_login_password" 
						value="<?php echo $this->admin_options['login_password']; ?>">

					<div class="submit">
						<input type="submit" name="update_ueg_leaflet_options" 
							value="<?php _e('Update Settings', 'ueg_leaflet') ?>" />
					</div>
					
				</form>
			</div>
			
		<?php } 
		
		// End function print_admin_page()
				
		function leaflet_shortcode($attr) {
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
	
	// Scripting + Styling
	wp_register_script('ueg_leaflet_script', plugins_url('script.js', __FILE__));
	wp_register_style('ueg_leaflet_style', plugins_url('style.css', __FILE__));
	wp_enqueue_script('ueg_leaflet_script');
	wp_enqueue_style('ueg_leaflet_style');

}

?>