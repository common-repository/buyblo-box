<?php
namespace BuybloBox\Template;

class Renderer
{
    /**
     * @var \Twig_Environment
     */
    private static $twig;

    /**
     * @var array()
     */
    private static $templateBasePaths = array();

    /**
     * @param \Twig_Environment $twig
     */
    private static function setTwig($twig)
    {
        self::$twig = $twig;
    }

    /**
     * @return \Twig_Environment
     */
    private static function getTwig()
    {
        return self::$twig;
    }

    /**
     * @param array $templateBasePaths
     */
    public static function setTemplateBasePaths($templateBasePaths)
    {
        if (!is_array($templateBasePaths)) {
            $templateBasePaths = array($templateBasePaths);
        }

        self::$templateBasePaths = $templateBasePaths;
    }

    /**
     * @return array
     */
    private static function getTemplateBasePaths()
    {
        return self::$templateBasePaths;
    }

    /**
     * @param string $template
     * @param array $context
     * @return string
     */
    public static function render($template, $context = array())
    {
        if (!self::getTwig()) {
            $loader = new \Twig_Loader_Filesystem(self::getTemplateBasePaths());
            self::setTwig(new \Twig_Environment($loader));

            self::getTwig()->addFilter(new \Twig_SimpleFilter('photoUrl', array('BuybloBox\\Template\\Filter\\PhotoUrl', 'getPhotoUrl')));
            self::getTwig()->addFilter(new \Twig_SimpleFilter('shopLogoUrl', array('BuybloBox\\Template\\Filter\\PhotoUrl', 'getShopLogoUrl')));
            self::getTwig()->addFilter(new \Twig_SimpleFilter('clickUrl', array('BuybloBox\\Template\\Filter\\ClickUrl', 'clickUrl')));
            self::getTwig()->addFilter(new \Twig_SimpleFilter('short', array('BuybloBox\\Template\\Filter\\Text', 'short')));
            self::getTwig()->addFilter(new \Twig_SimpleFilter('price', array('BuybloBox\\Template\\Filter\\Text', 'price')));
            self::getTwig()->addFilter(new \Twig_SimpleFilter('priceSup', array('BuybloBox\\Template\\Filter\\Text', 'priceSup')));
            self::getTwig()->addFilter(new \Twig_SimpleFilter('propertiesFilter', array('BuybloBox\\Template\\Filter\\PropertiesFilter', 'propertiesFilter')));
            self::getTwig()->addFilter(new \Twig_SimpleFilter('productsSearchUrl', array('BuybloBox\\Template\\Filter\\ProductsSearchUrl', 'productsSearchUrl')));
        }

        $template = self::getTwig()->loadTemplate($template);
        return $template->render($context);
    }
}