<?php 

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 *  Funzione che effettua l'upgrade del modulo
 */
function upgrade_module_1_0_4($module)
{
    Configuration::updateValue($module::CC_FORCE_ANALYTICS, false);
    return true;
}