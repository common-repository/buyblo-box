<?php
namespace BuybloBox\Admin;

use BuybloBox\BuybloApiKitFactory;
use BuybloBox\NokautApiKitFactory;
use Nokaut\ApiKitBB\Collection\Products;
use Nokaut\BuybloApiKit\Entity\Status;
use Nokaut\BuybloApiKit\Repository\StatusRepository;

class Options
{
    const OPTIONS_GROUP = 'buyblo_box_options';
    const OPTIONS_SECTION_API = 'buyblo_box_options_section_api';
    const OPTIONS_SECTION_ADVANCED = 'buyblo_box_options_section_advanced';
    const OPTIONS_SECTION_SETTINGS = 'buyblo_box_options_section_settings';
    const OPTION_API_KEY = 'buyblo_box_api_key';
    const OPTION_DEFAULT_TEMPLATE_NAME = 'buyblo_box_option_default_template_name';

    private static $optionsDefault = array(
        self::OPTION_API_KEY => '',
        self::OPTION_DEFAULT_TEMPLATE_NAME => 'default',
    );

    public static function init()
    {
        if (self::resetOptionsModeEnabled()) {
            self::resetOptions();
            NokautApiKitFactory::setApiKey(Options::getOption(Options::OPTION_API_KEY));
            NokautApiKitFactory::setApiUrl(BUYBLO_BOX_API_URL_NOKAUT);
            BuybloApiKitFactory::setApiKey(Options::getOption(Options::OPTION_API_KEY));
            BuybloApiKitFactory::setApiUrl(BUYBLO_BOX_API_URL_BUYBLO);
        }

        register_setting(self::OPTIONS_GROUP, self::OPTIONS_GROUP, array(__CLASS__, 'validate'));

        add_settings_section(self::OPTIONS_SECTION_API, 'Klucz dostępu', array(__CLASS__, 'sectionApiText'),
            Admin::BUYBLO_BOX_CONFIG_PAGE_UNIQUE_KEY);

        add_settings_field(self::OPTION_API_KEY, 'Klucz dostępu', array(__CLASS__, 'apiKeyInputText'),
            Admin::BUYBLO_BOX_CONFIG_PAGE_UNIQUE_KEY, self::OPTIONS_SECTION_API);

        add_settings_section(self::OPTIONS_SECTION_ADVANCED, '', array(__CLASS__, 'sectionAdvancedText'),
            Admin::BUYBLO_BOX_CONFIG_PAGE_UNIQUE_KEY);
    }

    public static function sectionApiText()
    {
        echo '<p>Wprowadź klucz dostępu uzyskany w serwisie <a href="https://buyblo.com/" target="_blank">Buyblo.com</a>.</p>';
    }

    public static function apiKeyInputText()
    {
        $value = self::getOption(self::OPTION_API_KEY);
        echo "<input id='" . self::OPTION_API_KEY . "' name='buyblo_box_options[" . self::OPTION_API_KEY . "]' size='95' type='text' value='{$value}' />";
    }

    public static function sectionAdvancedText()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');

        echo '<p><a href="#" id="buyblo_admin_help_advanced_toggle">Dodatkowe opcje</a></p>';
        echo '<div id="buyblo_admin_help_advanced" style="display: none;">';

        echo '<h2>Resetowanie ustawień wtyczki</h2>';
        echo '<p>W razie problemów z wtyczką po zapisaniu nieprawidłowych danych, zresetuj ustawienia wtyczki, aby zacząć od początku.</p>';
        echo '<p><a href="/wp-admin/options-general.php?page=buyblo-box-config&buyblo-box-options-reset=1" class="button button-primary">Zresetuj ustawienia wtyczki</a></p>';

        echo '<h2>Test komunikacji z API</h2>';
        try {
            $apiKit = BuybloApiKitFactory::getApiKitInDebugMode();
            $statusRepository = $apiKit->getStatusRepository();
            $status = $statusRepository->fetch(StatusRepository::$fieldsAll);
            if ($status instanceof Status) {
                echo '<p><b>Poprawna komunikacja z API publikacji</b></p>';
            }
        } catch (\Exception $e) {
            echo '<p><b>Błąd w komunikacji z API publikacji:</b> ' . $e->getMessage() . '</p>';
        }

        try {
            $apiKit = NokautApiKitFactory::getApiKitInDebugMode();
            $productsRepository = $apiKit->getProductsRepository();
            $products = $productsRepository->fetchProductsByProducerName('sony', 1, array('id'));
            if ($products instanceof Products) {
                echo '<p><b>Poprawna komunikacja z API produktowym</b></p>';
            }
        } catch (\Exception $e) {
            echo '<p><b>Błąd w komunikacji z API produktowym:</b> ' . $e->getMessage() . '</p>';
        }

        echo '</div>';
        error_reporting(0);
        ini_set('display_errors', 'Off');
    }

    public static function validate($input)
    {
        $options = $input;
        return $options;
    }

    public static function form()
    {
        echo '<form method="post" action="options.php"> ';
        settings_fields(self::OPTIONS_GROUP);
        do_settings_sections(Admin::BUYBLO_BOX_CONFIG_PAGE_UNIQUE_KEY);
        submit_button();
        echo '</form>';
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function getOption($key)
    {
        $options = get_option(self::OPTIONS_GROUP);
        if (isset($options[$key])) {
            return $options[$key];
        } elseif (isset(self::$optionsDefault[$key])) {
            return self::$optionsDefault[$key];
        }
    }

    /**
     * @return bool
     */
    public static function resetOptionsModeEnabled()
    {
        return
            is_admin() && isset($_GET['page'])
            && $_GET['page'] == 'buyblo-box-config'
            && isset($_GET['buyblo-box-options-reset'])
            && $_GET['buyblo-box-options-reset'] == '1';
    }

    public static function resetOptions()
    {
        delete_option(self::OPTIONS_GROUP);
    }

    public static function redirectAfterResetOptions()
    {
        if (self::resetOptionsModeEnabled()) {
            wp_redirect('/wp-admin/options-general.php?page=buyblo-box-config');
        }
    }
}