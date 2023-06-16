<?php 

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 *  Funzione che effettua l'upgrade del modulo
 */
function upgrade_module_1_0_3($module)
{
    Configuration::updateValue($module::CC_ENABLE_FLOAT_PREFERENCES, true);

    return true;
}