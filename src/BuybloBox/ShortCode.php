<?php
namespace BuybloBox;


use BuybloBox\Admin\Options;
use BuybloBox\Template\Renderer;
use BuybloBox\View\Box;
use BuybloBox\View\BoxException;

class ShortCode
{
    /**
     * @param array $attributes
     * @return string
     */
    public static function box($attributes = array())
    {
        $a = shortcode_atts(array(
            'post_id' => get_the_ID(),
            'group' => null,
            'template' => Options::getOption(Options::OPTION_DEFAULT_TEMPLATE_NAME),
            'render_type' => Box::RENDER_TYPE_AJAX_DATA_HOOK,
            'classes' => null
        ), $attributes);

        try {
            return Box::render($a['post_id'], $a['group'], $a['template'], $a['render_type'], $a['classes']);
        } catch (BoxException $e) {
            return Renderer::render('error.twig', array('message' => $e->getMessage()));
        } catch (\Exception $e) {
            error_log($e->getMessage() . ' in file ' . $e->getFile() . ':' . $e->getLine());
            return Renderer::render('error.twig', array('message' => 'Internal error (short code)'));
        }
    }
}
