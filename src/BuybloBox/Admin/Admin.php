<?php
namespace BuybloBox\Admin;


class Admin
{
    const BUYBLO_BOX_CONFIG_PAGE_UNIQUE_KEY = 'buyblo-box-config';

    private static $initiated = false;

    public static function init()
    {
        if (!self::$initiated) {
            self::initHooks();
            Metabox::init();
        }
    }

    public static function initHooks()
    {
        self::$initiated = true;

        add_action('admin_init', array(__CLASS__, 'adminInit'));
        add_action('admin_menu', array(__CLASS__, 'adminMenu'), 1);
        add_action('admin_menu', array('BuybloBox\\Admin\\Options', 'redirectAfterResetOptions'));

        add_action('admin_enqueue_scripts', array(__CLASS__, 'initJs'));
        add_action('admin_enqueue_scripts', array(__CLASS__, 'initCss'));
    }

    public static function adminInit()
    {
        Options::init();
    }

    public static function adminMenu()
    {
        $hook = add_options_page(__('BuyBlo Box', 'BuyBlo Box'), __('BuyBlo Box', 'BuyBlo Box'), 'manage_options', self::BUYBLO_BOX_CONFIG_PAGE_UNIQUE_KEY, array(__CLASS__, 'displayPage'));

        // top right corner help tabs
        if (version_compare($GLOBALS['wp_version'], '3.3', '>=')) {
            add_action("load-$hook", array(__CLASS__, 'adminHelp'));
        }
    }

    public static function initJs()
    {
        wp_register_script('buyblo-box-admin/groups-app-port.js', BUYBLO_BOX_PLUGIN_URL . 'assets/js/buyblo-box-admin/groups-app-port.js', array('jquery'), BUYBLO_BOX_VERSION);
        wp_localize_script('buyblo-box-admin/groups-app-port.js', 'buyblo_box_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
        wp_enqueue_script('buyblo-box-admin/groups-app-port.js');

        wp_register_script('buyblo-box-admin/groups.js', BUYBLO_BOX_PLUGIN_URL . 'assets/js/buyblo-box-admin/groups.js', array('jquery'), BUYBLO_BOX_VERSION);
        wp_localize_script('buyblo-box-admin/groups.js', 'buyblo_box_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
        wp_enqueue_script('buyblo-box-admin/groups.js');

        wp_register_script('buyblo-box-admin/search-app-port.js', BUYBLO_BOX_PLUGIN_URL . 'assets/js/buyblo-box-admin/search-app-port.js', array('jquery'), BUYBLO_BOX_VERSION);
        wp_localize_script('buyblo-box-admin/search-app-port.js', 'buyblo_box_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
        wp_enqueue_script('buyblo-box-admin/search-app-port.js');

        wp_register_script('buyblo-box-admin/search.js', BUYBLO_BOX_PLUGIN_URL . 'assets/js/buyblo-box-admin/search.js', array('jquery'), BUYBLO_BOX_VERSION);
        wp_localize_script('buyblo-box-admin/search.js', 'buyblo_box_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
        wp_enqueue_script('buyblo-box-admin/search.js');

        wp_register_script('buyblo-box-admin.js', BUYBLO_BOX_PLUGIN_URL . 'assets/js/buyblo-box-admin.js', array('jquery'), BUYBLO_BOX_VERSION);
        wp_localize_script('buyblo-box-admin.js', 'buyblo_box_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
        wp_enqueue_script('buyblo-box-admin.js');
    }

    public static function initCss()
    {
        wp_register_style('buyblo-box-admin.css', BUYBLO_BOX_PLUGIN_URL . 'assets/css/buyblo-box-admin.css', array(), BUYBLO_BOX_VERSION);
        wp_enqueue_style('buyblo-box-admin.css');
    }

    public static function displayPage()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        echo '<div class="wrap">';
        echo '<h2>BuyBlo Box - konfiguracja wtyczki BuyBlo.com</h2>';
        Options::form();
        echo '</div>';
        echo '<script>jQuery(document).ready(function () {BuyBloMetaBox.initHelp();});</script>';
    }

    /**
     * Add help to the BuyBlo Box page
     *
     * @return false if not the BuyBlo Box page
     */
    public static function adminHelp()
    {
        $current_screen = get_current_screen();

        $current_screen->add_help_tab(
            array(
                'id' => 'overview',
                'title' => "Wprowadzenie",
                'content' =>
                    '<p>Wtyczka BuyBlo Box jest bezpłatnym narzędziem, które umożliwia dodawanie boxów z produktami 
do tworzonych na blogu wpisów oraz zarabianiu na przekierowaniach do sklepów internetowych.
</p>'
            )
        );

        $current_screen->add_help_tab(
            array(
                'id' => 'configuration',
                'title' => 'Konfiguracja',
                'content' =>
                    '<p>Aby skonfigurować wtyczkę wystarczy w jej ustawieniach wpisać uzyskany w serwisie Buyblo.com 
klucz dostępu.</p>',
            )
        );

        $current_screen->add_help_tab(
            array(
                'id' => 'features',
                'title' => 'Integracja z blogiem',
                'content' =>
                    '<p>Integracja z blogiem jest automatyczna, po dodaniu produktów do wpisów, pojawią się one 
automatycznie pod treścią wpisów.</p>'
            )
        );

        // Help Sidebar
        $current_screen->set_help_sidebar(
            '<p><strong>Więcej informacji</strong></p>' .
            '<p><a href="https://buyblo.com/" target="_blank">buyblo.com</a></p>' .
            '<p><a href="mailto:hello@buyblo.com" target="_blank">hello@buyblo.com</a></p>'
        );
    }
}