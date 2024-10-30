<?php
/*
Plugin Name: BuyBlo Box
Description: BuyBlo.com provides product boxes for your wordpress website.
Version: 1.2.2
Author: BuyBlo.com
Author URI: https://buyblo.com/
License: MIT
*/

/*
Copyright (c) 2017 BuyBlo.com

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

BuyBlo Box uses some extra components:
1. Twig Template Engine:
- Source: http://twig.sensiolabs.org/
- License: new BSD License
- License URI: http://twig.sensiolabs.org/license
*/

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define('BUYBLO_BOX_VERSION', '1.2.2');
define('BUYBLO_BOX_MINIMUM_WP_VERSION', '4.0');
define('BUYBLO_BOX_PLUGIN_URL', plugin_dir_url(__FILE__));
define('BUYBLO_BOX_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('BUYBLO_BOX_THEME_ASSETS_DIR', get_template_directory() . '/byublo-box/assets/');
define('BUYBLO_BOX_THEME_ASSETS_URL', get_template_directory_uri() . '/byublo-box/assets/');
define('BUYBLO_BOX_THEME_VIEW_DIR', get_template_directory() . '/byublo-box/view/');
define('BUYBLO_BOX_PLUGIN_VIEW_DIR', plugin_dir_path(__FILE__) . 'view/');
define('BUYBLO_BOX_API_URL_BUYBLO', 'http://api.buyblo.com/api/');
define('BUYBLO_BOX_API_URL_NOKAUT', 'http://nokaut.io/api/v2/');

require_once BUYBLO_BOX_PLUGIN_DIR . "buyblo-box-autoload.php";

register_activation_hook(__FILE__, array('BuybloBox\\BuybloBox', 'activate'));
register_deactivation_hook(__FILE__, array('BuybloBox\\BuybloBox', 'deactivate'));

/**
 * Plugin init
 */
\BuybloBox\BuybloBox::init();

if (is_admin()) {
    \BuybloBox\Admin\Admin::init();
}
