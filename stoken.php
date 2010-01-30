<?php
/*
Plugin Name: SToken Console
Plugin URI: http://labs.leftcolumn.net/stoken-console/
Description: Add an interactive console to your Wordpress Site. 
Version: 0.7
Author: Joe Left
Author URI: http://labs.leftcolumn.net
*/

/*  Copyright 2010  Joe Left  (email : stoken@leftcolumn.net)

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

require_once(dirname(__FILE__).'/stoken_config.php');
require_once(dirname(__FILE__).'/stoken_admin.php');
require_once(dirname(__FILE__).'/stoken_install.php');
require_once(dirname(__FILE__).'/stoken_admin_form.php');
require_once(dirname(__FILE__).'/stoken_public.php');
require_once(dirname(__FILE__).'/stoken_token_secret.php');

// get options and other setup stuff
$stokenConfig = StokenConfig::getInstance();


// if the plugin has just been activated, run the install check
register_activation_hook ( __FILE__, 'stoken_admin_install' );


//  if in the wp dashboard, add a new menu item
add_action ( 'admin_menu', 'stoken_admin_menu_setup' );


// add css to the head
add_action('wp_head', 'stoken_css');
add_action('admin_head', 'stoken_css');
 





?>