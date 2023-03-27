<?php
/**
* 2007-2023 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2023 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class CookieConsent extends Module
{
    const CC_FORCE_CONSENT = "CC_FORCE_CONSENT";
    const CC_CONSENT_LAYOUT = "CC_CONSENT_LAYOUT";
    const CC_CONSENT_POSITION = "CC_CONSENT_POSITION";
    const CC_SETTINGS_LAYOUT = "CC_SETTINGS_LAYOUT";
    const CC_DISPLAY_SECTION_FUNCTION = "CC_DISPLAY_SECTION_FUNCTION";
    const CC_DISPLAY_SECTION_CUSTOMISE = "CC_DISPLAY_SECTION_CUSTOMISE";
    const CC_DISPLAY_SECTION_SECURITY = "CC_DISPLAY_SECTION_SECURITY";
    const CC_DISPLAY_SECTION_ADS = "CC_DISPLAY_SECTION_ADS";
    const CC_DISPLAY_SECTION_ANALYTICS = "CC_DISPLAY_SECTION_ANALYTICS";
    const CC_AUTO_CLEAR = "CC_AUTO_CLEAR";
    const CC_THEME = 'CC_THEME';

    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'cookieconsent';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Novanta';
        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        $this->displayName = ('Cookie Consent');
        $this->description = ('This module is a wrapper for cookie-consent plugin');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);

        parent::__construct();
    } 

    public function install()
    {
        Configuration::updateValue(self::CC_FORCE_CONSENT, false);
        Configuration::updateValue(self::CC_CONSENT_LAYOUT, "cloud");
        Configuration::updateValue(self::CC_SETTINGS_LAYOUT, "box");
        Configuration::updateValue(self::CC_CONSENT_POSITION, "bottom right");
        Configuration::updateValue(self::CC_DISPLAY_SECTION_ADS, true);
        Configuration::updateValue(self::CC_DISPLAY_SECTION_ANALYTICS, true);
        Configuration::updateValue(self::CC_DISPLAY_SECTION_FUNCTION, true);
        Configuration::updateValue(self::CC_DISPLAY_SECTION_CUSTOMISE, true);
        Configuration::updateValue(self::CC_DISPLAY_SECTION_SECURITY, true);
        Configuration::updateValue(self::CC_AUTO_CLEAR, false);
        Configuration::updateValue(self::CC_THEME, 'light');

        return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayFooter');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitCCModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCCModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Force consent'),
                        'name' => self::CC_FORCE_CONSENT,
                        'is_bool' => true,
                        'desc' => $this->l('Force consent before interact with page'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Position'),
                        'name' => self::CC_CONSENT_POSITION,
                        'desc' => $this->l('Choose position of consent modal'),
                        'options' => array(
                            'query' => [
                                array(
                                    'id_option' => 'bottom left',
                                    'label' => $this->l('Bottom Left')
                                ),
                                array(
                                    'id_option' => 'bottom center',
                                    'label' => $this->l('Bottom Center')
                                ),
                                array(
                                    'id_option' => 'bottom right',
                                    'label' => $this->l('Bottom Right')
                                ),
                                array(
                                    'id_option' => 'middle left',
                                    'label' => $this->l('Middle Left')
                                ),
                                array(
                                    'id_option' => 'middle center',
                                    'label' => $this->l('Middle Center')
                                ),
                                array(
                                    'id_option' => 'middle right',
                                    'label' => $this->l('Middle Right')
                                ),
                                array(
                                    'id_option' => 'top left',
                                    'label' => $this->l('Top Left')
                                ),
                                array(
                                    'id_option' => 'top center',
                                    'label' => $this->l('Top Center')
                                ),
                                array(
                                    'id_option' => 'top right',
                                    'label' => $this->l('Top Right')
                                ),
                            ],
                                'id' => 'id_option',
                                'name' => 'label',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Layout'),
                        'name' => self::CC_CONSENT_LAYOUT,
                        'desc' => $this->l('Choose layout'),
                        'options' => array(
                            'query' => [
                                array(
                                    'id_option' => 'cloud',
                                    'label' => $this->l('Cloud')
                                ),
                                array(
                                    'id_option' => 'cloud inline',
                                    'label' => $this->l('Cloud Inline')
                                ),
                                array(
                                    'id_option' => 'box',
                                    'label' => $this->l('Box')
                                ),
                                array(
                                    'id_option' => 'box inline',
                                    'label' => $this->l('Box Inline')
                                ),
                                array(
                                    'id_option' => 'box wide',
                                    'label' => $this->l('Box Wide')
                                ),
                                array(
                                    'id_option' => 'bar',
                                    'label' => $this->l('Bar')
                                ),
                                array(
                                    'id_option' => 'bar wide',
                                    'label' => $this->l('Bar Wide')
                                )
                            ],
                                'id' => 'id_option',
                                'name' => 'label',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Settings modal Layout'),
                        'name' => self::CC_SETTINGS_LAYOUT,
                        'desc' => $this->l('Choose layout of settings'),
                        'options' => array(
                            'query' => [
                                array(
                                    'id_option' => 'box',
                                    'label' => $this->l('Box')
                                ),
                                array(
                                    'id_option' => 'bar',
                                    'label' => $this->l('Bar')
                                ),
                            ],
                                'id' => 'id_option',
                                'name' => 'label',
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Functionality Cookie section'),
                        'name' => self::CC_DISPLAY_SECTION_FUNCTION,
                        'is_bool' => true,
                        'desc' => $this->l('Enable Functionality Cookie section in front office'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Customise Cookie section'),
                        'name' => self::CC_DISPLAY_SECTION_CUSTOMISE,
                        'is_bool' => true,
                        'desc' => $this->l('Enable Customise Cookie section in front office'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Security Cookie section'),
                        'name' => self::CC_DISPLAY_SECTION_SECURITY,
                        'is_bool' => true,
                        'desc' => $this->l('Enable Security Cookie section in front office'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Ads Cookie section'),
                        'name' => self::CC_DISPLAY_SECTION_ADS,
                        'is_bool' => true,
                        'desc' => $this->l('Enable Ads Cookie section in front office'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Enable Analytics Cookie section'),
                        'name' => self::CC_DISPLAY_SECTION_ANALYTICS,
                        'is_bool' => true,
                        'desc' => $this->l('Enable Analytics Cookie section in front office'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Auto Clear Cookie'),
                        'name' => self::CC_AUTO_CLEAR,
                        'is_bool' => true,
                        'desc' => $this->l('Enable Auto Clear Cookies if refused'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Theme'),
                        'name' => self::CC_THEME,
                        'desc' => $this->l('Choose cookie consent theme'),
                        'options' => array(
                            'query' => [
                                array(
                                    'id_option' => 'light',
                                    'label' => $this->l('Light Theme')
                                ),
                                array(
                                    'id_option' => 'dark',
                                    'label' => $this->l('Dark Theme')
                                ),
                            ],
                            'id' => 'id_option',
                            'name' => 'label',
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array (
            self::CC_FORCE_CONSENT => Configuration::get(self::CC_FORCE_CONSENT, null, null, null, false),
            self::CC_CONSENT_POSITION => Configuration::get(self::CC_CONSENT_POSITION, null, null, null, "bottom right"),
            self::CC_CONSENT_LAYOUT => Configuration::get(self::CC_CONSENT_LAYOUT, null, null, null, "cloud"),
            self::CC_SETTINGS_LAYOUT => Configuration::get(self::CC_SETTINGS_LAYOUT,null, null, null,  "box"),
            self::CC_AUTO_CLEAR => Configuration::get(self::CC_AUTO_CLEAR,null, null, null,  false),
            self::CC_DISPLAY_SECTION_ADS => Configuration::get(self::CC_DISPLAY_SECTION_ADS, null, null, null, true),
            self::CC_DISPLAY_SECTION_ANALYTICS => Configuration::get(self::CC_DISPLAY_SECTION_ANALYTICS, null, null, null, true),
            self::CC_DISPLAY_SECTION_FUNCTION => Configuration::get(self::CC_DISPLAY_SECTION_FUNCTION, null, null, null, true),
            self::CC_DISPLAY_SECTION_CUSTOMISE => Configuration::get(self::CC_DISPLAY_SECTION_CUSTOMISE, null, null, null, true),
            self::CC_DISPLAY_SECTION_SECURITY => Configuration::get(self::CC_DISPLAY_SECTION_SECURITY, null, null, null, true),
            self::CC_THEME => Configuration::get(self::CC_THEME, null, null, null, true)
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookdisplayHeader()
    {
        $this->context->controller->registerStylesheet('cookie-consent-css', $this->_path . '/views/css/front.css');

        $this->context->controller->registerStylesheet('cookieconsent-css', 'https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@v3.0.0-rc.13/dist/cookieconsent.css', ['server' => 'remote']);
        $this->context->controller->registerJavascript('cookieconsent-js', 'https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@v3.0.0-rc.13/dist/cookieconsent.umd.js', ['server' => 'remote', 'position' => 'bottom']);
        $this->context->controller->registerJavascript('cookieconsent-init', $this->_path . '/views/js/cookieconsent-init.min.js', ['position' => 'bottom']);
        $this->context->controller->registerJavascript('gtag-consent-init', $this->_path . '/views/js/gtag-consent-init.min.js', ['position' => 'head', 'priority' => 1]);

        $cookieCategories = [];
        $sections = [];
        if(Configuration::get(self::CC_DISPLAY_SECTION_FUNCTION, true)) {
            $cookieCategories['functionality_storage'] = [
                'enabled' => true,
                'readOnly' => true
            ];

            $sections[] = [
                'title' => $this->trans('Strictly Necessary cookies', [], 'Modules.Cookieconsent.Modal'),
                'description' => $this->trans('These cookies are essential for the proper functioning of the website and cannot be disabled.', [], 'Modules.Cookieconsent.Modal'),
                'linkedCategory' => 'functionality_storage'              
            ];
        }

        if(Configuration::get(self::CC_DISPLAY_SECTION_CUSTOMISE, true)) {
            $cookieCategories['personalization_storage'] = [
                'enabled' => false,
                'readOnly' => false
            ];

            $sections[] = [
                'title' => $this->trans('Personalization cookies', [], 'Modules.Cookieconsent.Modal'),
                'description' => $this->trans('Personalisation cookies may use third party cookies to help them personalise content and track users across different websites and devices.', [], 'Modules.Cookieconsent.Modal'),
                'linkedCategory' => 'personalization_storage'              
            ];
        }
        
        if(Configuration::get(self::CC_DISPLAY_SECTION_SECURITY, true)) {
            $cookieCategories['security_storage'] = [
                'enabled' => false,
                'readOnly' => false
            ];

            $sections[] = [
                'title' => $this->trans('Security cookies', [], 'Modules.Cookieconsent.Modal'),
                'description' => $this->trans('Security cookies allows storage of security-related information, such as authentication, fraud protection, and other means to protect the user.', [], 'Modules.Cookieconsent.Modal'),
                'linkedCategory' => 'security_storage'              
            ];
        }

        if(Configuration::get(self::CC_DISPLAY_SECTION_ANALYTICS, true)) {
            $cookieCategories['analytics_storage'] = [
                'enabled' => false,
                'readOnly' => false
            ];

            $sections[] = [
                'title' => $this->trans('Analytics cookies', [], 'Modules.Cookieconsent.Modal'),
                'description' => $this->trans('Analytics cookies allow us to measure the performance of our website and our advertising campaigns. We use them to determine the number of visits and sources of visits to our website. We process the data obtained through these cookies in aggregate, without using identifiers that point to specific users of our website. If you disable the use of analytics cookies in relation to your visit, we lose the ability to analyse performance and optimise our measures.', [], 'Modules.Cookieconsent.Modal'),
                'linkedCategory' => 'analytics_storage'              
            ];
        }

        if(Configuration::get(self::CC_DISPLAY_SECTION_ADS, true)) {
            $cookieCategories['ad_storage'] = [
                'enabled' => false,
                'readOnly' => false
            ];

            $sections[] = [
                'title' => $this->trans('Ad cookies', [], 'Modules.Cookieconsent.Modal'),
                'description' => $this->trans('Advertising cookies are used by us or our partners to show you relevant content or advertisements both on our site and on third party sites. This enables us to create profiles based on your interests, so-called pseudonymised profiles. Based on this information, it is generally not possible to directly identify you as a person, as only pseudonymised data is used. Unless you express your consent, you will not receive content and advertisements tailored to your interests.', [], 'Modules.Cookieconsent.Modal'),
                'linkedCategory' => 'ad_storage'              
            ];
        }

        array_unshift( $sections, [ 'description' => $this->trans('From this section you can manager your preferences enabling or disabling cookie by category. You can change your preferences in any time clicking on button "Manager Preferences"', [], 'Modules.Cookieconsent.Modal') ]);
        array_push($sections, 
            [
                'title' => $this->trans('Your consent details', [], 'Modules.Cookieconsent.Modal'),
                'description' => '<p>' . $this->trans('Consent Id', [], 'Modules.Cookieconsent.Modal') . ': <span id="consent-id">-</span></p><p>' . $this->trans('Consent Date', [], 'Modules.Cookieconsent.Modal') . ': <span id="consent-timestamp">-</span></p><p>' . $this->trans('Last Update', [], 'Modules.Cookieconsent.Modal') . ': <span id="last-consent-timestamp">-</span></p>'
            ],
            [
                'title' => $this->trans('More information', [], 'Modules.Cookieconsent.Modal'),
                'description'=> $this->trans('For any queries in relation to my policy on cookies and your choices, please [1]contact us[/1]', ['[1]' => '<a href="' . $this->context->link->getPageLink('contact') . '" target="_blank">', '[/1]' => '</a>'], 'Modules.Cookieconsent.Modal'),
            ]
        );

        $this->context->smarty->assign(
            [
                'theme' => Configuration::get(self::CC_THEME),
                'config' => json_encode([
                    "disablePageInteraction" => Configuration::get(self::CC_FORCE_CONSENT, null, null, null, true),
                    "autoClearCookies" => Configuration::get(self::CC_AUTO_CLEAR, null, null, null, false),
                    "guiOptions" => [
                        "consentModal" => [
                            'layout' =>  Configuration::get(self::CC_CONSENT_LAYOUT, null, null, null, "cloud"),
                            'position' => Configuration::get(self::CC_CONSENT_POSITION, null, null, null, "bottom right"),
                            'equalWeightButtons' => false,
                            'flipButtons' => false
                        ],
                        "preferencesModal" => [
                            'layout' => Configuration::get(self::CC_SETTINGS_LAYOUT, null, null, null, "box")
                        ],
                    ],
                    'auto_language' => 'browser',
                    'categories' => $cookieCategories,
                    'sections' => $sections,
                    'language' => [
                        'default' => $this->context->language->language_code,
                        'translations'=> [
                            $this->context->language->language_code => [
                                'consentModal' => [
                                    'title' => $this->trans('This website use cookies', [], 'Modules.Cookieconsent.Modal'),
                                    'description' => $this->trans('We use cookies to personalise content and ads, provide social media features and analyse our traffic. We also provide information about how you use our site to our web analytics, advertising and social media partners, who may combine it with other information you have provided to them or that they have collected based on your use of their services.', [], 'Modules.Cookieconsent.Modal'),
                                    'acceptAllBtn' => $this->trans('Accept all', [], 'Modules.Cookieconsent.Modal'),
                                    'acceptNecessaryBtn' => $this->trans('Reject all', [], 'Modules.Cookieconsent.Modal'),
                                    'showPreferencesBtn' => $this->trans('Manage preferences', [], 'Modules.Cookieconsent.Modal'),
                                ],
                                'preferencesModal' => [
                                    'title' => $this->trans('Manage cookie preferences', [], 'Modules.Cookieconsent.Modal'),
                                    'acceptAllBtn' => $this->trans('Accept all', [], 'Modules.Cookieconsent.Modal'),
                                    'acceptNecessaryBtn' => $this->trans('Reject all', [], 'Modules.Cookieconsent.Modal'),
                                    'savePreferencesBtn' => $this->trans('Accept current selection', [], 'Modules.Cookieconsent.Modal'),
                                    'closeIconLabel' => $this->trans('Close', [], 'Modules.Cookieconsent.Modal'),
                                    'sections' => $sections
                                ]
                            ]
                        ]
                    ]

                ]),
            ]
        );
        return $this->display(__FILE__, "views/templates/front/hook/displayHeader.tpl");
    }

    public function hookDisplayFooter()
    {
        return $this->display(__FILE__, "views/templates/front/hook/displayFooter.tpl");
    }
}
