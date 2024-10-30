<?php
namespace BuybloBox;

use BuybloBox\Admin\Options;
use BuybloBox\Template\Renderer;
use BuybloBox\View\Box;
use BuybloBox\View\BoxException;

class BuybloBox
{
    private static $initiated = false;

    public static function init()
    {
        if (!self::$initiated) {
            self::init_hooks();
        }
    }

    /**
     * Initializes WordPress hooks
     */
    private static function init_hooks()
    {
        self::$initiated = true;
        self::setTemplateDirs();

        NokautApiKitFactory::setApiKey(Options::getOption(Options::OPTION_API_KEY));
        NokautApiKitFactory::setApiUrl(BUYBLO_BOX_API_URL_NOKAUT);

        BuybloApiKitFactory::setApiKey(Options::getOption(Options::OPTION_API_KEY));
        BuybloApiKitFactory::setApiUrl(BUYBLO_BOX_API_URL_BUYBLO);

        add_action('wp_enqueue_scripts', array(__CLASS__, 'initJs'));
        add_action('wp_enqueue_scripts', array(__CLASS__, 'initCss'));

        self::initAjax();
        self::registerShortCodes();
        self::registerFilters();
    }

    public static function activate()
    {
        // nothing to do
    }

    public static function deactivate()
    {
        // tidy up
    }

    private static function setTemplateDirs()
    {
        $templateDirs = array();
        if (file_exists(BUYBLO_BOX_THEME_VIEW_DIR)) {
            $templateDirs[] = BUYBLO_BOX_THEME_VIEW_DIR;
        }
        $templateDirs[] = BUYBLO_BOX_PLUGIN_VIEW_DIR;

        Renderer::setTemplateBasePaths($templateDirs);
    }

    public static function initJs()
    {
        if (file_exists(BUYBLO_BOX_THEME_ASSETS_DIR . 'js/buyblo-box.js')) {
            wp_register_script('buyblo-box.js', BUYBLO_BOX_THEME_ASSETS_URL . 'js/buyblo-box.js', array('jquery'), BUYBLO_BOX_VERSION);
        } else {
            wp_register_script('buyblo-box.js', BUYBLO_BOX_PLUGIN_URL . 'assets/js/buyblo-box.js', array('jquery'), BUYBLO_BOX_VERSION);
        }

        wp_localize_script('buyblo-box.js', 'buyblo_box_ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
        wp_enqueue_script('buyblo-box.js');
    }

    public static function initCss()
    {
        if (file_exists(BUYBLO_BOX_THEME_ASSETS_DIR . 'css/buyblo-box.css')) {
            wp_register_style('buyblo-box.css', BUYBLO_BOX_THEME_ASSETS_URL . 'css/buyblo-box.css', array(), BUYBLO_BOX_VERSION);
        } else {
            wp_register_style('buyblo-box.css', BUYBLO_BOX_PLUGIN_URL . 'assets/css/buyblo-box.css', array(), BUYBLO_BOX_VERSION);
        }
        wp_enqueue_style('buyblo-box.css');
    }

    public static function initAjax()
    {
        add_action('wp_ajax_get_buyblo_box', array(__CLASS__, 'ajaxCallback'));
        add_action('wp_ajax_nopriv_get_buyblo_box', array(__CLASS__, 'ajaxCallback'));
    }

    public static function ajaxCallback()
    {
        $postId = (isset($_POST['post_id']) and $_POST['post_id']) ? (int)$_POST['post_id'] : null;
        $group = (isset($_POST['group']) and $_POST['group']) ? (int)$_POST['group'] : null;
        $template = (isset($_POST['template']) and $_POST['template']) ? $_POST['template'] : Options::getOption(Options::OPTION_DEFAULT_TEMPLATE_NAME);
        $classes = isset($_POST['classes']) ? $_POST['classes'] : null;

        $data = array();
        $data['post_id'] = $postId;
        $data['group'] = $group;
        $data['template'] = $template;
        $data['classes'] = $classes;
        $data['box'] = '';
        $data['error'] = '';

        try {
            $box = new Box();
            $data['box'] = $box->render($postId, $group, $template, Box::RENDER_TYPE_INLINE, $classes, true);
        } catch (BoxException $e) {
            $data['error'] = $e->getMessage();
        } catch (\Exception $e) {
            $data['error'] = 'Internal error (callback)';
            error_log($e->getMessage() . ' in file ' . $e->getFile() . ':' . $e->getLine());
        }

        header('Content-Type: application/json');
        echo json_encode($data);
        die;
    }

    public static function registerFilters()
    {
        add_filter('the_content', array(__CLASS__, 'shortCodeBottomFilter'));
    }

    public static function shortCodeBottomFilter($content)
    {
        // if get_the_ID() has groups saved?

        if (is_single()) {
            $addShortCode = stristr($content, 'buyblo-box') ? false : true;
            if ($addShortCode) {
                return $content . "[buyblo-box render_type='inline']";
            }
        }

        return $content;
    }

    public static function registerShortCodes()
    {
        add_shortcode('buyblo-box', array('\\BuybloBox\\ShortCode', 'box'));
    }
}