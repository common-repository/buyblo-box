<?php

namespace BuybloBox\View;

use BuybloBox\Admin\Metabox;
use BuybloBox\Exception\PostNotFoundException;
use BuybloBox\Repository\PostsRepository;
use NokautApiKitBuybloBox\Repository\ProductsRepository;
use BuybloBox\Admin\Options;
use BuybloBox\NokautApiKitFactory;
use BuybloBox\Template\Renderer;

class Box
{
    const RENDER_TYPE_INLINE = 'inline';
    const RENDER_TYPE_AJAX_DATA_HOOK = 'ajax';

    private static $map = array(
        'big' => 'Big',
        'row1' => 'NOK-row1',
        'row2' => 'NOK-row2',
        'row3' => 'NOK-row3',
        'row4' => 'NOK-row4',
        'row5' => 'NOK-row5',
    );

    /**
     * @param int $postId
     * @param int $group
     * @param string $template
     * @param string $renderType
     * @param null|string $classes
     * @param bool $ajaxMode
     * @return string
     * @throws BoxException
     */
    public static function render($postId, $group, $template, $renderType = self::RENDER_TYPE_INLINE, $classes = null, $ajaxMode = false)
    {
        if (!self::isRenderAccess()) {
            return '<!-- BuyBlo Box: No render access -->';
        }

        if (!$template) {
            $template = Options::getOption(Options::OPTION_DEFAULT_TEMPLATE_NAME);
        }

        if (preg_match('@[^a-zA-Z0-9_/-]@', $template)) {
            throw new BoxException("Template name accept only characters from: [a-zA-Z0-9_/-]");
        }

        switch ($renderType) {
            case self::RENDER_TYPE_INLINE:
                return self::renderInline($postId, $group, $template, $classes, $ajaxMode);
                break;
            case self::RENDER_TYPE_AJAX_DATA_HOOK:
                return self::renderAjaxDataHook($postId, $group, $template, $classes);
                break;
            default:
                throw new BoxException("Unknown render type: " . $renderType);
                break;
        }
    }

    /**
     * @return bool
     */
    public static function isRenderAccess()
    {
        return true;
    }

    /**
     * @param int $group
     * @param string $template
     * @param null|string $classes
     * @param null|string $content
     * @return string
     */
    private static function renderAjaxDataHook($postId, $group, $template, $classes = null, $content = null)
    {
        $context = array(
            'post_id' => $postId,
            'group' => $group,
            'template' => $template,
            'hook_id' => md5($postId . $group . $template . microtime(true) . rand(1, 1000))
        );

        if ($classes !== null) {
            $context['classes'] = $classes;
        }

        if ($content !== null) {
            $context['content'] = $content;
        }

        return Renderer::render('ajaxDataHook.twig', $context);
    }

    /**
     * @param int $postId
     * @param int $group
     * @param string $template
     * @param null|string $classes
     * @param bool $ajaxMode
     * @return string
     */
    private static function renderInline($postId, $group, $template, $classes = null, $ajaxMode = false)
    {
        $mode = null;
        if (preg_match('@(?<mode>[a-zA-Z0-9_-]+)/([a-zA-Z0-9_-]+)@', $template, $matches)) {
            $mode = $matches['mode'];
        }

        switch ($mode) {
            default:
                $modeContext = self::contextDefaultMode($postId, $group);
                break;
        }

        $context = array_merge(
            array(
                'buyblo_box_plugin_url' => BUYBLO_BOX_PLUGIN_URL,
                'classes' => self::mapClasses($classes),
                'edit_mode' => false
            ),
            $modeContext
        );

        $content = Renderer::render('templates/' . $template . '.twig', $context);

        if ($ajaxMode) {
            return $content;
        }

        return self::renderAjaxDataHook($postId, $group, $template, $classes, $content);
    }

    /**
     * @param int $group
     * @return array
     * @throws BoxException
     */
    private static function contextDefaultMode($postId, $group)
    {
        $posts = new PostsRepository();

        try {
            $post = $posts->fetchPostWithProductsEntities($postId, false);
        } catch (PostNotFoundException $e) {
            $post = null;
        }

        if (!$post) {
            throw new BoxException("Post not found for id: " . $postId);
        }

        if (!$post->getGroups()) {
            throw new BoxException("Groups not found for post id: " . $postId);
        }

        $modeContext = array(
            'post' => $post,
        );

        return $modeContext;
    }

    /**
     * @param null|string $classes
     * @return array
     */
    private static function mapClasses($classes)
    {
        if (!$classes) {
            $classes = array();
        } else {
            $classes = explode('|', $classes);
        }
        foreach ($classes as $key => $value) {
            if (isset(self::$map[$value])) {
                $classes[$key] = self::$map[$value];
            }
        }

        return $classes;
    }
}