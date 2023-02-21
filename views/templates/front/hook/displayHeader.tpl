{literal}<script type="application/json" id="cookieconsent_i18n">{/literal}
    {ldelim}
    "modal_trigger_title": "{l s='Cookie settings' mod='cookieconsent'}",

    "consent_modal_title":  "{l s='We use cookies!' mod='cookieconsent'}",
    "consent_modal_description":  "{l s='This website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. The latter will be set only after consent.' mod='cookieconsent'}",
    "consent_modal_primary_btn":  "{l s='I agree' mod='cookieconsent'}",
    "consent_modal_secondary_btn_settings":  "{l s='Customize' mod='cookieconsent'}",
    "consent_modal_secondary_btn_accept_necessary":  "{l s='Accept necessary' mod='cookieconsent'}",

    "settings_modal_title":  "{l s='Cookie settings' mod='cookieconsent'}",
    "settings_modal_save_settings_btn":  "{l s='Save settings' mod='cookieconsent'}",
    "settings_modal_accept_all_btn":  "{l s='Accept all' mod='cookieconsent'}",
    "settings_modal_reject_all_btn":  "{l s='Accept necessary' mod='cookieconsent'}",
    "settings_modal_close_btn_label":  "{l s='Close' mod='cookieconsent'}",

    "settings_modal_before_consent_title":  "{l s='Cookie usage' mod='cookieconsent'}",
    "settings_modal_before_consent_description":  "{l s='We use cookies to ensure the basic functionalities of the website and to enhance your online experience. You can choose for each category to opt-in/out whenever you want.' mod='cookieconsent'}",

    "settings_modal_after_consent_title":  "{l s='More information' mod='cookieconsent'}",
    "settings_modal_after_consent_description":  "{l s='For any queries in relation to my policy on cookies and your choices, please contact us.' mod='cookieconsent'}",

    "functionality_storage_title":  "{l s='Functionality cookies' mod='cookieconsent'}",
    "functionality_storage_description":  "{l s='These cookies are necessary for the proper functioning of our website. Without these cookies, the website might not be working properly.' mod='cookieconsent'}",

    "personalization_storage_title":  "{l s='Personalization cookies' mod='cookieconsent'}",
    "personalization_storage_description":  "{l s='Personalisation cookies may use third party cookies to help them personalise content and track users across different websites and devices.' mod='cookieconsent'}",

    "security_storage_title":  "{l s='Security cookies' mod='cookieconsent'}",
    "security_storage_description":  "{l s='Security cookies allows storage of security-related information, such as authentication, fraud protection, and other means to protect the user.' mod='cookieconsent'}",

    "ad_storage_title":  "{l s='Ad cookies' mod='cookieconsent'}",
    "ad_storage_description":  "{l s='Advertising cookies are used by us or our partners to show you relevant content or advertisements both on our site and on third party sites. This enables us to create profiles based on your interests, so-called pseudonymised profiles. Based on this information, it is generally not possible to directly identify you as a person, as only pseudonymised data is used. Unless you express your consent, you will not receive content and advertisements tailored to your interests.' mod='cookieconsent'}",

    "analytics_storage_title":  "{l s='Analytics cookies' mod='cookieconsent'}",
    "analytics_storage_description":  "{l s='Analytics cookies allow us to measure the performance of our website and our advertising campaigns. We use them to determine the number of visits and sources of visits to our website. We process the data obtained through these cookies in aggregate, without using identifiers that point to specific users of our website. If you disable the use of analytics cookies in relation to your visit, we lose the ability to analyse performance and optimise our measures.' mod='cookieconsent'}",

    "cookie_table_col_name":  "{l s='Name' mod='cookieconsent'}",
    "cookie_table_col_purpose":  "{l s='Description' mod='cookieconsent'}",
    "cookie_table_col_processing_time":  "{l s='Expiration' mod='cookieconsent'}",
    "cookie_table_col_provider":  "{l s='Provider' mod='cookieconsent'}",
    "cookie_table_col_type":  "{l s='Type' mod='cookieconsent'}",
    "cookie_table_col_link":  "{l s='Link' mod='cookieconsent'}",
    "cookie_table_col_link_find_out_more":  "{l s='Link' mod='cookieconsent'}",
    "cookie_table_col_category":  "{l s='Category' mod='cookieconsent'}",

    "processing_time_session":  "{l s='Session' mod='cookieconsent'}",
    "processing_time_persistent":  "{l s='Persistent' mod='cookieconsent'}",

    "cookie_type_1st_party":  "{l s='1st party' mod='cookieconsent'}",
    "cookie_type_3rd_party":  "{l s='3rd party' mod='cookieconsent'}",

    "find_out_more":  "{l s='find out more' mod='cookieconsent'}"
    {rdelim}

    {literal}</script>{/literal}
{literal}
<script type="text/javascript">{/literal}
    window.cc_wrapper_config = {$config nofilter};
{literal}</script>
{/literal}
{if $theme eq 'dark'}
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", () => {
  document.body.classList.toggle('c_darkmode');
});
</script>
{/if}
