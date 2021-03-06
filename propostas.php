<?php

/**
 * The plugin bootstrap file
 *
 * This file is responsible for starting the plugin using the main plugin
 * class file.
 *
 * @package           Propostas
 *
 * @wordpress-plugin
 * Plugin Name:       Propostas
 * Plugin URI:        http://tutsplus.com/tutorials/creating-maintainable-wordpress-meta-boxes--cms-22189
 * Description:       Plugin que gerencia propostas
 * Version:           0.1.0
 * Author:            Eduardo Alencar
 * Author URI:        http://github.com/edueo
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       propostas
 */

if( !defined('PLUGIN_DIR_PATH') ) {
    define('PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}

if( !defined('PLUGIN_URL') ) {
    define('PLUGIN_URL', plugins_url() . '/'. basename(dirname(__FILE__)) . '/' );
}

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

require_once PLUGIN_DIR_PATH . 'admin/class-propostas-custom-post.php';

require_once PLUGIN_DIR_PATH . 'admin/class-propostas-taxonomy.php';

require_once PLUGIN_DIR_PATH . 'admin/class-propostas-meta-box.php';

require_once PLUGIN_DIR_PATH . 'admin/class-settings-page.php';

require_once PLUGIN_DIR_PATH . 'admin/class-propostas.php';




function run_propostas() {
    $propostas = new Propostas_Admin( 'propostas', '0.3.0' );
}
run_propostas();